<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customers;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Redirect;

class UserController extends Controller
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

        if (auth()->user()->role == "super") {
            $page = User::select(
                'users.*',
                'users.id as id_users',
                'umkms.umkm_name',
            )
            ->join('umkms', 'users.umkms_id', '=', 'umkms.id')
            ->get();
        } else {
            $page = User::select(
                'users.*',
                'users.id as id_users',
                'umkms.umkm_name',
            )
            ->join('umkms', 'users.umkms_id', '=', 'umkms.id')
            ->where('users.umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();
        }

        // $page = User::join('umkms', 'users.umkms_id', '=', 'umkms.id')
        // ->where('users.umkms_id', '=', $idumkm[0]->umkms_id)
        // ->get();

        // dd(
        //     $page
        // );

        $pageactive = "adminuser";
        $title = "Halaman Data User";
        return view('admin.pages.user.data_user', [
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
        $pageactive = "adminusercreate";
        $title = "Form Tambah Data User";
        return view('admin.pages.user.create_user', [
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
            'username' => 'required|min:5|max:255',
            'email' => 'required',
            'cbrole' => 'required',
            'password' => 'required|min:5',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|numeric|digits_between:10,13',
            'districts' => 'required|max:255',
            'ward' => 'required|max:255',
            'city' => 'required|max:255',
            'province' => 'required|max:255',
            'postal_code' => 'required|numeric',
            'desc' => 'required|max:255',
        ])->setAttributeNames(
            [
                'first_name' => '"Nama Depan"',
                'last_name' => '"Nama Belakang"',
                'cbrole' => '"Role User"',
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        if ($request->username != null) {
            // Cek Username
            $cek = DB::table('users')
            ->where('username', '=', $request->username)
            ->orWhere('email', '=', $request->email)
            ->count();

            // dd(
            //     $cek
            // );
            if ($cek == 0) {
                // dd(
                //     $request->all()
                // );
                if ($request->cbrole == "") {
                    Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
                    return redirect('/user/create');
                } else {
                    if (($request->hasFile('file_foto')  &&
                    filesize($request->file_foto) <= 1000 * 10000 &&
                    ($request->file_foto->getClientOriginalExtension() == "jpg" ||
                    $request->file_foto->getClientOriginalExtension() == "jpeg" ||
                    $request->file_foto->getClientOriginalExtension() == "png")) ||
                    $request->hasFile('file_foto') == null) {
                        // Insert
                        if ($request->cbrole == "user") {
                            $id_umkm = 2;
                        } else {
                            $id_umkm = $request->id_umkm;
                        }

                        if ($request->hasFile('file_foto')) {
                            $file = $request->file('file_foto');
                            $nama_file = time() . "_" . $file->getClientOriginalName();
                            $tujuan_upload = 'data_file';
                            $file->move($tujuan_upload, $nama_file);
                        } else {
                            $nama_file = "";
                        }

                        User::create([
                            'username' => $request->username,
                            'umkms_id' => $id_umkm,
                            'email' => $request->email,
                            'password' => bcrypt($request->password),
                            'pict' => $nama_file,
                            'role' => $request->cbrole,
                        ]);

                        $users_id = DB::table('users')
                        ->select('id')
                        ->where('username', '=', $request->username)
                        ->get();

                        Customers::create([
                            'users_id' => $users_id[0]->id,
                            'first_name' => $request->first_name,
                            'last_name' => $request->last_name,
                            'address' => $request->address,
                            'phone' => $request->phone,
                            'districts' => $request->districts,
                            'ward' => $request->ward,
                            'city' => $request->city,
                            'province' => $request->province,
                            'postal_code' => $request->postal_code,
                            'desc' => $request->desc,
                        ]);

                        // Alert::success('Proses Berhasil', 'Data telah tersimpan');
                        // return redirect('/user');
                        return redirect()->route("user.index")->with("info", "Data User berhasil disimpan");
                    } else {
                        Alert::warning('Proses Gagal', 'Terjadi kesalahan');
                        return redirect('/user/create');
                    }
                }
            } else {
                // Alert::warning('Proses Gagal', 'Username atau Email yang sama telah terdaftar');
                // return redirect('/user/create');
                return back()->with("info", "Username atau Email yang sama telah terdaftar");
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect('/user/create');
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

        if (auth()->user()->role == "super") {
            $page = Orders::where("orders.users_id", $newid)
            ->join('users', 'users.id', '=', 'orders.users_id')
            ->join('customers', 'customers.users_id', '=', 'users.id')
            ->get();

            $user = User::where("users.id", $newid)
            ->join('customers', 'customers.users_id', '=', 'users.id')
            ->get();
        } else {
            $page = Orders::join('users', 'users.id', '=', 'orders.users_id')
            ->join('customers', 'customers.users_id', '=', 'users.id')
            ->where('users.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.users_id', $newid)
            ->get();

            $user = User::join('customers', 'customers.users_id', '=', 'users.id')
            ->where('users.id', $newid)
            ->where('users.umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();
        }

        // dd(
        //     $page
        // );

        if (empty($user[0])) {
            // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            // return view('admin.pages.error.page_404');
            return redirect()->route("user.index")->with("info", "Data User tidak ditemukan");
        } else {
            $pageactive = "adminuserview";
            $title = "Halaman Data User";
            return view('admin.pages.user.profile_user', [
                'page' => $page,
                'user' => $user,
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

        if (auth()->user()->role == "super") {
            $page = User::join('customers', 'customers.users_id', '=', 'users.id')
            ->where("users.id", $newid)
            ->get();
        } else {
            $page = User::join('customers', 'customers.users_id', '=', 'users.id')
            ->where("users.id", $newid)
            ->where('users.umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();
        }

        // dd(
        //     $page,
        //     $page[0]->users_id,
        // );

        if (empty($page[0])) {
            // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            // return view('admin.pages.error.page_404');
            return redirect()->route("user.index")->with("info", "Data User tidak ditemukan");
        } else {
            $pageactive = "adminuseredit";
            $title = "Halaman Edit Data User";
            return view('admin.pages.user.edit_user', [
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
            'username' => 'required|min:5|max:255',
            'email' => 'required',
            'cbrole' => 'required',
            'password' => 'required|min:5',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|numeric|digits_between:10,13',
            'districts' => 'required|max:255',
            'ward' => 'required|max:255',
            'city' => 'required|max:255',
            'province' => 'required|max:255',
            'postal_code' => 'required|numeric',
            'desc' => 'required|max:255',
        ])->setAttributeNames(
            [
                'first_name' => '"Nama Depan"',
                'last_name' => '"Nama Belakang"',
                'cbrole' => '"Role User"',
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        if ($request->cbrole == null) {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect()->route("user.edit", $id);
        } else {
            if ($request->username != null) {
                // Cek Username
                $cek = DB::table('users')
                ->Where('email', '=', $request->email)
                ->count();

                $email = DB::table('users')
                ->select('email')
                ->Where('id', '=', $request->id)
                ->get();

                $users_id = DB::table('users')
                ->select('id')
                ->where('username', '=', $request->username)
                ->get();

                $cekuser = DB::table('users')
                ->select('id')
                ->where('username', '=', $request->username)
                ->count();

                // dd(
                //     $email[0]->email,
                //     $cek
                // );

                if ($cek == 0 || $cekuser == 0||
                $request->email == $email[0]->email) {
                    if (($request->hasFile('file_foto') &&
                    filesize($request->file_foto) <= 1000 * 10000 &&
                    ($request->file_foto->getClientOriginalExtension() == "jpg" ||
                    $request->file_foto->getClientOriginalExtension() == "jpeg" ||
                    $request->file_foto->getClientOriginalExtension() == "png"))||
                    $request->hasFile('file_foto') == null) {
                        // Update
                        // $file = $request->file('file_foto');
                        // $nama_file = time() . "_" . $file->getClientOriginalName();
                        // $tujuan_upload = 'data_file';
                        // $file->move($tujuan_upload, $nama_file);

                        if ($request->hasFile('file_foto')) {
                            $file = $request->file('file_foto');
                            $nama_file = time() . "_" . $file->getClientOriginalName();
                            $tujuan_upload = 'data_file';
                            $file->move($tujuan_upload, $nama_file);
                        } else {
                            $nama_file = "";
                        }


                        DB::table('users')->where('id', $users_id[0]->id)->update([
                            'username' => $request->username,
                            'email' => $request->email,
                            'password' => bcrypt($request->password),
                            'pict' => $nama_file,
                            'role' => $request->cbrole,
                        ]);

                        $users_id = DB::table('users')
                        ->select('id')
                        ->where('username', '=', $request->username)
                        ->get();

                        // dd(
                        //     $users_id[0]->id
                        // );

                        DB::table('customers')->where('users_id', $users_id[0]->id)->update([
                            'first_name' => $request->first_name,
                            'last_name' => $request->last_name,
                            'address' => $request->address,
                            'phone' => $request->phone,
                            'districts' => $request->districts,
                            'ward' => $request->ward,
                            'city' => $request->city,
                            'province' => $request->province,
                            'postal_code' => $request->postal_code,
                            'desc' => $request->desc,
                        ]);
                        // Alert::success('Update Berhasil', 'Data telah tersimpan');
                        // return redirect('/user');
                        return redirect()->route("user.index")->with("info", "Data User berhasil diperbaharui");
                    } else {
                        Alert::warning('Proses Gagal', 'Terjadi kesalahan File Foto');
                        return redirect()->route("user.edit", $id);
                    }
                } else {
                    // Alert::warning('Proses Gagal', 'Username atau Email yang sama telah terdaftar');
                    // return redirect()->route("user.edit", $id);
                    return back()->with("info", "Username atau Email yang sama telah terdaftar");
                }
            } else {
                Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
                return redirect()->route("user.edit", $id);
            }
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
            if (auth()->user()->role == "super") {
                $delete = User::findOrFail($newid);
                $delete->delete();
            } else {
                $delete = User::findOrFail($newid)
                ->where('id', '=', $newid)
                ->where('umkms_id', '=', $idumkm[0]->umkms_id);
                $delete->delete();
            }

            // Alert::success('Proses Berhasil', 'Data berhasil dihapus');
            // return Redirect::back();
            return redirect()->route("user.index")->with("info", "Data User berhasil dihapus");
        } else {
            Alert::warning('Proses Gagal', 'Data tidak ditemukan');
            return Redirect::back();
        }
    }
}
