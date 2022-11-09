<?php

// namespace App\Http\Controllers\Produksi;

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Umkms;
use App\Models\Deadlines;
use App\Models\Estimations;
use App\Models\Payments;
use App\Models\Colors;
use App\Models\Categorys;
use App\Models\Expeditions;
use App\Models\Customers;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Redirect;

class EstimationController extends Controller
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

        $page = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $total = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->sum('durasi');

        if (auth()->user()->role != "super") {
            // Data UMKM
            $data_umkm = Umkms::where('id', '=', $idumkm[0]->umkms_id)
            ->get();

            if ($data_umkm[0]->districts == null ||
            $data_umkm[0]->ward == null ||
            $data_umkm[0]->city == null ||
            $data_umkm[0]->province == null ||
            $data_umkm[0]->postal_code == null) {
                Alert::info('Proses Gagal', 'Data UMKM ada yang Kosong');
                return redirect('/info/create');
            }

            // Estimation
            $data_estimasi = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            if (empty($data_estimasi[0])) {
                // if (!isset($data_estimasi)) {
                Alert::info('Proses Gagal', 'Data Estimasi Produksi Kosong');
                return redirect('/estimasi/create');
            }

            // Pembayaran
            $data_pembayaran = Payments::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            if (empty($data_pembayaran[0])) {
                Alert::info('Proses Gagal', 'Data Portal Pembayaran Kosong');
                return redirect('/pembayaran/create');
            }

            // Color
            $data_color = Colors::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            if (empty($data_color[0])) {
                Alert::info('Proses Gagal', 'Data Warna Produk Kosong');
                return redirect('/warna/create');
            }

            // Category
            $data_kategori = Categorys::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            if (empty($data_kategori[0])) {
                Alert::info('Proses Gagal', 'Data Kategori Produk Kosong');
                return redirect('/kategori/create');
            }

            // Ekpedisi
            $data_ekspedisi = Expeditions::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            if (empty($data_ekspedisi[0])) {
                Alert::info('Proses Gagal', 'Data Jasa Ekspedisi Kosong');
                return redirect('/jasa_ekspedisi/create');
            }

            // Deadline
            $data_deadline = Deadlines::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            if (empty($data_deadline[0])) {
                Alert::info('Proses Gagal', 'Data Deadline Kosong');
                return redirect('/deadline/create');
            }
        }

        // dd(
        //     $total,
        // );

        $pageactive = 'adminestimations';
        $title = "Halaman Data estimasi";
        return view('admin.pages.estimasi.data_estimasi', [
            'page' => $page,
            'total' => $total,
            'pageactive' => $pageactive,
            'title' => $title,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $page = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $total = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->sum('durasi');

        $pageactive = "adminestimasicreate";
        $title = "Form Tambah Data Warna Produk";
        return view('admin.pages.estimasi.create_estimasi', [
            'page' => $page,
            'idumkm' => $idumkm[0]->umkms_id,
            'pageactive' => $pageactive,
            'title' => $title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $cekurutan = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->max('urutan');

        // dd(
        //     $request->all(),
        //     $cekurutan,
        //     sizeof($request->name_process),
        // );

        $validator = Validator::make(request()->all(), [
            'name_process' => 'required|max:255',
            'durasi' => 'required|numeric|min:1',
        ])->setAttributeNames(
            [
                'name_process' => '"Nama Proses"',
                'durasi' => '"Durasi Proses"',
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        if (empty($cekurutan[0])) {
            // Simpan
            if ($request->all() != null) {
                // Cek Username
                $j = 0;
                $no = 1;
                for ($i=0; $i < sizeof($request->name_process) ; $i++) {
                    $cek = DB::table('estimations')
                    ->where('name_process', '=', $request->name_process[$j])
                    ->count();

                    if ($cek == 0) {
                        Estimations::create([
                            'umkms_id' => $idumkm[0]->umkms_id,
                            'name_process' => $request->name_process[$j],
                            'urutan' => $no,
                            'durasi' => $request->durasi[$j],
                        ]);
                        $no++;
                        $j++;
                    }
                }

                // dd(
                //     $i,
                //     $j,
                //     $no,
                //     $request->all(),
                //     $cekurutan,
                //     sizeof($request->name_process),
                // );
                // Alert::success('Proses Berhasil', 'Data telah tersimpan');
                // return redirect('/estimasi');
                return redirect()->route("estimasi.index")->with("info", "Data Estimasi berhasil disimpan");
            } else {
                Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
                return redirect('/estimasi/create');
            }
        } else {
            // Simpan
            if ($request->all() != null) {
                // Cek Username
                $j = 0;
                $no = 1;
                for ($i=0; $i < sizeof($request->name_process) ; $i++) {
                    $cek = DB::table('estimations')
                    ->where('name_process', '=', $request->name_process[$j])
                    ->count();

                    if ($cek == 0) {
                        Estimations::create([
                            'umkms_id' => $idumkm[0]->umkms_id,
                            'name_process' => $request->name_process[$j],
                            'urutan' => $cekurutan+1,
                            'durasi' => $request->durasi[$j],
                        ]);
                        $cekurutan++;
                        $j++;
                    }
                }

                // dd(
                //     $i,
                //     $j,
                //     $no,
                //     $request->all(),
                //     $cekurutan,
                //     sizeof($request->name_process),
                // );
                // Alert::success('Proses Berhasil', 'Data telah tersimpan');
                // return redirect('/estimasi');
                return redirect()->route("estimasi.index")->with("info", "Data Estimasi berhasil disimpan");
            } else {
                Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
                return redirect('/estimasi/create');
            }
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
        // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
        // return view('admin.pages.error.page_404');
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
        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $cek = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('id', '=', $id)
        ->get();

        $est = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('urutan', '>', $cek[0]->urutan)
        ->get();

        if ($id != null) {
            if (empty($cek[0])) {
                Alert::warning('Proses Gagal', 'Data tidak ditemukan');
                return Redirect::back();
            } else {
                $delete = Estimations::findOrFail($id);
                $delete->delete();

                if (empty($est[0])) {
                    // Alert::success('Proses Berhasil', 'Data berhasil dihapus');
                    // return Redirect::back();
                    return redirect()->route("estimasi.index")->with("info", "Data Estimasi berhasil dihapus");
                } else {
                    // dd(
                    //     $id,
                    //     $cek,
                    //     sizeof($cek),
                    //     $est,
                    //     sizeof($est),
                    //     $est[0]->urutan,
                    //     $est[0]->urutan-1,
                    // );

                    for ($i=0; $i < sizeof($est); $i++) {
                        // update
                        DB::table('estimations')->where('umkms_id', '=', $idumkm[0]->umkms_id)
                        ->where('id', $est[$i]->id)
                        ->update([
                            'urutan' => $est[$i]->urutan-1,
                        ]);
                    }
                    // Alert::success('Proses Berhasil', 'Data berhasil dihapus');
                    // return Redirect::back();
                    return redirect()->route("estimasi.index")->with("info", "Data Estimasi berhasil dihapus");
                }
            }
        } else {
            Alert::warning('Proses Gagal', 'Data tidak ditemukan');
            return Redirect::back();
        }
    }
}
