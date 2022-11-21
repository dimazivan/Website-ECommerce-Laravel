<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Suppliers;
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
use Redirect;

class SupplierController extends Controller
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

        $page = Suppliers::where('umkms_id', '=', $idumkm[0]->umkms_id)
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

        $pageactive = 'adminsupplier';
        $title = "Halaman Data Supplier";
        return view('admin.pages.supplier.data_supplier', [
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

        $pageactive = 'adminsuppliercreate';
        $title = "Form Tambah Data Supplier";
        return view('admin.pages.supplier.create_supplier', [
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

        $validator = Validator::make(request()->all(), [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'email' => 'required',
            'phone' => 'required|numeric|digits_between:10,13',
        ])->setAttributeNames(
            [
                'name' => '"Nama Supplier"'
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        if ($request->all() != null) {
            // cek nama supplier
            $cek = DB::table('suppliers')
            ->where('name', '=', $request->name)
            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->count();

            // dd(
            //     $cek
            // );
            if ($cek == 0) {
                Suppliers::create([
                    'umkms_id' => $idumkm[0]->umkms_id,
                    'name' => $request->name,
                    'address' => $request->address,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);

                // Alert::success('Proses Berhasil', 'Data telah tersimpan');
                // return redirect('/supplier');
                return redirect()->route("supplier.index")->with("info", "Data Supplier berhasil disimpan");
            } else {
                // Alert::warning('Proses Gagal', 'Nama Supplier yang sama telah terdaftar');
                // return redirect('/supplier/create');
                return back()->with("info", "Nama Supplier yang sama telah terdaftar");
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect('/supplier/create');
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

        $supplier = Suppliers::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('id', '=', $id)
        ->get();

        if (empty($supplier[0])) {
            // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            // return view('admin.pages.error.page_404');
            return redirect()->route("supplier.index")->with("info", "Data Supplier tidak ditemukan");
        } else {
            $pageactive = "adminsupplierview";
            $title = "Halaman Data Supplier";
            return view('admin.pages.supplier.view_supplier', [
                'supplier' => $supplier,
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

        $page = Suppliers::where("id", $newid)
        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        // dd(
        //     $page
        // );

        if (empty($page[0])) {
            // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            // return view('admin.pages.error.page_404');
            return redirect()->route("supplier.index")->with("info", "Data Supplier tidak ditemukan");
        } else {
            $pageactive = "adminsupplieredit";
            $title = "Halaman Edit Data Supplier";
            return view('admin.pages.supplier.edit_supplier', [
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

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $validator = Validator::make(request()->all(), [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'email' => 'required',
            'phone' => 'required|numeric|digits_between:10,13',
        ])->setAttributeNames(
            [
                'name' => '"Nama Supplier"'
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        if ($request->all() != null) {
            // cek nama supplier
            $cek = DB::table('suppliers')
            ->where('name', '=', $request->name)
            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->count();

            $name = DB::table('suppliers')
            ->select('name')
            ->where('id', '=', $request->id)
            ->get();

            // dd(
            //     $cek,
            //     $name[0]->name
            // );

            if ($cek == 0 || $request->name == $name[0]->name) {
                DB::table('suppliers')->where('id', $request->id)->update([
                    'name' => $request->name,
                    'address' => $request->address,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);

                // Alert::success('Proses Berhasil', 'Data telah tersimpan');
                // return redirect('/supplier');
                return redirect()->route("supplier.index")->with("info", "Data Supplier berhasil disimpan");
            } else {
                // Alert::warning('Proses Gagal', 'Nama Supplier yang sama telah terdaftar');
                // return redirect()->route("supplier.edit", $id);
                return back()->with("info", "Nama Supplier yang sama telah terdaftar");
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect()->route("supplier.edit", $id);
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
            $delete = Suppliers::findOrFail($newid);
            $delete->delete();
            // Alert::success('Proses Berhasil', 'Data berhasil dihapus');
            // return Redirect::back();
            return redirect()->route("supplier.index")->with("info", "Data Supplier berhasil dihapus");
        } else {
            Alert::warning('Proses Gagal', 'Data tidak ditemukan');
            return Redirect::back();
        }
    }
}
