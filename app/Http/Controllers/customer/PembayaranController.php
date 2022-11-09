<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\Promo;
use App\Models\Payments;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Info::latest()->first();

        $pembayaran = Payments::join('umkms', 'umkms.id', '=', 'payments.umkms_id')
        ->get();
        $pageactive = 'pembayaran';

        if (isset($info->title)) {
            $title = $info->title;
        } else {
            $title = "Homepage";
        }

        return view('customer.pages.product.list_pembayaran', [
            // 'page' => $page,
            'pembayaran' => $pembayaran,
            'info' => $info,
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
        $info = Info::latest()->first();

        $pembayaran = Payments::join('umkms', 'umkms.id', '=', 'payments.umkms_id')
        ->where('payments.umkms_id', '=', $id)
        ->get();

        // dd(
        //     $id,
        //     $pembayaran,
        // );
        $pageactive = 'pembayaran';

        if (isset($info->title)) {
            $title = $info->title;
        } else {
            $title = "Homepage";
        }

        if (empty($pembayaran[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return redirect('/error');
        } else {
            return view('customer.pages.product.list_pembayaran', [
            // 'page' => $page,
            'pembayaran' => $pembayaran,
            'info' => $info,
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
