<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\User;
use App\Models\Customers;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
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
            return view('customer.register', [
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
        //     $request->all()
        // );

        $validator = Validator::make(request()->all(), [
            'username' => 'required|min:5|max:255',
            'email' => 'required|max:255',
            'password' => 'required|min:5|max:255',
            'confirmpassword' => 'required|max:255',
        ])->setAttributeNames(
            [
                'username' => '"Username"',
                'email' => '"Email"',
                'password' => '"Password"',
                'confirmpassword' => '"Confirm Password"',
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        if ($request->all() != null) {
            // Cek Password
            if ($request->password == $request->confirmpassword) {
                // Cek
                $cek = DB::table('users')
                ->where('username', '=', $request->username)
                ->orWhere('email', '=', $request->email)
                ->count();

                if ($cek == 0) {
                    User::create([
                        'umkms_id' => '2',
                        'username' => $request->username,
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                        'role' => 'user',
                    ]);

                    $cekuserid = DB::table('users')
                    ->where('username', '=', $request->username)
                    ->get();

                    Customers::create([
                        'users_id' => $cekuserid[0]->id,
                        'first_name' => $request->username,
                        'last_name' => $request->username,
                    ]);

                    // Alert::success('Proses Registrasi Berhasil', 'Data telah tersimpan, Silahkan Login');
                    // return redirect('/login');
                    return redirect()->route("index.login")->with("info", "Data telah tersimpan, Silahkan Login");
                } else {
                    // Alert::warning('Proses Gagal', 'Username atau Email yang sama telah terdaftar');
                    // return redirect('/register');
                    return back()->with("info", "Username atau Email yang sama telah terdaftar");
                }
            } else {
                Alert::warning('Proses Gagal', 'Password anda tidak sama');
                return redirect('/register');
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect('/register');
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
