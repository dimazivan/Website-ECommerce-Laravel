<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\User;
use App\Models\Deadlines;
use App\Models\Estimations;
use App\Models\Customers;
use App\Models\Umkms;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class RegisterumkmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Info::first();

        $title = "Register Page";
        $pageactive = 'register';

        if (auth()->user() != null) {
            return redirect('/');
        } else {
            return view('customer.registerumkm', [
            // 'page' => $page,
            'info' => $info,
            'title' => $title,
            'pageactive' => $pageactive,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //     $request->all(),
        // );

        $validator = Validator::make(request()->all(), [
            'username' => 'required|min:5|max:255',
            'email' => 'required|max:255',
            'password' => 'required|min:5|max:255',
            'confirmpassword' => 'required|max:255',
            'name' => 'required|max:255',
            'umkm_name' => 'required|max:255',
            'location' => 'required|max:255',
            'phone' => 'required|digits_between:10,13',
        ])->setAttributeNames(
            [
                'username' => '"Username"',
                'name' => '"Nama"',
                'umkm_name' => '"Nama UMKM"',
                'email' => '"Email"',
                'password' => '"Password"',
                'confirmpassword' => '"Confirm Password"',
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $waktu = Carbon::now();

        if ($request->all() != null) {
            //Cek Password
            if ($request->password == $request->confirmpassword) {
                // Cek
                $cek = DB::table('users')
                ->where('username', '=', $request->username)
                ->orWhere('email', '=', $request->email)
                ->count();

                $cekumkm = DB::table('umkms')
                ->where('owner_name', '=', $request->name)
                ->orWhere('umkm_name', '=', $request->umkm_name)
                ->count();

                if ($cek == 0 && $cekumkm == 0) {
                    Umkms::create([
                        'owner_name' => $request->name,
                        'umkm_name' => $request->umkm_name,
                        'location' => $request->location,
                        // 'districts' => $request->districts,
                        // 'ward' => $request->ward,
                        // 'city' => $request->city,
                        // 'province' => $request->province,
                        // 'postal_code' => $request->postal_code,
                        'phone' => $request->phone,
                    ]);

                    $idumkm = DB::table('umkms')
                    ->where('owner_name', '=', $request->name)
                    ->where('umkm_name', '=', $request->umkm_name)
                    ->get();

                    // Info::create([
                    //     'umkms_id' => $idumkm[0]->id,
                    //     'no_wa' => $request->phone,
                    //     'title' => $request->umkm_name,
                    //     'alamat' => $request->location,
                    //     'date' => $waktu,
                    // ]);

                    // dd(
                    //     $request->all(),
                    //     $idumkm,
                    //     $idumkm[0]->id,
                    // );

                    User::create([
                        'umkms_id' => $idumkm[0]->id,
                        'username' => $request->username,
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                        'role' => 'admin',
                    ]);

                    $cekuserid = DB::table('users')
                    ->where('username', '=', $request->username)
                    ->get();

                    Customers::create([
                        'users_id' => $cekuserid[0]->id,
                        'first_name' => $request->username,
                        'last_name' => $request->username,
                        // 'districts' => $request->districts,
                        // 'ward' => $request->ward,
                        // 'city' => $request->city,
                        // 'province' => $request->province,
                        // 'postal_code' => $request->postal_code,
                    ]);

                    Deadlines::create([
                        'umkms_id' => $idumkm[0]->id,
                        'deadline' => "1",
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    Estimations::create([
                        'umkms_id' => $idumkm[0]->id,
                        'name_process' => "Proses 1",
                        'urutan' => "1",
                        'durasi' => "1",
                    ]);

                    // Alert::success('Proses Registrasi Berhasil', 'Data telah tersimpan, Silahkan Login');
                    // return redirect('/login');
                    return redirect()->route("index.login")->with("info", "Data telah tersimpan, Silahkan Login");
                } else {
                    // Alert::warning('Proses Gagal', 'Username atau Email yang sama telah terdaftar');
                    // return redirect('/umkm');
                    return back()->with("info", "Username atau Email yang sama telah terdaftar");
                }
            } else {
                Alert::warning('Proses Gagal', 'Password anda tidak sama');
                return redirect('/umkm');
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect('/umkm');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
