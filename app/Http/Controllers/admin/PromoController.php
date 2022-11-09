<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Deadlines;
use App\Models\User;
use App\Models\Umkms;
use App\Models\Estimations;
use App\Models\Payments;
use App\Models\Colors;
use App\Models\Categorys;
use App\Models\Expeditions;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;
use Redirect;

class PromoController extends Controller
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

        $page = Promo::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

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

        $pageactive = 'adminpromo';
        $title = "Halaman Data Promo";
        return view('admin.pages.promo.data_promo', [
            'page' => $page,
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

        $page = Promo::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $pageactive = 'adminpromocreate';
        $title = "Form Tambah Data Promo";
        return view('admin.pages.promo.create_promo', [
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
        // dd(
        //     $request->all()
        // );

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $waktu = Carbon::now();

        $validator = Validator::make(request()->all(), [
            'name' => 'required|max:255',
            'kode' => 'required|numeric|min:5',
            'cbjenis' => 'required',
            'jumlah' => 'required|numeric',
        ])->setAttributeNames(
            [
                'name' => '"Nama Promo"',
                'cbjenis' => '"Jenis Voucher Promo"',
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        if ($request->all() != null && $request->cbjenis != null) {
            // cek
            $cek = DB::table('promos')
            ->where('name', '=', $request->name)
            ->orWhere('kode', '=', $request->kode)
            ->count();
            if ($cek == 0 && $request->cbjenis != null) {
                if ($request->jumlah > 99 && $request->cbjenis == "discount") {
                    Alert::warning('Proses Gagal', 'Jumlah Promo untuk diskon tidak lebih dari 99%');
                    return redirect('/promo/create');
                } elseif ($request->jumlah < 1000 && $request->cbjenis == "nominal") {
                    Alert::warning('Proses Gagal', 'Jumlah Promo untuk nominal minimal Rp. 1000');
                    return redirect('/promo/create');
                } else {
                    Promo::create([
                        'umkms_id' => $idumkm[0]->umkms_id,
                        'name' => $request->name,
                        'kode' => $request->kode,
                        'type' => $request->cbjenis,
                        'jumlah' => $request->jumlah,
                        // 'create_date' => $request->date,
                        'create_date' => $waktu,
                        'status' => "aktif",
                    ]);
                }
                // Alert::success('Proses Berhasil', 'Data telah tersimpan');
                // return redirect('/promo');
                return redirect()->route("promo.index")->with("info", "Data Promo berhasil disimpan");
            } else {
                // Alert::warning('Proses Gagal', 'Nama Promo yang sama telah terdaftar');
                // return redirect('/promo/create');
                return back()->with("info", "Nama Promo yang sama telah terdaftar");
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect('/promo/create');
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

    public function activated($id)
    {
        // dd(
        //     $id
        // );
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

        $cek = Promo::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('id', $newid)
        ->where('status', '=', 'tidak_aktif')
        ->get();

        $waktu = Carbon::now();

        if (empty($cek[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            DB::table('promos')->where('id', $newid)
            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->update([
                'status' => "aktif",
                'updated_at' => $waktu,
            ]);

            Alert::success('Proses Berhasil', 'Promo Berhasil Diaktifkan');
            return redirect('/promo');
        }
    }

    public function deactivated($id)
    {
        // dd(
        //     $id
        // );
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

        $cek = Promo::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('id', $newid)
        ->where('status', '=', 'aktif')
        ->get();

        $waktu = Carbon::now();

        if (empty($cek[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            DB::table('promos')->where('id', $newid)
            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->update([
                'status' => "tidak_aktif",
                'updated_at' => $waktu,
            ]);

            Alert::success('Proses Berhasil', 'Promo Berhasil Dinonaktifkan');
            return redirect('/promo');
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
        // dd(
        //     $id
        // );

        try {
            $decrypted = decrypt($id);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id);

        if ($id != null) {
            $delete = Promo::findOrFail($newid);
            $delete->delete();
            // Alert::success('Proses Berhasil', 'Data berhasil dihapus');
            // return Redirect::back();
            return redirect()->route("promo.index")->with("info", "Data Promo berhasil dihapus");
        } else {
            Alert::warning('Proses Gagal', 'Data tidak ditemukan');
            return Redirect::back();
        }
    }
}
