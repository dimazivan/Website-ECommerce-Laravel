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
use App\Models\Info;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Redirect;

class InfoController extends Controller
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

        $page = Info::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->orderBy('id', 'desc')
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

        $pageactive = 'admininfo';
        $title = "Halaman Data Info";
        return view('admin.pages.info.data_info', [
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

        $page = Info::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $pageactive = 'admininfocreate';
        $title = "Form Tambah Data Info";
        return view('admin.pages.info.create_info', [
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
            'phone' => 'required|numeric|digits_between:10,13',
            'title' => 'required|max:255',
            'address' => 'required|max:255',
            'email' => 'required|email|max:255',
            'shopee' => 'sometimes',
            'tokped' => 'sometimes',
            'instagram' => 'sometimes',
            'desc_umkm' => 'sometimes',
            'desc_product' => 'sometimes',
            'desc_detail' => 'sometimes',
            'date' => 'sometimes',
        ])->setAttributeNames(
            [
                'phone' => '"Nomor Telepon"'
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        if ($request->all() != null) {
            //cek
            $cek = DB::table('infos')
            ->where('no_wa', '=', $request->phone)
            ->count();

            if (auth()->user()->id == 1) {
                $login = $request->desc_login;
                $register = $request->desc_register;
                $lainnya = $request->desc_lainnya;
            } else {
                $login = "";
                $register = "";
                $lainnya = "";
            }

            if ($cek == 0) {
                Info::create([
                    'umkms_id' => $request->umkms_id,
                    'no_wa' => $request->phone,
                    'title' => $request->title,
                    'alamat' => $request->address,
                    'link_email' => $request->email,
                    'link_shopee' => $request->shopee,
                    'link_tokped' => $request->tokped,
                    'link_instagram' => $request->instagram,
                    'description_login' => $login,
                    'description_register' => $register,
                    'description_umkm' => $request->desc_umkm,
                    'description_product' => $request->desc_product,
                    'description_detail' => $request->desc_detail,
                    'description_lainnya' => $lainnya,
                    'date' => $request->date
                ]);

                DB::table('umkms')->where('id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'location' => $request->address,
                    'districts' => $request->districts,
                    'ward' => $request->ward,
                    'city' => $request->city,
                    'province' => $request->province,
                    'postal_code' => $request->postal_code,
                    'phone' => $request->phone,
                    'open_time' => $request->open_time,
                    'close_time' => $request->close_time,
                ]);

                // Alert::success('Proses Berhasil', 'Data telah tersimpan');
                // return redirect('/info');
                return redirect()->route("info.index")->with("info", "Data Informasi Website berhasil disimpan");
            } else {
                Alert::warning('Proses Gagal', 'Data yang sama telah terdaftar');
                return redirect('/info/create');
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect('/info/create');
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
        //
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

        $page = Info::where("id", $newid)
        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $umkm = Umkms::where('id', '=', $idumkm[0]->umkms_id)
        ->get();

        // if (empty($page[0])) {
        //     $test = "kosong";
        // } else {
        //     $test = "ada";
        // }

        // dd(
        //     $page,
        // );

        if (empty($page[0])) {
            // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            // return view('admin.pages.error.page_404');
            return redirect()->route("info.index")->with("info", "Data Informasi Website tidak ditemukan");
        } else {
            $pageactive = "admininfoedit";
            $title = "Halaman Edit Data Informasi Website";
            return view('admin.pages.info.edit_info', [
                'page' => $page,
                'umkm' => $umkm,
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
            'phone' => 'required|numeric|digits_between:10,13',
            'title' => 'required|max:255',
            'address' => 'required|max:255',
            'email' => 'required|email|max:255',
            'shopee' => 'sometimes',
            'tokped' => 'sometimes',
            'instagram' => 'sometimes',
            'desc_umkm' => 'sometimes',
            'desc_product' => 'sometimes',
            'desc_detail' => 'sometimes',
            'date' => 'sometimes',
        ])->setAttributeNames(
            [
                'phone' => '"Nomor Telepon"'
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        if ($request->all() != null) {
            //cek
            $cek = DB::table('infos')
                ->Where('no_wa', '=', $request->phone)
                ->count();

            $phone = DB::table('infos')
                ->select('no_wa')
                ->Where('id', '=', $request->id)
                ->get();


            if (auth()->user()->id == 1) {
                $login = $request->desc_login;
                $register = $request->desc_register;
                $lainnya = $request->desc_lainnya;
            } else {
                $login = "";
                $register = "";
                $lainnya = "";
            }


            if ($cek == 0 || $request->phone == $phone[0]->no_wa) {
                DB::table('infos')->where('id', $request->id)
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'no_wa' => $request->phone,
                    'title' => $request->title,
                    'alamat' => $request->address,
                    'link_email' => $request->email,
                    'link_shopee' => $request->shopee,
                    'link_tokped' => $request->tokped,
                    'link_instagram' => $request->instagram,
                    'description_login' => $login,
                    'description_register' => $register,
                    'description_umkm' => $request->desc_umkm,
                    'description_product' => $request->desc_product,
                    'description_detail' => $request->desc_detail,
                    'description_lainnya' => $lainnya,
                    'date' => $request->date
                ]);

                DB::table('umkms')->where('id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'location' => $request->address,
                    'districts' => $request->districts,
                    'ward' => $request->ward,
                    'city' => $request->city,
                    'province' => $request->province,
                    'postal_code' => $request->postal_code,
                    'phone' => $request->phone,
                    'open_time' => $request->open_time,
                    'close_time' => $request->close_time,
                ]);

                // Alert::success('Update Berhasil', 'Data telah tersimpan');
                // return redirect('/info');
                return redirect()->route("info.index")->with("info", "Data Informasi Website berhasil diperbaharui");
            } else {
                // Alert::warning('Proses Gagal', 'Data yang sama telah terdaftar');
                // return redirect()->route("info.edit", $id);
                return back()->with("info", "Data yang sama telah terdaftar");
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect()->route("info.edit", $id);
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

        if ($id != null) {
            $cek = Info::where('id', '=', $newid)
            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            if (empty($cek[0])) {
                Alert::info('Proses Gagal', 'Data tidak ditemukan');
                return Redirect::back();
            } else {
                $delete = Info::findOrFail($newid);
                $delete->delete();
                // Alert::success('Proses Berhasil', 'Data berhasil dihapus');
                // return Redirect::back();
                return redirect()->route("info.index")->with("info", "Data Informasi Website berhasil dihapus");
            }
        } else {
            Alert::info('Proses Gagal', 'Data tidak ditemukan');
            return Redirect::back();
        }
    }
}
