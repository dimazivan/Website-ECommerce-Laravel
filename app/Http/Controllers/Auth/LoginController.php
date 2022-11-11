<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Info;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function index()
    {
        $info = Info::first();

        $pageactive = "login";
        $title = "Login Page";
        if (auth()->user() != null) {
            return redirect('/');
        } else {
            return view('customer.login', [
                'info' => $info,
                'pageactive' => $pageactive,
                'title' => $title,
            ]);
        }
    }

    public function login(Request $request)
    {
        // dd(
        //     $request->all()
        //     auth()->user()->username
        // );

        if ($request->username == null || $request->password == null) {
            // Alert::warning('Login Gagal', 'Inputan tidak boleh kosong');
            // return redirect('/login');
            return redirect()->route("index.login")->with("info", "Sesi Login anda habis atau Username dan Password Anda Salah");
        } else {
            if (auth()->user() != null) {
                return redirect('/');
            } else {
                if (Auth::attempt($request->only('username', 'password'))) {
                    if (auth()->user()->role == 'admin' || auth()->user()->role == 'super') {
                        // toast('You\'ve Successfully Login!', 'success');
                        Alert::success('Congrats', 'You\'ve Successfully Login');
                        return redirect('/admin');
                    } elseif (auth()->user()->role == 'user') {
                        Alert::success('Congrats', 'You\'ve Successfully Login');
                        // toast('You\'ve Successfully Login!', 'success');
                        return redirect('/');
                    } elseif (auth()->user()->role == 'produksi') {
                        Alert::success('Congrats', 'You\'ve Successfully Login');
                        return redirect('/produksi');
                    } else {
                        return redirect('login');
                    }
                } else {
                    // toast('Username atau Password Anda Salah', 'warning');
                    // Alert::warning('Login Gagal', 'Username atau Password Anda Salah');
                    // return redirect('/login');
                    return redirect()->route("index.login")->with("info", "Username atau Password Anda Salah");
                }
            }
        }
    }

    public function logout()
    {
        if (auth()->user()) {
            Auth::logout();
            Alert::success('Congrats', 'You\'ve Successfully Logout');
            // toast('You\'ve Successfully Logout!', 'success');
            return redirect('/');
        } else {
            return redirect()->route("index.login")->with("info", "Sesi Login anda habis atau Username dan Password Anda Salah");
        }
    }
}
