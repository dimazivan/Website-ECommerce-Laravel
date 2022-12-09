<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\User;
use App\Models\Umkms;
use App\Models\Orders;
use App\Models\Detail_orders;
use App\Models\Customs;
use App\Models\Estimations;
use App\Models\Feedback_orders;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Redirect;

class Customer_orderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
        // return redirect('/error');
    }

    public function bayarpenjualan($id_transaksi)
    {
        $info = Info::first();
        $title = "Form Pembayaran Transaksi Penjualan";
        $pageactive = "pembayaranpenjualan";

        try {
            $decrypted = decrypt($id_transaksi);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id_transaksi);

        $page = Detail_orders::select(
            'Orders.*',
            'Detail_orders.*',
            'products.name as products_name',
            'products.pict_1',
            'Detail_orders.qty as products_qty',
            'Detail_orders.price as products_price',
            'Detail_orders.subtotal as products_subtotal',
            'umkms.umkm_name as nama_umkm',
        )
        ->join('products', 'products.id', '=', 'detail_orders.products_id')
        ->join('detail_products', 'detail_products.id', '=', 'detail_orders.detail_products_id')
        ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->join('umkms', 'umkms.id', '=', 'detail_orders.umkms_id')
        ->where('detail_orders.orders_id', '=', $newid)
        ->where('orders.status', '=', 'Menunggu Pembayaran')
        ->orWhere('orders.status_payment', '=', 'Ditangguhkan')
        ->distinct()
        ->get();

        $promos = Orders::join('promos', 'promos.id', '=', 'orders.promos_id')
        ->where('orders.id', '=', $newid)
        ->get();

        $user = Orders::where("orders.users_id", auth()->user()->id)
        ->get();

        // return redirect('/error');

        // dd(
        //     $page,
        // );

        // dd(
        //     $page,
        //     $page[0]->id,
        //     $page[0]->orders_id,
        //     $page[0]->first_name,
        // );

        if (empty($page[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return redirect('/error');
        } else {
            return view('customer.pages.order.pembayaran_penjualan', [
            'page' => $page,
            'promos' => $promos,
            'user' => $user,
            'title' => $title,
            'info' => $info,
            'pageactive' => $pageactive,
            ]);
        }
        //
    }

    public function feedbackorder(Request $request)
    {
        $waktu = Carbon::now();
        $umkms_id = Umkms::where('umkm_name', '=', $request->umkm_name)
        ->get();

        // dd(
        //     $request->all(),
        //     $waktu,
        //     $umkms_id[0]->id,
        // );

        if ($request->desc != null) {
            //insert
            Feedback_orders::create([
                'umkms_id' => $umkms_id[0]->id,
                'orders_id' => $request->id_order,
                'rating' => 0,
                'desc' => $request->desc,
                'created_at' => $waktu,
            ]);

            Alert::success('Feedback Diterima', 'Terima kasih telah melakukan transaksi');
            return redirect('/');
        } else {
            Alert::info('Proses Gagal', 'Inputan tidak boleh kosong');
            return Redirect::back();
        }
    }

    public function listitem($id_transaksi)
    {
        $info = Info::first();
        $title = "List Item";
        $pageactive = "listitem";

        try {
            $decrypted = decrypt($id_transaksi);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id_transaksi);

        // dd(
        //     $id_transaksi,
        // );

        if ($id_transaksi != null) {
            $orders = Orders::select(
                'orders.id as id_orders',
                'orders.*',
                'users.*',
                'orders.updated_at',
                'detail_orders.umkms_id as id_umkm',
                'promos.name as nama_promo'
            )
            ->join('users', 'users.id', '=', 'orders.users_id')
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->leftjoin('promos', 'promos.id', '=', 'orders.promos_id')
            ->where('orders.id', '=', $newid)
            ->get();

            $page = Detail_orders::select(
                'detail_orders.price as harga',
                'detail_orders.subtotal as sub',
                'detail_orders.qty as jumlah',
                'products.name as nama_produk',
                'detail_products.size as ukuran_produk',
                'detail_products.color as warna_produk',
            )
            ->where('orders_id', '=', $newid)
            ->join('products', 'products.id', '=', 'detail_orders.products_id')
            ->join('detail_products', 'detail_products.id', '=', 'detail_orders.detail_products_id')
            ->get();

            // dd(
            //     $page,
            // );

            if (empty($page[0])) {
                Alert::info('Proses Gagal', 'Data tidak ditemukan');
                return redirect('/error');
            } else {
                return view('customer.pages.order.listitem', [
                    'page' => $page,
                    'orders' => $orders,
                    'title' => $title,
                    'info' => $info,
                    'pageactive' => $pageactive,
                ]);
            }
        } else {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return redirect('/error');
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
        // return redirect('/error');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
        // return redirect('/error');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $decrypted = decrypt($id);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id);

        $orders = Orders::select(
            'orders.*',
            'orders.id as id_penjualan',
            'orders.date as tanggal',
            'orders.updated_at as last_updated',
            'umkms.umkm_name as nama_umkm',
            'detail_orders.*',
            'products.*',
            'detail_products.*',
            'products.name as products_name',
            'detail_orders.qty as products_qty',
            'detail_orders.price as products_price',
            'detail_orders.subtotal as products_subtotal',
        )
        ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
        ->join('products', 'products.id', '=', 'detail_orders.products_id')
        ->join('detail_products', 'detail_products.id', '=', 'detail_orders.detail_products_id')
        ->join('umkms', 'umkms.id', '=', 'detail_orders.umkms_id')
        ->where('orders.id', '=', $newid)
        ->where('orders.status_payment', '=', 'Lunas')
        ->get();


        // Cek feedback
        $cek = Feedback_orders::where('orders_id', '=', $newid)
        ->get();

        // dd(
        //     $id,
        //     $orders,
        // );

        $info = Info::first();
        $title = 'Feedback Transaksi Penjualan';
        $pageactive = 'feedbackpenjualan';

        if (empty($orders[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return redirect('/error');
        } else {
            if (empty($cek[0])) {
                return view('customer.pages.order.feedback_order', [
                    // 'page' => $page,
                    'orders' => $orders,
                    'title' => $title,
                    'info' => $info,
                    'pageactive' => $pageactive,
                ]);
            } else {
                Alert::info('Proses Gagal', 'Anda pernah melakukan feedback');
                return redirect('/');
            }
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
        // return redirect('/error');
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
        // dd(
        //     $request->all(),
        // );

        $update = Carbon::now();

        try {
            $decrypted = decrypt($id);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id);

        if ($request->all() != null) {
            //validasi file
            if ($request->pict_payment != null) {
                // Ukuran gambar
                if (filesize($request->pict_payment) > 1000 * 10000) {
                    // Alert::warning('Proses Gagal', 'Ukuran File Gambar Harus Kurang dari 10MB');
                    // return redirect()->route("bayarpenjualan.create", $id);
                    return back()->with("info", "Ukuran File Gambar Harus Kurang dari 10MB");
                } else {
                    // Cek Tipe Gambar
                    if ($request->pict_payment->getClientOriginalExtension() == "jpg" ||
                    $request->pict_payment->getClientOriginalExtension() == "jpeg" ||
                    $request->pict_payment->getClientOriginalExtension() == "png") {
                        // Insert Database
                        $file = $request->file('pict_payment');
                        $nama_file = time() . "_" . $file->getClientOriginalName();

                        $tujuan_upload = 'data_file/pembayaran';
                        $file->move($tujuan_upload, $nama_file);

                        DB::table('orders')->where('id', $request->id)->update([
                        'pict_payment' => $nama_file,
                        'status' => 'Menunggu Konfirmasi Pembayaran',
                        'status_payment' => 'Menunggu Konfirmasi Pembayaran',
                        'updated_at' => $update,
                        ]);

                        Alert::success('Berhasil upload bukti pembayaran', 'Cek status pesanan pada halaman history');
                        return redirect('/');
                    } else {
                        // Alert::warning('Proses Gagal', 'Jenis File Bukti Pembayaran Harus Gambar');
                        // return redirect()->route("bayarpenjualan.create", $id);
                        return back()->with("info", "Jenis File Bukti Pembayaran Harus Gambar");
                    }
                }
            } else {
                Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
                return redirect()->route("bayarpenjualan.create", $id);
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect()->route("bayarpenjualan.create", $id);
        }
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
        // return redirect('/error');
    }
}
