<?php

namespace App\Http\Controllers\Raja_ongkir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\User;
use App\Models\Umkms;
use App\Models\Customs;
use App\Models\Estimations;
use App\Models\Province;
use App\Models\City;
use App\Models\Courier;
use App\Models\Expeditions;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Redirect;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class Raja_ongkirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Cek Ongkir (Raja Ongkir)";
        $pageactive = 'cekongkir';
        $info = Info::first();
        $cost = [];

        $list_umkm = Umkms::where('id', '>', 2)
        ->get();

        // Raja Ongkir
        $couriers = Courier::pluck('title', 'code');
        $provinces = Province::pluck('title', 'province_id');

        return view(
            'customer.pages.custom.test-ongkir',
            [
            'title' => $title,
            'info' => $info,
            'pageactive' => $pageactive,
            'list_umkm' => $list_umkm,
            'cost' => $cost,
        ],
            compact('couriers', 'provinces')
        );
    }

    // Raja Ongkir
    public function ongkir()
    {
        $title = "Form Custom Order";
        $pageactive = 'customs';
        $info = Info::first();

        $list_umkm = Umkms::where('id', '>', 2)
        ->get();

        // Raja Ongkir
        $couriers = Courier::pluck('title', 'code');
        $provinces = Province::pluck('title', 'province_id');

        return view(
            'customer.pages.custom.test-ongkir',
            [
            'title' => $title,
            'info' => $info,
            'pageactive' => $pageactive,
            'list_umkm' => $list_umkm,
        ],
            compact('couriers', 'provinces')
        );
    }

    public function ambilKota($id)
    {
        $city = City::where('province_id', $id)->pluck('title', 'city_id');
        return json_encode($city);

        // dd(
        //     $id,
        // );
    }

    public function cekOngkir(Request $request)
    {
        $cost = RajaOngkir::ongkosKirim([
            'origin'        => $request->city_origin,
            'destination'   => $request->city_destination,
            'weight'        => $request->weight,
            'courier'       => $request->courier,
        ])->get();

        dd(
            $request,
        );
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
        $title = "Form Custom Order";
        $pageactive = 'customs';
        $info = Info::first();

        $list_umkm = Umkms::where('id', '>', 2)
        ->get();

        // Raja Ongkir
        $couriers = Courier::pluck('title', 'code');
        $provinces = Province::pluck('title', 'province_id');

        // $city_origin2 = RajaOngkir::kota()
        // ->search($request->kotaasal)
        // ->get();

        $city_origin = City::where('title', $request->kotaasal)
        ->get();

        // dd(
        //     $request->all(),
        //     $city_origin[0]->id,
        // );

        $cost = RajaOngkir::ongkosKirim([
            'origin'        => $city_origin[0]->id,
            'destination'   => $request->cbkotatujuan,
            'weight'        => $request->weight,
            'courier'       => $request->cbkurir,
        ])->get();

        // dd(
        //     $request->all(),
        //     $city_origin,
        //     $cost,
        //     array_shift($cost),
        //     extract($cost),
        //     sizeof($cost),
        // );

        // $arr_hasil = [];

        // for ($i=0; $i < sizeof($cost); $i++) {
        //     //
        // }

        return view(
            'customer.pages.custom.test-ongkir',
            [
            'title' => $title,
            'info' => $info,
            'pageactive' => $pageactive,
            'list_umkm' => $list_umkm,
            // 'cost' => $cost,
        ],
            compact('couriers', 'provinces', 'cost')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::where('province_id', $id)->pluck('title', 'city_id');
        return json_encode($city);
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
