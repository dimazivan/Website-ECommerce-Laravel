<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customers;
use App\Models\Deadlines;
use App\Models\Estimations;
use App\Models\Expeditions;
use App\Models\Production_customs;
use App\Models\Orders;
use App\Models\Customs;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use PDF;
use Redirect;

class Custom_orderController extends Controller
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

        $page = Customs::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->whereNotIn('customs.status', ['Selesai'])
        ->orderBy('created_at', 'asc')
        ->get();

        $pagebawah = Customs::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('customs.status', '=', 'Selesai')
        ->orderBy('created_at', 'asc')
        ->get();

        $deadline = Deadlines::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        // dd(
        //     $idumkm,
        //     $idumkm[0]->umkms_id,
        //     $page,
        //     $deadline[0]->deadline,
        // );

        $pageactive = "admincustom";
        $title = "Halaman Data Transaksi Custom";
        return view('admin.pages.custom.data_custom', [
            'page' => $page,
            'pagebawah' => $pagebawah,
            'deadline' => $deadline,
            'pageactive' => $pageactive,
            'title' => $title,
        ]);
    }

    public function formpengiriman($id_custom)
    {
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        try {
            $decrypted = decrypt($id_custom);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id_custom);

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $update = Carbon::now();

        $page = Customs::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('id', '=', $newid)
        ->where('status', '=', 'Pesanan Siap Dikirim')
        ->get();

        $shipping = Expeditions::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        // dd(
        //     $id_custom,
        //     $shipping,
        //     $page,
        // );

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

                $pageactive = "admincustom";
                $title = "Halaman Data Transaksi Custom";
                return view('admin.pages.custom.pengiriman_custom', [
                    'shipping' => $shipping,
                    'page' => $page,
                    'tanggal' => $tanggal,
                    'batas' => $batas,
                    'pageactive' => $pageactive,
                    'title' => $title,
                ]);
            }
        }
    }

    public function kirimcustom(Request $request)
    {
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $update = Carbon::now();

        $page = Customs::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('id', '=', $request->id_orders)
        ->where('status', '=', 'Pesanan Siap Dikirim')
        ->get();

        // dd(
        //     $request->all(),
        //     $page,
        // );

        if (empty($page[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            if ($request->noresi != null && $request->id_orders != null) {
                DB::table('customs')
                ->where('id', $request->id_orders)
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'no_resi' => $request->noresi,
                    'status' => "Pesanan Sedang Dikirim",
                    'status_payment' => "Lunas",
                    'status_shipping' => "Proses Pengiriman",
                    'tgl_pengiriman' => $update,
                    'updated_at' => $update,
                ]);

                Alert::success('Proses Berhasil', 'Status pesanan berhasil diupdate');
                return redirect()->route('transaksi_custom.show', Crypt::encrypt($request->id_orders));
            } else {
                Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
                return redirect()->route('pengiriman.custom', Crypt::encrypt($request->id_orders));
            }
        }
    }

    public function acc_custom($id_custom)
    {
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        try {
            $decrypted = decrypt($id_custom);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id_custom);

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $page = Customs::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('id', '=', $newid)
        ->where('status', '=', 'Menunggu Konfirmasi')
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

            $pageactive = "admincustom";
            $title = "Halaman Data Transaksi Custom";
            return view('admin.pages.custom.acc_custom', [
                'page' => $page,
                'tanggal' => $tanggal,
                'batas' => $batas,
                'pageactive' => $pageactive,
                'title' => $title,
            ]);
        }
    }

    public function accpembayaran($id_custom)
    {
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        try {
            $decrypted = decrypt($id_custom);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id_custom);

        $update = Carbon::now()->toDateTimeString();

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        // Estimasi dulu
        $estimasi = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $tambah = 0;

        $customs = Customs::where('status', '=', 'Menunggu Konfirmasi Pembayaran')
        ->where('id', '=', $newid)
        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        // dd(
        //     $id_custom,
        //     $update,
        //     $estimasi,
        //     $customs,
        // );

        if (empty($estimasi[0])) {
            Alert::warning('Proses Gagal', 'Data Estimasi Anda Kosong');
            return redirect()->route('estimasi.create');
        } else {
            if (empty($customs[0])) {
                Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
                return view('admin.pages.error.page_404');
            } else {
                if ($newid) {
                    for ($i=0; $i < sizeof($customs); $i++) {
                        DB::table('customs')
                        ->where('id', $newid)
                        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                        ->update([
                            'status' => "Proses Produksi",
                            'status_payment' => "Lunas",
                            'updated_at' => $update,
                        ]);

                        $cek_status = Production_customs::where('status', '=', 'Diproses')
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
                                Production_customs::create([
                                    'umkms_id' => $idumkm[0]->umkms_id,
                                    'users_id' => $customs[$i]->users_id,
                                    'customs_id' => $customs[$i]->id,
                                    'qty' => $customs[$i]->qty,
                                    'status' => 'Diproses',
                                    'status_produksi' => $estimasi[$z]->name_process,
                                    'estimasi' => $estimasi[$z]->durasi/1,
                                    'tanggal_mulai' => $tgl_awal[$z],
                                    'tanggal_selesai' => $arr_waktu[$z],
                                    ]);
                            }
                        } else {
                            for ($z=0; $z < sizeof($estimasi); $z++) {
                                // Produksi
                                Production_customs::create([
                                    'umkms_id' => $idumkm[0]->umkms_id,
                                    'users_id' => $customs[$i]->users_id,
                                    'customs_id' => $customs[$i]->id,
                                    'qty' => $customs[$i]->qty,
                                    'status' => 'Menunggu',
                                    'status_produksi' => $estimasi[$z]->name_process,
                                    'estimasi' => $estimasi[$z]->durasi/1,
                                    ]);
                            }
                        }
                    }

                    // DB::table('customs')->where('id', $id_custom)
                    // ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                    // ->update([
                    //     'status' => "Menunggu Proses Produksi",
                    //     'status_payment' => "Lunas",
                    //     'updated_at' => $update,
                    // ]);

                    Alert::success('Pembayaran diterima', 'Status pesanan berhasil diupdate');
                    return redirect()->route('transaksi_custom.show', $id_custom);
                } else {
                    Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
                    return redirect()->route('transaksi_custom.show', $id_custom);
                }
            }
        }
    }

    public function selesaipesanan($id_custom)
    {
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        try {
            $decrypted = decrypt($id_custom);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id_custom);

        $update = Carbon::now()->toDateTimeString();

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $page = Customs::where('id', $newid)
        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('status', '=', 'Pesanan Sedang Dikirim')
        ->get();

        // dd(
        //     $id_custom,
        //     $update,
        // );

        if (empty($page[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            if ($newid) {
                DB::table('customs')
                ->where('id', $newid)
                ->where('status', "Pesanan Sedang Dikirim")
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => "Selesai",
                    'status_shipping' => "Selesai",
                    'updated_at' => $update,
                ]);

                Alert::success('Proses Berhasil', 'Status pesanan berhasil diupdate');
                return redirect()->route('transaksi_custom.show', $id_custom);
            } else {
                Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
                return redirect()->route('transaksi_custom.show', $id_custom);
            }
        }
    }

    public function tolakpembayaran($id_custom)
    {
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        try {
            $decrypted = decrypt($id_custom);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id_custom);

        $update = Carbon::now()->toDateTimeString();

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        // dd(
        //     $id_custom,
        //     $update,
        // );

        if ($newid) {
            $cek = Customs::where('id', $newid)
            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('status', '=', 'Menunggu Konfirmasi Pembayaran')
            ->get();

            if (empty($cek[0])) {
                Alert::warning('Proses Gagal', 'Data tidak ditemukan');
                return redirect()->route('transaksi_custom.show', $id_custom);
            } else {
                DB::table('customs')->where('id', $newid)
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => "Menunggu Pembayaran",
                    'status_payment' => "Ditangguhkan",
                    'updated_at' => $update,
                ]);

                Alert::warning('Pembayaran ditolak', 'Status pesanan berhasil diupdate');
                return redirect()->route('transaksi_custom.show', $id_custom);
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect()->route('transaksi_custom.show', $id_custom);
        }
    }

    public function tolakpesanan($id_custom)
    {
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        try {
            $decrypted = decrypt($id_custom);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id_custom);

        $update = Carbon::now()->toDateTimeString();

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        // dd(
        //     $id_custom,
        //     $update,
        // );

        if ($newid != null) {
            $cek = Customs::where('id', $newid)
            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('status', '=', 'Menunggu Konfirmasi')
            // ->orWhere('status', '=', 'Menunggu Konfirmasi Pembayaran')
            ->get();

            if (empty($cek[0])) {
                Alert::warning('Proses Gagal', 'Data tidak ditemukan');
                return redirect()->route('transaksi_custom.show', $id_custom);
            } else {
                DB::table('customs')->where('id', $newid)
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => "Pesanan Ditolak",
                    'status_payment' => "Pesanan Ditolak",
                    'updated_at' => $update,
                ]);

                Alert::info('Pesanan ditolak', 'Status pesanan berhasil diupdate');
                return redirect()->route('transaksi_custom.show', $id_custom);
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect()->route('transaksi_custom.show', $id_custom);
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

        $awal = "";
        $akhir = "";

        if ($request->dtawal > $request->dtakhir && $request->dtakhir != null) {
            Alert::info('Proses Gagal', 'Perhatikan kembali nilai tanggal');
            return Redirect::back();
        }

        if ($request->dtakhir == null && $request->dtawal != null) {
            $custom = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '>=', $request->dtawal)
            ->where('customs.status_payment', '=', 'Lunas')
            ->get();

            $total = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '>=', $request->dtawal)
            ->where('customs.status_payment', '=', 'Lunas')
            ->sum('customs.total');

            $jumlah = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '>=', $request->dtawal)
            ->where('customs.status_payment', '=', 'Lunas')
            ->count();

            $awal = $request->dtawal;
            $akhir = "";
        } elseif ($request->dtawal == null && $request->dtakhir != null) {
            $custom = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '<=', $request->dtakhir)
            ->where('customs.status_payment', '=', 'Lunas')
            ->get();

            $total = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '<=', $request->dtakhir)
            ->where('customs.status_payment', '=', 'Lunas')
            ->sum('customs.total');

            $jumlah = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '<=', $request->dtakhir)
            ->where('customs.status_payment', '=', 'Lunas')
            ->count();

            $awal = "";
            $akhir = $request->dtakhir;
        } elseif ($request->dtawal != null && $request->dtakhir != null) {
            $custom = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '>=', $request->dtawal)
            ->where('customs.date', '<=', $request->dtakhir)
            ->where('customs.status_payment', '=', 'Lunas')
            ->get();

            $total = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '>=', $request->dtawal)
            ->where('customs.date', '<=', $request->dtakhir)
            ->where('customs.status_payment', '=', 'Lunas')
            ->sum('customs.total');


            $jumlah = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '>=', $request->dtawal)
            ->where('customs.date', '<=', $request->dtakhir)
            ->where('customs.status_payment', '=', 'Lunas')
            ->count();

            $awal = $request->dtawal;
            $akhir = $request->dtakhir;
        } else {
            $custom = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.status_payment', '=', 'Lunas')
            ->get();

            $total = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.status_payment', '=', 'Lunas')
            ->sum('customs.total');

            $jumlah = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.status_payment', '=', 'Lunas')
            ->count();
        }

        // dd(
        //     $request->all(),
        //     $custom,
        // );


        if (empty($custom[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            $cetak = PDF::loadview('admin.pages.custom.laporan_custom', [
                'custom'=>$custom,
                'awal'=>$awal,
                'akhir'=>$akhir,
                'total'=>$total,
                'jumlah'=>$jumlah,
            ])->setPaper('a4', 'landscape');

            // Tester
            // return view('admin.pages.custom.laporan_custom', [
            //     'custom'=>$custom,
            //     'awal'=>$awal,
            //     'akhir'=>$akhir,
            //     'total'=>$total,
            //     'jumlah'=>$jumlah,
            // ]);
            return $cetak->download('Laporan Transaksi Custom, Periode '.
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
        // );

        if ($request->all() != null) {
            // Cek Nominal
            if ($request->sub <= 0) {
                Alert::warning('Proses Gagal', 'Inputan subtotal tidak boleh bernilai kurang dari atau sama dengan 0');
                return redirect()->route('acc_custom', Crypt::encrypt($request->id));
            } else {
                if ($request->ongkir <= 0) {
                    Alert::warning('Proses Gagal', 'Inputan ongkir tidak boleh bernilai kurang dari atau sama dengan 0');
                    return redirect()->route('acc_custom', Crypt::encrypt($request->id));
                } else {
                    //Insert
                    DB::table('customs')->where('id', $request->id)->update([
                        'subtotal' => $request->sub,
                        'total' => $request->total,
                        'ongkir' => $request->ongkir,
                        'status' => 'Menunggu Pembayaran',
                        'status_payment' => 'Menunggu Pembayaran',
                        'updated_at' => $update,
                        ]);
                    Alert::success('Pesanan berhasil diupdate', 'Cek status pesanan pada halaman pesanan');
                    return redirect('transaksi_custom');
                }
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect()->route('acc_custom', Crypt::encrypt($request->id));
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

        $page = Customs::select(
            'customs.*',
            'feedback_customs.desc as feedback_customs',
        )
        ->leftjoin('feedback_customs', 'feedback_customs.customs_id', '=', 'customs.id')
        ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('customs.id', '=', $newid)
        ->get();

        // Query Update Produksi
        $upd = Production_customs::select(
            'customs.first_name as nama_depan',
            'customs.last_name as nama_belakang',
            'production_customs.*',
            'production_customs.id as id_produksi',
        )
        ->join('customs', 'customs.id', '=', 'production_customs.customs_id')
        ->distinct()
        ->get();

        $waktu = Carbon::now();

        for ($i=0; $i < sizeof($upd); $i++) {
            if ($upd[$i]->tanggal_selesai <= $waktu) {
                DB::table('production_customs')->where('id', $upd[$i]->id_produksi)
                ->where('status', '=', 'Diproses')
                ->update([
                    'status' => 'Selesai',
                ]);
            }
        }

        // Query Update Pesanan
        // $produksi = Production_customs::select(
        //     'customs.first_name as nama_depan',
        //     'customs.last_name as nama_belakang',
        //     'production_customs.*',
        //     'production_customs.id as id_produksi',
        // )
        // ->join('customs', 'customs.id', '=', 'production_customs.customs_id')
        // ->where('customs.id', '=', $id)
        // ->orderBy('production_customs.id', 'desc')
        // ->first();

        $produksi = Production_customs::select(
            'customs.first_name as nama_depan',
            'customs.last_name as nama_belakang',
            'production_customs.*',
            'production_customs.id as id_produksi',
        )
        ->join('customs', 'customs.id', '=', 'production_customs.customs_id')
        ->where('customs.id', '=', $newid)
        ->where('production_customs.status', '=', "Diproses")
        ->orWhere('production_customs.status', '=', "Menunggu")
        ->get();

        if ($newid != null) {
            // if ($produksi != null) {
            //     if ($produksi->status == 'Selesai') {
            //         DB::table('customs')->where('id', $id)
            //         ->where('status', '=', "Proses Produksi")
            //         ->update([
            //             'status' => 'Pesanan Siap Dikirim',
            //             'updated_at' => $waktu,
            //         ]);
            //     }
            // }

            if (empty($produksi[0])) {
                DB::table('customs')->where('id', $newid)
                ->where('status', '=', "Proses Produksi")
                ->update([
                    'status' => 'Pesanan Siap Dikirim',
                    'updated_at' => $waktu,
                ]);
            }
        }


        // if ($page[0]->status_payment ==
        // "Menunggu Konfirmasi Pembayaran") {
        //     $test = 'berhasil';
        // }

        // dd(
        //     $test,
        //     $idumkm,
        //     $idumkm[0]->umkms_id,
        //     $page[0]->status_payment,
        //     $page,
        //     $tanggal,
        //     $batas,
        // );

        if (empty($page[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukkan');
            return view('admin.pages.error.page_404');
        } else {
            $tanggal = Carbon::parse($page[0]->created_at);
            $batas = $tanggal->addHours(48);

            $pageactive = "admincustom";
            $title = "Halaman Data Transaksi Custom";
            return view('admin.pages.custom.detail_custom', [
                'tanggal' => $tanggal,
                'batas' => $batas,
                'page' => $page,
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
