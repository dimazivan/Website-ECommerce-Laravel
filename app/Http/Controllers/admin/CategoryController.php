<?php

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
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Redirect;

class CategoryController extends Controller
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

        $page = Categorys::where('umkms_id', '=', $idumkm[0]->umkms_id)
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

        // dd(
        //     $page
        // );

        $pageactive = "admincategory";
        $title = "Halaman Data Kategori Produk";
        return view('admin.pages.category.data_category', [
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

        $page = Categorys::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $pageactive = "admincategorycreate";
        $title = "Form Tambah Data Kategori Produk";
        return view('admin.pages.category.create_category', [
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

        $validator = Validator::make(request()->all(), [
            'name' => 'required|max:255',
        ])->setAttributeNames(
            [
                'name' => '"Nama Kategori"'
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        if ($request->all() != null) {
            //cek nama kategori
            $cek = DB::table('categorys')
            ->where('name', '=', $request->name)
            ->where('umkms_id', '=', $request->umkms_id)
            ->count();

            // dd(
            //     $cek
            // );
            if ($cek == 0) {
                Categorys::create([
                    'umkms_id' => $request->umkms_id,
                    'name' => $request->name,
                ]);

                // Alert::success('Proses Berhasil', 'Data berhasil disimpan');
                // return redirect('/kategori');
                return redirect()->route("kategori.index")->with("info", "Data Kategori berhasil disimpan");
            } else {
                // Alert::warning('Proses Gagal', 'Nama Kategori yang sama telah terdaftar');
                // return redirect('/kategori/create');
                return back()->with("info", "Nama Kategori yang sama telah terdaftar");
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh Kosong');
            return redirect('/kategori/create');
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

        $page = Categorys::where("id", $newid)
        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        // dd(
        //     $page
        // );

        if (empty($page[0])) {
            // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            // return view('admin.pages.error.page_404');
            return back()->with("info", "Data Kategori tidak ditemukan");
        } else {
            $pageactive = "admincategoryedit";
            $title = "Halaman Edit Data Kategori Produk";
            return view('admin.pages.category.edit_category', [
                'page' => $page,
                'pageactive' => $pageactive,
                'title' => $title,
            ]);
        }
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
        //     $request->all()
        // );

        $validator = Validator::make(request()->all(), [
            'name' => 'required|max:255',
        ])->setAttributeNames(
            [
                'name' => '"Nama Kategori"'
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        if ($request->all() != null) {
            // Cek
            $cek = DB::table('categorys')
                ->Where('name', '=', $request->name)
                ->count();

            $name = DB::table('categorys')
                ->select('name')
                ->Where('id', '=', $request->id)
                ->get();

            // dd(
            //     $name[0]->name
            // );

            if ($cek == 0 || $request->name == $name[0]->name) {
                DB::table('categorys')->where('id', $request->id)->update([
                    'name' => $request->name,
                ]);

                // Alert::success('Proses Berhasil', 'Data berhasil diperbaharui');
                // return redirect('/kategori');
                return redirect()->route("kategori.index")->with("info", "Data Kategori berhasil diperbaharui");
            } else {
                // Alert::warning('Proses Gagal', 'Nama Kategori yang sama telah terdaftar');
                // return redirect()->route("kategori.edit", $id);
                return back()->with("info", "Nama Kategori yang sama telah terdaftar");
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh Kosong');
            return redirect()->route("kategori.edit", $id);
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
            $delete = Categorys::findOrFail($newid);
            $delete->delete();
            // Alert::success('Proses Berhasil', 'Data berhasil dihapus');
            // return Redirect::back();
            return redirect()->route("kategori.index")->with("info", "Data Kategori berhasil dihapus");
        } else {
            Alert::warning('Proses Gagal', 'Data tidak ditemukan');
            return Redirect::back();
        }
    }
}
