<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Info;
use App\Models\Customers;
use App\Models\User;
use App\Models\Expeditions;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Redirect;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Info::first();

        $user = User::where("users.id", auth()->user()->id)
        ->join('customers', 'customers.users_id', '=', 'users.id')
        ->get();

        $pageactive = 'profile';

        if (isset($info->title)) {
            $title = $info->title;
        } else {
            $title = "Homepage";
        }

        if (empty($user[0])) {
            Alert::warning('Proses Gagal', 'Silahkan lengkapi data anda terlebih dahulu');
            return view('customer.pages.profile.create_customer', [
                'info' => $info,
                'pageactive' => $pageactive,
                'title' => $title,
            ]);
        } else {
            return view('customer.pages.profile.profile', [
                'user' => $user,
                'info' => $info,
                'pageactive' => $pageactive,
                'title' => $title,
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
        $info = Info::first();

        // Raja Ongkir
        $couriers = Courier::pluck('title', 'code');
        $provinces = Province::pluck('title', 'province_id');


        $pageactive = 'profilecreate';

        if (isset($info->title)) {
            $title = $info->title;
        } else {
            $title = "Homepage";
        }

        return view(
            'customer.pages.profile.create_customer',
            [
            // 'page' => $page,
            'info' => $info,
            'pageactive' => $pageactive,
            'title' => $title,
        ],
            compact('couriers', 'provinces')
        );
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

        if ($request->all() != null) {
            $users_id = DB::table('users')
            ->select('id')
            ->where('username', '=', auth()->user()->username)
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

            Alert::success('Proses Berhasil', 'Data telah tersimpan');
            return redirect('/profile');
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect('/');
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
        // dd(
        //     $id,
        // );

        // Alert::info('Proses Gagal', 'Halaman Tidak Ditemukkan');
        // return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Alert::info('Proses Gagal', 'Halaman Tidak Ditemukkan');
        // return redirect('/');
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
        //     $request->all(),
        //     auth()->user()->id,
        // );

        if ($request->all() != null) {
            DB::table('customers')->where('users_id', auth()->user()->id)->update([
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

            Alert::success('Update Berhasil', 'Data telah tersimpan');
            return redirect('/profile');
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect('/profile');
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
        // Alert::info('Proses Gagal', 'Halaman Tidak Ditemukkan');
        // return redirect('/');
    }
}
