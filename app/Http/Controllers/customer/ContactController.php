<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Info;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Info::select(
            'infos.*',
            'umkms.open_time as jam_buka',
            'umkms.close_time as jam_tutup',
        )
        ->join('umkms', 'umkms.id', '=', 'infos.umkms_id')
        ->first();

        // if (isset($info->alamat)) {
        //     $test = "ada";
        // } else {
        //     $test = "tidak ada";
        // }

        // dd(
        //     $test,
        // );

        $title = "Contact Information";
        $pageactive = 'contact';
        return view('customer.pages.contact.contact', [
            // 'page' => $page,
            'title' => $title,
            'info' => $info,
            'pageactive' => $pageactive,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
        // return redirect('/error');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
        // return redirect('/error');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = Info::select(
            'infos.*',
            'umkms.open_time as jam_buka',
            'umkms.close_time as jam_tutup',
        )
        ->join('umkms', 'umkms.id', '=', 'infos.umkms_id')
        ->where('infos.umkms_id', '=', $id)
        ->orderBy('infos.id', 'desc')
        ->first();

        // dd(
        //     $page,
        //     $id,
        //     empty($page[0]),
        //     !isset($page),
        // );

        $title = "Contact Information";
        $pageactive = 'contact';

        // if (empty($page[0])) {
        if (!isset($page)) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return redirect('/error');
        } else {
            return view('customer.pages.profile.profile_umkm', [
                'info' => $page,
                'title' => $title,
                'pageactive' => $pageactive,
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
        // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
        // return redirect('/error');
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
        // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
        // return redirect('/error');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
        // return redirect('/error');
    }
}
