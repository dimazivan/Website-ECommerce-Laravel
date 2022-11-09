<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Umkms;
use App\Models\Customers;
use App\Models\Deadlines;
use App\Models\Orders;
use App\Models\Detail_orders;
use App\Models\Customs;
use App\Models\Estimations;
use App\Models\Expeditions;
use App\Models\Productions;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use PDF;
use Redirect;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $page = Orders::select(
            'orders.*',
            'orders.id as id_orders'
        )
        ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->whereNotIn('orders.status', ['Selesai'])
        ->orderBy('created_at', 'asc')
        ->distinct()
        ->get();

        $pagebawah = Orders::select(
            'orders.*',
            'orders.id as id_orders'
        )
        ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('orders.status', '=', 'Selesai')
        ->orderBy('created_at', 'asc')
        ->distinct()
        ->get();

        $deadline = Deadlines::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        // dd(
        //     $page,
        //     $now = Carbon::now(),
        //     $deadline,
        // );

        $pageactive = 'adminpenjualan';
        $title = "Halaman Transaksi Penjualan";
        return view('admin.pages.transaksi_penjualan.data_transaksi_penjualan', [
            'page' => $page,
            'pagebawah' => $pagebawah,
            'deadline' => $deadline,
            'pageactive' => $pageactive,
            'title' => $title,
        ]);
    }

    public function formpengiriman($id_penjualan)
    {
        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        try {
            $decrypted = decrypt($id_penjualan);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id_penjualan);

        $update = Carbon::now();

        $page = Orders::join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('orders.status', '=', "Pesanan Siap Dikirim")
        ->where('orders.id', '=', $newid)
        ->get();

        $cart = Detail_orders::select(
            'detail_orders.*',
            'orders.*',
            'products.name as products_name',
            'products.pict_1 as pict_1',
            'detail_orders.size as products_size',
            'detail_orders.qty as products_qty',
            'detail_orders.price as products_price',
            'detail_orders.subtotal as products_subtotal',
            'detail_products.qty as stok_sekarang',
        )
        ->join('products', 'products.id', '=', 'detail_orders.products_id')
        ->join('detail_products', 'detail_products.id', '=', 'detail_orders.detail_products_id')
        ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->where('detail_orders.orders_id', '=', $newid)
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->distinct()
        ->get();

        $shipping = Expeditions::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        // dd(
        //     $id_penjualan,
        //     $shipping,
        // );

        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        if (empty($shipping[0])) {
            Alert::info('Proses Gagal', 'Data Jasa Ekpedisi Kosong');
            return redirect('/jasa_ekspedisi/create');
        } else {
            if (empty($page[0])) {
                Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
                return view('admin.pages.error.page_404');
            } else {
                $tanggal = Carbon::parse($page[0]->date);
                $deadline = Deadlines::where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->get();
                $batas = $tanggal->addHours($deadline[0]->deadline);

                $pageactive = "adminpenjualan";
                $title = "Halaman Data Transaksi Penjualan";
                return view('admin.pages.transaksi_penjualan.pengiriman_penjualan', [
                'tanggal' => $tanggal,
                'shipping' => $shipping,
                'batas' => $batas,
                'page' => $page,
                'cart' => $cart,
                'pageactive' => $pageactive,
                'title' => $title,
                ]);
            }
        }
    }

    public function kirimpenjualan(Request $request)
    {
        // dd(
        //     $request->all(),
        // );

        try {
            $decrypted = decrypt($request->id);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($request->id);

        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        $update = Carbon::now()->toDateTimeString();

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $page = Orders::join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
        ->where('orders.id', $request->id_orders)
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('orders.status', '=', 'Pesanan Siap Dikirim')
        ->get();

        if (empty($page[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            if ($request->noresi != null && $request->id_orders != null) {
                DB::table('orders')
                ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
                ->where('orders.status', '=', "Pesanan Siap Dikirim")
                ->where('orders.id', $request->id_orders)
                ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'orders.no_resi' => $request->noresi,
                    'orders.status' => "Pesanan Sedang Dikirim",
                    'orders.status_payment' => "Lunas",
                    'orders.status_shipping' => "Proses Pengiriman",
                    'orders.tgl_pengiriman' => $update,
                    'orders.updated_at' => $update,
                ]);

                Alert::success('Proses Berhasil', 'Status pesanan berhasil diupdate');
                return redirect()->route('transaksi_penjualan.show', $newid);
            } else {
                Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
                return redirect()->route('pengiriman.penjualan', $newid);
            }
        }
    }

    public function acc_penjualan($id_penjualan)
    {
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        try {
            $decrypted = decrypt($id_penjualan);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id_penjualan);

        $page = Orders::join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
        ->where('orders.id', $newid)
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('orders.status', '=', 'Menunggu Konfirmasi')
        ->get();

        $cart = Detail_orders::select(
            'detail_orders.*',
            'orders.*',
            'products.name as products_name',
            'products.pict_1 as pict_1',
            'detail_orders.size as products_size',
            'detail_orders.qty as products_qty',
            'detail_orders.price as products_price',
            'detail_orders.subtotal as products_subtotal',
            'detail_products.qty as stok_sekarang',
        )
        ->join('products', 'products.id', '=', 'detail_orders.products_id')
        ->join('detail_products', 'detail_products.id', '=', 'detail_orders.detail_products_id')
        ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->where('detail_orders.orders_id', '=', $newid)
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->distinct()
        ->get();


        // dd(
        //     $idumkm,
        //     $idumkm[0]->umkms_id,
        //     $page,
        //     $page[0]->id,
        // );

        if (empty($page[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            $tanggal = Carbon::parse($page[0]->date);
            $deadline = Deadlines::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();
            $batas = $tanggal->addHours($deadline[0]->deadline);

            $pageactive = "adminpenjualan";
            $title = "Halaman Data Transaksi Penjualan";
            return view('admin.pages.transaksi_penjualan.acc_penjualan', [
            'page' => $page,
            'cart' => $cart,
            'tanggal' => $tanggal,
            'batas' => $batas,
            'pageactive' => $pageactive,
            'title' => $title,
            ]);
        }
    }

    public function accpembayaranpenjualan($id_penjualan)
    {
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        try {
            $decrypted = decrypt($id_penjualan);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id_penjualan);

        $update = Carbon::now()->toDateTimeString();

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        // Estimasi dulu
        $estimasi = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $tambah = 0;

        $cart = Detail_orders::select(
            'detail_orders.*',
            'detail_orders.id as id_detail_orders',
            'detail_orders.qty as jumlah_beli',
            'detail_products.qty as stok_sekarang',
            'orders.status',
            'orders.users_id as id_users',
        )
        ->join('detail_products', 'detail_products.id', '=', 'detail_orders.detail_products_id')
        ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->where('orders.status', '=', 'Menunggu Konfirmasi Pembayaran')
        ->where('detail_orders.orders_id', '=', $newid)
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        // $page = $cart->unique();
        if (empty($estimasi[0])) {
            Alert::warning('Proses Gagal', 'Data Estimasi Anda Kosong');
            return redirect()->route('estimasi.create');
        } else {
            if (empty($cart[0])) {
                Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
                return view('admin.pages.error.page_404');
            } else {
                if ($newid) {
                    // $j = 1;
                    $produksiada = 0;
                    for ($i=0; $i < sizeof($cart); $i++) {
                        if ($cart[$i]->stok_sekarang <= $cart[$i]->jumlah_beli) {
                            //Update Kosong
                            DB::table('orders')
                            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
                            ->where('orders.id', $newid)
                            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
                            ->update([
                                'orders.status' => "Proses Produksi",
                                'orders.status_payment' => "Lunas",
                                'orders.updated_at' => $update,
                            ]);

                            $cek_status = Productions::where('status', '=', 'Diproses')
                            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                            ->get();

                            $arr_waktu = [];
                            if (empty($cek_status[0])) {
                                for ($x=0; $x < sizeof($estimasi); $x++) {
                                    $waktu = Carbon::now();

                                    $tambah += $estimasi[$x]->durasi;

                                    $hasil = $waktu->addHours($tambah)->toDateTimeString();

                                    $isi[] = $hasil;
                                    $arr_waktu = $isi;
                                }

                                $awal[] = Carbon::now()->toDateTimeString();
                                $tgl_awal = array_merge($awal, $arr_waktu);

                                for ($z=0; $z < sizeof($arr_waktu); $z++) {
                                    // Produksi
                                    Productions::create([
                                        'umkms_id' => $idumkm[0]->umkms_id,
                                        'users_id' => $cart[$i]->id_users,
                                        'detail_orders_id' => $cart[$i]->id_detail_orders,
                                        'products_name' => $cart[$i]->products_name,
                                        'category' => $cart[$i]->category,
                                        'qty' => $cart[$i]->jumlah_beli,
                                        'size' => $cart[$i]->size,
                                        'color' => $cart[$i]->color,
                                        'status' => 'Diproses',
                                        'status_produksi' => $estimasi[$z]->name_process,
                                        'estimasi' => $estimasi[$z]->durasi/1,
                                        'tanggal_mulai' => $tgl_awal[$z],
                                        'tanggal_selesai' => $arr_waktu[$z],
                                    ]);
                                }

                                $produksiada = 1;
                            // $variabel = "berhasil";
                            } else {
                                // Menunggu
                                for ($z=0; $z < sizeof($estimasi); $z++) {
                                    // Produksi
                                    Productions::create([
                                        'umkms_id' => $idumkm[0]->umkms_id,
                                        'users_id' => $cart[$i]->id_users,
                                        'detail_orders_id' => $cart[$i]->id_detail_orders,
                                        'products_name' => $cart[$i]->products_name,
                                        'category' => $cart[$i]->category,
                                        'qty' => $cart[$i]->jumlah_beli,
                                        'size' => $cart[$i]->size,
                                        'color' => $cart[$i]->color,
                                        'status' => 'Menunggu',
                                        'status_produksi' => $estimasi[$z]->name_process,
                                        'estimasi' => $estimasi[$z]->durasi/1,
                                    ]);
                                }

                                $produksiada = 1;
                            }
                        } else {
                            $cek = Orders::join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
                            ->where('orders.id', $newid)
                            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
                            ->where('orders.status', '=', 'Menunggu Proses Produksi')
                            ->get();

                            $sisa = 0;
                            $sisa = $cart[$i]->stok_sekarang - $cart[$i]->jumlah_beli;
                            //Update Stok
                            DB::table('detail_products')->where('id', $cart[$i]->detail_products_id)
                            ->where('products_id', '=', $cart[$i]->products_id)
                            ->update([
                                'qty' => $sisa,
                            ]);

                            if (empty($cek[0]) && $produksiada == 0) {
                                // Update Ada Stock
                                DB::table('orders')
                                ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
                                ->where('orders.id', $newid)
                                ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
                                ->update([
                                    'orders.status' => "Pesanan Siap Dikirim",
                                    'orders.status_payment' => "Lunas",
                                    'orders.updated_at' => $update,
                                ]);
                            }
                        }
                    }
                    // dd(
                    //     $id_penjualan,
                    //     $update,
                    //     $cart,
                    //     sizeof($cart),
                    //     $cart[0]->stok_sekarang,
                    //     $cart[0]->jumlah_beli,
                    //     $cart[0]->stok_sekarang - $cart[0]->jumlah_beli,
                    //     $i,
                    //     $estimasi,
                    //     sizeof($estimasi),
                    //     $tambah,
                    //     $waktu,
                    //     $awal,
                    //     sizeof($arr_waktu),
                    //     $arr_waktu,
                    //     $tgl_awal,
                    //     $tgl_awal[1],
                    // );

                    Alert::success('Pembayaran diterima', 'Status pesanan berhasil diupdate');
                    return redirect()->route('transaksi_penjualan.show', $id_penjualan);
                } else {
                    Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
                    return redirect()->route('transaksi_penjualan.show', $id_penjualan);
                }
            }
        }
    }

    public function selesaipesanan($id_penjualan)
    {
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        try {
            $decrypted = decrypt($id_penjualan);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id_penjualan);

        $update = Carbon::now()->toDateTimeString();

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $page = Orders::join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
        ->where('orders.id', $newid)
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('orders.status', '=', 'Pesanan Sedang Dikirim')
        ->get();

        // dd(
        //     $id_penjualan,
        //     $update,
        // );
        if (empty($page[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            if ($newid) {
                DB::table('orders')
                ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
                ->where('orders.id', $newid)
                ->where('orders.status', "Pesanan Sedang Dikirim")
                ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'orders.status' => "Selesai",
                    'orders.status_shipping' => "Selesai",
                    'orders.updated_at' => $update,
                ]);

                Alert::success('Proses Berhasil', 'Status pesanan berhasil diupdate');
                return redirect()->route('transaksi_penjualan.show', $id_penjualan);
            } else {
                Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
                return redirect()->route('transaksi_penjualan.show', $id_penjualan);
            }
        }
    }

    public function tolakpembayaranpenjualan($id_penjualan)
    {
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        try {
            $decrypted = decrypt($id_penjualan);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id_penjualan);

        $update = Carbon::now()->toDateTimeString();

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        // dd(
        //     $id_penjualan,
        //     $update,
        // );

        if ($newid) {
            $cek = Orders::join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('orders.id', $newid)
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.status', '=', 'Menunggu Konfirmasi Pembayaran')
            ->get();

            if (empty($cek[0])) {
                Alert::warning('Proses Gagal', 'Data tidak ditemukan');
                return redirect()->route('transaksi_penjualan.show', $id_penjualan);
            } else {
                DB::table('orders')
                ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
                ->where('orders.id', $newid)
                ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'orders.status' => "Menunggu Pembayaran",
                    'orders.status_payment' => "Ditangguhkan",
                    'orders.updated_at' => $update,
                ]);

                Alert::warning('Pembayaran ditolak', 'Status pesanan berhasil diupdate');
                return redirect()->route('transaksi_penjualan.show', $id_penjualan);
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect()->route('transaksi_penjualan.show', $id_penjualan);
        }
    }

    public function tolakpesananpenjualan($id_penjualan)
    {
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        try {
            $decrypted = decrypt($id_penjualan);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id_penjualan);

        $update = Carbon::now()->toDateTimeString();

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        // dd(
        //     $id_penjualan,
        //     $update,
        // );

        if ($newid != null) {
            $cek = Orders::join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('orders.id', $newid)
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            // ->where('orders.status', '=', 'Menunggu Konfirmasi Pembayaran')
            ->where('orders.status', '=', 'Menunggu Konfirmasi')
            ->get();

            if (empty($cek[0])) {
                Alert::warning('Proses Gagal', 'Data tidak ditemukan');
                return redirect()->route('transaksi_penjualan.show', $id_penjualan);
            } else {
                DB::table('orders')
                ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
                ->where('orders.id', $newid)
                ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'orders.status' => "Pesanan Ditolak",
                    'orders.status_payment' => "Pesanan Ditolak",
                    'orders.updated_at' => $update,
                ]);

                Alert::info('Pesanan ditolak', 'Status pesanan berhasil diupdate');
                return redirect()->route('transaksi_penjualan.show', $id_penjualan);
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect()->route('transaksi_penjualan.show', $id_penjualan);
        }
    }

    public function pdflaporan(Request $request)
    {
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $nama_umkm = Umkms::where('id', '=', $idumkm[0]->umkms_id)
        ->get();

        $awal = "";
        $akhir = "";

        if ($request->dtawal > $request->dtakhir && $request->dtakhir != null) {
            Alert::info('Proses Gagal', 'Perhatikan kembali nilai tanggal');
            return Redirect::back();
        }

        if ($request->dtakhir == null && $request->dtawal != null) {
            $page = Orders::select(
                'orders.*',
            )
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.date', '>=', $request->dtawal)
            ->where('orders.status', '=', "Selesai")
            ->distinct()
            ->get();

            $total = Orders::select(
                'orders.*',
            )
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.date', '>=', $request->dtawal)
            ->where('orders.status', '=', "Selesai")
            ->distinct()
            ->sum('orders.total');

            $jumlah = sizeof($page);

            $awal = $request->dtawal;
            $akhir = "";
        } elseif ($request->dtawal == null && $request->dtakhir != null) {
            $page = Orders::select(
                'orders.*',
            )
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.date', '<=', $request->dtakhir)
            ->where('orders.status', '=', "Selesai")
            ->distinct()
            ->get();

            $total = Orders::select(
                'orders.*',
            )
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.date', '<=', $request->dtakhir)
            ->where('orders.status', '=', "Selesai")
            ->distinct()
            ->sum('orders.total');

            $jumlah = sizeof($page);

            $awal = "";
            $akhir = $request->dtakhir;
        } elseif ($request->dtawal != null && $request->dtakhir != null) {
            $page = Orders::select(
                'orders.*',
            )
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.date', '>=', $request->dtawal)
            ->where('orders.date', '<=', $request->dtakhir)
            ->where('orders.status', '=', "Selesai")
            ->distinct()
            ->get();

            $total = Orders::select(
                'orders.*',
            )
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.date', '>=', $request->dtawal)
            ->where('orders.date', '<=', $request->dtakhir)
            ->where('orders.status', '=', "Selesai")
            ->distinct()
            ->sum('orders.total');

            $jumlah = sizeof($page);

            $awal = $request->dtawal;
            $akhir = $request->dtakhir;
        } else {
            $page = Orders::select(
                'orders.*',
            )
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.status', '=', "Selesai")
            ->distinct()
            ->get();

            $total = Orders::select(
                'orders.*',
            )
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.status', '=', "Selesai")
            ->distinct()
            ->sum('orders.total');

            $jumlah = sizeof($page);
        }

        if (empty($page[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            $cetak = PDF::loadview('admin.pages.transaksi_penjualan.laporan_order', [
                'page'=>$page,
                'awal'=>$awal,
                'akhir'=>$akhir,
                'total'=>$total,
                'jumlah'=>$jumlah,
                'nama_umkm'=>$nama_umkm,
            ])->setPaper('a4', 'landscape');

            // Tester
            // return view('admin.pages.transaksi_penjualan.laporan_order', [
            //     'page'=>$page,
            //     'awal'=>$awal,
            //     'akhir'=>$akhir,
            //     'total'=>$total,
            //     'jumlah'=>$jumlah,
            //     'nama_umkm'=>$nama_umkm,
            // ]);
            return $cetak->download('Laporan Transaksi Penjualan, Periode '.
            $awal.'-'.$akhir.'.pdf');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
        // return view('admin.pages.error.page_404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        $date = Carbon::now()->toDateString();
        $update = Carbon::now();

        // dd(
        //     $request->all(),
        //     $date,
        //     $update,
        // );

        if ($request->all() != null) {
            if ($request->sub <= 0) {
                Alert::warning('Proses Gagal', 'Inputan subtotal tidak boleh bernilai kurang dari atau sama dengan 0');
                return redirect()->route('transaksi_penjualan.show', $request->id);
            } else {
                if ($request->ongkir <= 0) {
                    Alert::warning('Proses Gagal', 'Inputan ongkir tidak boleh bernilai kurang dari atau sama dengan 0');
                    return redirect()->route('transaksi_penjualan.show', $request->id);
                } else {
                    DB::table('orders')->where('id', $request->id)->update([
                        'total' => $request->total,
                        'ongkir' => $request->ongkir,
                        'status' => 'Menunggu Pembayaran',
                        'status_payment' => 'Menunggu Pembayaran',
                        'updated_at' => $update,
                        ]);
                    Alert::success('Pesanan berhasil diupdate', 'Cek status pesanan pada halaman pesanan');
                    return redirect('transaksi_penjualan');
                }
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect()->route('transaksi_penjualan.show', $request->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        try {
            $decrypted = decrypt($id);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id);

        $update = Carbon::now();

        $page = Orders::select(
            'orders.*',
            'orders.created_at as waktu_masuk',
            'detail_orders.*',
            'feedback_orders.desc as feedback_orders',
        )
        ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
        ->leftjoin('feedback_orders', 'feedback_orders.orders_id', '=', 'orders.id')
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('orders.id', '=', $newid)
        ->get();

        $cart = Detail_orders::select(
            'detail_orders.*',
            'orders.*',
            'products.name as products_name',
            'products.pict_1 as pict_1',
            'detail_orders.size as products_size',
            'detail_orders.qty as products_qty',
            'detail_orders.price as products_price',
            'detail_orders.subtotal as products_subtotal',
            'detail_products.qty as stok_sekarang',
        )
        ->join('products', 'products.id', '=', 'detail_orders.products_id')
        ->join('detail_products', 'detail_products.id', '=', 'detail_orders.detail_products_id')
        ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->where('detail_orders.orders_id', '=', $newid)
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->distinct()
        ->get();

        // Query Update Produksi
        $prod = Productions::select(
            'orders.first_name as nama_depan',
            'orders.last_name as nama_belakang',
            'detail_orders.id as id_detail_orders',
            'productions.*',
            'productions.id as id_produksi',
        )
        ->join('detail_orders', 'detail_orders.id', '=', 'productions.detail_orders_id')
        ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->where('productions.umkms_id', '=', $idumkm[0]->umkms_id)
        ->distinct()
        ->get();

        $waktu = Carbon::now();

        // dd(
        //     $prod,
        //     $prod[0]->id,
        //     $prod[0]->tanggal_selesai,
        //     sizeof($prod),
        //     $waktu,
        // );

        for ($i=0; $i < sizeof($prod); $i++) {
            if ($prod[$i]->tanggal_selesai <= $waktu) {
                DB::table('productions')->where('id', $prod[$i]->id)
                ->where('status', '=', 'Diproses')
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => 'Selesai',
                ]);
            }
        }

        // Query Update Pesanan
        // $produksi = Productions::select(
        //     'productions.*',
        // )
        // ->join('detail_orders', 'detail_orders.id', '=', 'productions.detail_orders_id')
        // ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        // ->where('detail_orders.orders_id', '=', $id)
        // ->where('productions.umkms_id', '=', $idumkm[0]->umkms_id)
        // ->orderBy('productions.id', 'desc')
        // ->first();

        $produksi = Productions::select(
            'productions.*',
        )
        ->join('detail_orders', 'detail_orders.id', '=', 'productions.detail_orders_id')
        ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->where('detail_orders.orders_id', '=', $newid)
        ->where('productions.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('productions.status', '=', "Diproses")
        ->orWhere('productions.status', '=', "Menunggu")
        ->get();

        // if ($produksi != null) {
        //     if ($produksi->status == 'Selesai') {
        //         DB::table('orders')->where('id', $id)
        //         ->where('status', '=', 'Proses Produksi')
        //         ->update([
        //             'status' => 'Pesanan Siap Dikirim',
        //             'updated_at' => $update,
        //         ]);
        //     }
        // }

        if (empty($produksi[0])) {
            DB::table('orders')->where('id', $newid)
            ->where('status', '=', 'Proses Produksi')
            ->update([
                'status' => 'Pesanan Siap Dikirim',
                'updated_at' => $update,
            ]);
        }


        // dd(
        //     $id,
        //     $idumkm,
        //     $idumkm[0]->umkms_id,
        //     $page[0]->status_payment,
        //     $page,
        //     $cart,
        //     $produksi,
        //     $produksi->id,
        //     $produksi->status,
        // );

        // dd(
        //     $page,
        //     $page[0]->created_at,
        //     $page[0]->waktu_masuk,
        // );

        if (empty($page[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            $deadline = Deadlines::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            $tanggal = Carbon::parse($page[0]->waktu_masuk);
            $batas = $tanggal->addHours($deadline[0]->deadline);

            $pageactive = "adminpenjualan";
            $title = "Halaman Data Transaksi Penjualan";
            return view('admin.pages.transaksi_penjualan.detail_penjualan', [
                'tanggal' => $tanggal,
                'batas' => $batas,
                'page' => $page,
                'cart' => $cart,
                'pageactive' => $pageactive,
                'title' => $title,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
        // return view('admin.pages.error.page_404');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
        // return view('admin.pages.error.page_404');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
        // return view('admin.pages.error.page_404');
    }
}
