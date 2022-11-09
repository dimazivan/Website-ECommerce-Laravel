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
use App\Models\Materials;
use App\Models\Suppliers;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Redirect;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $page = Materials::with(['suppliers'])->get();

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $page = DB::table('materials')
        ->select(
            'suppliers.name as suppliers_name',
            'materials.*'
        )
        ->join('suppliers', 'suppliers.id', '=', 'materials.suppliers_id')
        ->where('materials.umkms_id', '=', $idumkm[0]->umkms_id)
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

            $data_supplier = Suppliers::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            if (empty($data_supplier[0])) {
                // if (!isset($data_supplier)) {
                Alert::info('Proses Gagal', 'Data Supplier Kosong');
                return redirect('/supplier/create');
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

        $pageactive = 'adminmaterial';
        $title = "Halaman Data Material";
        return view('admin.pages.bahan_baku.data_bahan_baku', [
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

        $page = Suppliers::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $ceksup = DB::table('suppliers')
        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->count();

        $material = DB::table('materials')
        ->select('suppliers.name as suppliers_name', 'materials.*')
        ->join('suppliers', 'suppliers.id', '=', 'materials.suppliers_id')
        ->where('materials.umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        if ($ceksup == 0) {
            Alert::info('Proses Gagal', 'Data Supplier Kosong');
            return redirect('/supplier/create');
        } else {
            $pageactive = 'adminmaterialcreate';
            $title = "Form Tambah Data Material";
            return view('admin.pages.bahan_baku.create_bahan_baku', [
            'material' => $material,
            'idumkm' => $idumkm[0]->umkms_id,
            'page' => $page,
            'pageactive' => $pageactive,
            'title' => $title,
            ]);
        }
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
            'cbsup' => 'required',
            'price' => 'required|numeric|min:100',
            'qty' => 'required|numeric|min:1',
        ])->setAttributeNames(
            [
                'cbsup' => '"Nama Supplier"'
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        if ($request->all() != null && $request->cbsup != null) {
            // Cek nama bahan
            $cek = DB::table('materials')
            ->where('name', '=', $request->name)
            ->count();

            // dd(
            //     $cek
            // );
            if ($cek == 0 && $request->price > 0) {
                if ($request->cbsup == "Pilih Supplier") {
                    Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
                    return Redirect::back();
                } else {
                    Materials::create([
                        'umkms_id' => $request->umkms_id,
                        'name' => $request->name,
                        'suppliers_id' => $request->cbsup,
                        'price' => $request->price,
                        'qty' => $request->qty,
                    ]);
                    // Alert::success('Proses Berhasil', 'Data berhasil disimpan');
                    // return redirect('/bahan_baku');
                    return redirect()->route("bahan_baku.index")->with("info", "Data Bahan Baku berhasil disimpan");
                }
            } else {
                // Alert::warning('Proses Gagal', 'Nama Bahan yang sama telah terdaftar');
                // return Redirect::back();
                return back()->with("info", "Nama Bahan yang sama telah terdaftar");
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return Redirect::back();
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

        $sup = Suppliers::where('umkms_id', '=', $idumkm[0]->umkms_id)
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

        $page = Materials::where("id", $newid)
        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        if (empty($page[0])) {
            // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            // return view('admin.pages.error.page_404');
            return redirect()->route("bahan_baku.index")->with("info", "Data Bahan Baku tidak ditemukan");
        } else {
            $pageactive = 'adminmaterialedit';
            $title = "Form Edit Data Material";
            return view('admin.pages.bahan_baku.edit_bahan_baku', [
                'page' => $page,
                'sup' => $sup,
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
            'cbsup' => 'required',
            'price' => 'required|numeric|min:100',
            'qty' => 'required|numeric|min:1',
        ])->setAttributeNames(
            [
                'cbsup' => '"Nama Supplier"'
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        if ($request->all() != null && $request->cbsup != null) {
            // Cek nama bahan
            $cek = DB::table('materials')
            ->where('name', '=', $request->name)
            ->count();

            $name = DB::table('materials')
            ->select('name')
            ->where('id', '=', $request->id)
            ->get();

            // dd(
            //     $cek,
            //     $name[0]->name
            // );

            if ($cek == 0 || $request->name == $name[0]->name) {
                if ($request->cbsup == "Pilih Supplier") {
                    Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
                    return redirect()->route("bahan_baku.edit", $id);
                } else {
                    DB::table('materials')->where('id', $request->id)->update([
                        'name' => $request->name,
                        'suppliers_id' => $request->cbsup,
                        'price' => $request->price,
                        'qty' => $request->qty,
                    ]);
                    // Alert::success('Proses Berhasil', 'Data berhasil diperbaharui');
                    // return redirect('/bahan_baku');
                    return redirect()->route("bahan_baku.index")->with("info", "Data Bahan Baku berhasil diperbaharui");
                }
            } else {
                // Alert::warning('Proses Gagal', 'Nama Bahan yang sama telah terdaftar');
                // return redirect()->route("bahan_baku.edit", $id);
                return back()->with("info", "Nama Bahan yang sama telah terdaftar");
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect()->route("bahan_baku.edit", $id);
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
            $delete = Materials::findOrFail($newid);
            $delete->delete();
            // Alert::success('Proses Berhasil', 'Data berhasil dihapus');
            // return Redirect::back();
            return redirect()->route("bahan_baku.index")->with("info", "Data Bahan Baku berhasil dihapus");
        } else {
            Alert::warning('Proses Gagal', 'Data tidak ditemukan');
            return Redirect::back();
        }
    }
}
