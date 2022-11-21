<?php

namespace App\Http\Controllers\Produksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production_customs;
use App\Models\Deadlines;
use App\Models\Customers;
use App\Models\Estimations;
use App\Models\Customs;
use App\Models\Orders;
use App\Models\User;
use App\Models\Expeditions;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class Production_customController extends Controller
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

        $page = Production_customs::select(
            'customs.first_name as nama_depan',
            'customs.last_name as nama_belakang',
            'production_customs.*',
            'production_customs.id as id_produksi',
        )
        ->join('customs', 'customs.id', '=', 'production_customs.customs_id')
        ->where('production_customs.umkms_id', '=', $idumkm[0]->umkms_id)
        ->orderBy('customs.created_at', 'asc')
        ->orderBy('production_customs.id', 'asc')
        ->get();

        $est = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->count();

        $waktu = Carbon::now();

        // dd(
        //     $page,
        //     sizeof($page),
        //     $waktu,
        //     $est,
        // );

        if ($page != null) {
            for ($i=0; $i < sizeof($page); $i++) {
                if ($page[$i]->tanggal_selesai <= $waktu && $page[$i]->tanggal_selesai != null) {
                    DB::table('production_customs')->where('id', $page[$i]->id_produksi)
                    ->where('status', '=', 'Diproses')
                    ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                    ->update([
                        'status' => 'Selesai',
                    ]);
                }
            }
        }

        $pageactive = "adminproduksicustom";
        $title = "Halaman Data Produksi Custom";
        return view('admin.pages.produksi_custom.data_produksi_custom', [
            'page' => $page,
            'waktusekarang' => $waktu,
            'est' => $est,
            'pageactive' => $pageactive,
            'title' => $title,
        ]);
    }

    public function mulaiproduksi($id_customs)
    {
        $pageactive = "adminproduksi";
        $title = "Halaman Data Produksi";
        $update = Carbon::now()->toDateTimeString();

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        // Query Function
        $est = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->count();

        // Estimasi dulu
        $estimasi = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $tambah = 0;

        $mulai = Production_customs::select(
            'production_customs.*',
        )
        ->join('customs', 'customs.id', '=', 'production_customs.customs_id')
        ->where('customs.id', '=', $id_customs)
        ->where('production_customs.umkms_id', '=', $idumkm[0]->umkms_id)
        // ->where('production_customs.status', '=', 'Menunggu')
        // ->orWhere('production_customs.status', '=', 'Selesai')
        ->get();

        if (empty($mulai[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            for ($x=0; $x < sizeof($estimasi); $x++) {
                $waktu = Carbon::now();

                $tambah += $estimasi[$x]->durasi;

                $hasil = $waktu->addHours($tambah)->toDateTimeString();

                $isi[] = $hasil;
                $arr_waktu = $isi;
            }

            $awal[] = Carbon::now()->toDateTimeString();
            $tgl_awal = array_merge($awal, $arr_waktu);

            // dd(
            //     $mulai,
            //     $mulai[0]->id,
            //     $estimasi,
            //     $awal,
            //     $tgl_awal,
            //     $arr_waktu,
            // );

            for ($i=0; $i < sizeof($mulai); $i++) {
                DB::table('production_customs')
                ->where('id', $mulai[$i]->id)
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => "Diproses",
                    'tanggal_mulai' => $tgl_awal[$i],
                    'tanggal_selesai' => $arr_waktu[$i],
                    'updated_at' => $update,
                ]);
            }

            // Update Data Ordernya
            DB::table('customs')
            ->where('id', $id_customs)
            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->update([
                'status' => "Proses Produksi",
                'updated_at' => $update,
            ]);

            Alert::success('Update berhasil', 'Status produksi berhasil diupdate');
            return redirect('/produksi_custom');
        }
        // dd(
            //     $mulai,
            //     $est,
            //     $i,
            //     $arr_waktu,
            //     $tgl_awal,
            //     $tgl_awal[1],
        // );
    }

    public function selesaiproduksi($id_customs)
    {
        $pageactive = "adminproduksi";
        $title = "Halaman Data Produksi";
        $update = Carbon::now()->toDateTimeString();

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        // dd(
        //     $id_customs,
        // );

        if ($id_customs == null) {
            Alert::info('Proses Gagal', 'Id Custom Kosong');
            return view('admin.pages.error.page_404');
        } else {
            $selesai = Production_customs::where('customs_id', '=', $id_customs)
            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            if (empty($selesai[0])) {
                Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
                return view('admin.pages.error.page_404');
            } else {
                DB::table('production_customs')->where('customs_id', $id_customs)
                ->where('status', '=', 'Diproses')
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => 'Selesai',
                ]);
                Alert::success('Update berhasil', 'Status produksi berhasil diupdate');
                return redirect('/produksi_custom');
            }
        }
    }

    public function selesaiproses($id_produksi)
    {
        // dd(
        //     $id_produksi,
        // );

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $waktu = Carbon::now();

        if ($id_produksi != null) {
            $selesai = Production_customs::select(
                'production_customs.*',
            )
            ->where('id', '=', $id_produksi)
            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            // dd(
            //     $id_produksi,
            //     $selesai,
            // );

            if (empty($selesai[0])) {
                Alert::info('Data tidak ditemukan', 'Gagal melakukan aksi');
                return view('admin.pages.error.page_404');
            } else {
                DB::table('production_customs')
                ->where('id', $id_produksi)
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => "Diproses",
                    'tanggal_mulai' => $waktu,
                    'tanggal_selesai' => $waktu->addSeconds(10),
                    'updated_at' => $waktu,
                ]);

                sleep(7);

                Alert::success('Update berhasil', 'Status produksi berhasil diupdate');
                return redirect('/produksi_custom');
            }
        } else {
            Alert::info('Data tidak ditemukan', 'Id produksi kosong');
            return view('admin.pages.error.page_404');
        }
    }

    public function mulaiproses($id_produksi)
    {
        // dd(
        //     $id_produksi,
        // );

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $waktu = Carbon::now();

        if ($id_produksi != null) {
            $proses = Production_customs::select(
                'production_customs.*',
            )
            ->where('production_customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('production_customs.id', '=', $id_produksi)
            ->where('production_customs.status', '=', 'Diproses')
            ->get();

            // dd(
            //     $id_produksi,
            //     $proses,
            //     $waktu,
            // );

            if (empty($proses[0])) {
                Alert::info('Data tidak ditemukan', 'Gagal melakukan aksi');
                return view('admin.pages.error.page_404');
            } else {
                DB::table('production_customs')
                ->where('id', $id_produksi)
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => "Diproses",
                    'tanggal_mulai' => Carbon::now(),
                    'tanggal_selesai' => $waktu->addHours($proses[0]->estimasi),
                    'updated_at' => Carbon::now(),
                ]);

                Alert::success('Update berhasil', 'Status produksi berhasil diupdate');
                return redirect('/produksi_custom');
            }
        } else {
            Alert::info('Data tidak ditemukan', 'Id produksi kosong');
            return view('admin.pages.error.page_404');
        }
    }

    public function berhentiproduksi($id_customs)
    {
        // dd(
        //     $id_customs,
        // );

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $waktu = Carbon::now();

        if ($id_customs != null) {
            $berhenti = Production_customs::where('customs_id', '=', $id_customs)
            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            // dd(
            //     $id_produksi,
            //     $berhenti,
            // );

            if (empty($berhenti[0])) {
                Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
                return view('admin.pages.error.page_404');
            } else {
                DB::table('production_customs')->where('customs_id', $id_customs)
                ->where('status', '=', 'Diproses')
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => 'Menunggu',
                    'tanggal_mulai' => null,
                    'tanggal_selesai' => null,
                    'updated_at' => $waktu,
                ]);

                Alert::success('Update berhasil', 'Status produksi berhasil diupdate');
                return redirect('/produksi_custom');
            }
        } else {
            Alert::info('Proses Gagal', 'id order kosong');
            return view('admin.pages.error.page_404');
        }
    }

    public function berhentiproses($id_produksi)
    {
        // dd(
        //     $id_produksi,
        // );

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $waktu = Carbon::now();

        if ($id_produksi != null) {
            $berhenti = Production_customs::where('id', '=', $id_produksi)
            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            // dd(
            //     $id_produksi,
            //     $berhenti,
            // );

            if (empty($berhenti[0])) {
                Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
                return view('admin.pages.error.page_404');
            } else {
                DB::table('production_customs')->where('id', $id_produksi)
                ->where('status', '=', 'Diproses')
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => 'Diproses',
                    'tanggal_mulai' => null,
                    'tanggal_selesai' => null,
                    'updated_at' => $waktu,
                ]);

                Alert::success('Update berhasil', 'Status produksi berhasil diupdate');
                return redirect('/produksi_custom');
            }
        } else {
            Alert::info('Proses Gagal', 'id produksi kosong');
            return view('admin.pages.error.page_404');
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
        // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
        // return view('admin.pages.error.page_404');
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

        $page = Customs::select(
            'customs.*',
            'feedback_customs.desc as feedback_customs',
        )
        ->leftjoin('feedback_customs', 'feedback_customs.customs_id', '=', 'customs.id')
        ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('customs.id', '=', $id)
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

        $produksi = Production_customs::select(
            'customs.first_name as nama_depan',
            'customs.last_name as nama_belakang',
            'production_customs.*',
            'production_customs.id as id_produksi',
        )
        ->join('customs', 'customs.id', '=', 'production_customs.customs_id')
        ->where('customs.id', '=', $id)
        ->where('production_customs.status', '=', "Diproses")
        ->orWhere('production_customs.status', '=', "Menunggu")
        ->get();

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

        // if ($id != null) {
        //     if ($produksi != null) {
        //         if ($produksi->status == 'Selesai') {
        //             DB::table('customs')->where('id', $id)
        //     ->where('status', '=', "Proses Produksi")
        //     ->update([
        //     'status' => 'Pesanan Siap Dikirim',
        //     'updated_at' => $waktu,
        //         ]);
        //         }
        //     }
        // }

        if ($id != null) {
            if (empty($produksi[0])) {
                DB::table('customs')->where('id', $id)
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
            $tanggal = Carbon::parse($page[0]->date);
            $deadline = Deadlines::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();
            $batas = $tanggal->addHours($deadline[0]->deadline);

            $pageactive = "admincustom";
            $title = "Halaman Data Transaksi Custom";
            return view('admin.pages.produksi_custom.detail_produksi_custom', [
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
