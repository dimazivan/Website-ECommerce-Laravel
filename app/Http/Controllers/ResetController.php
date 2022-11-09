<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ResetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Info::first();

        $title = "Reset Password Page";
        $pageactive = 'reset';

        if (auth()->user() != null) {
            return redirect('/');
        } else {
            return view('customer.forgot', [
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
            'username' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'required|min:5|max:255',
            'confirmpassword' => 'required|max:255',
        ])->setAttributeNames(
            [
                'username' => '"Username"'
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        if ($request->all() != null) {
            //cek
            if ($request->password == $request->confirmpassword) {
                $cek = DB::table('users')
                ->where('username', '=', $request->username)
                ->where('email', '=', $request->email)
                ->count();

                if ($cek == 0) {
                    // Alert::warning('Proses Gagal', 'Data tidak ditemukan atau belum terdaftar');
                    // return redirect('/reset');
                    return back()->with("info", "Data tidak ditemukan atau belum terdaftar");
                } else {
                    DB::table('users')
                    ->where('username', $request->username)
                    ->where('email', $request->email)
                    ->update([
                        'password' => bcrypt($request->password),
                        ]);

                    // Alert::success('Reset Password Berhasil', 'Data telah diubah');
                    // return redirect('/login');
                    return redirect()->route("index.login")->with("info", "Reset Password Berhasil, Data telah diubah");
                }
            } else {
                Alert::warning('Proses Gagal', 'Password anda tidak sama');
                return redirect('/reset');
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect('/reset');
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
