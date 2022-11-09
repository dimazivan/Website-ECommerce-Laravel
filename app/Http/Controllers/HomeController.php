<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\Detail_products;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Info::first();

        $products = DB::table('products')
        ->select('products.*', 'detail_products.*', 'umkms.umkm_name', 'detail_products.id as product_id')
        ->where('detail_products.qty', '>=', 0)
        ->join('umkms', 'products.umkms_id', '=', 'umkms.id')
        ->join('detail_products', 'detail_products.products_id', '=', 'products.id')
        ->orderBy('detail_products.id', 'DESC')
        ->paginate(4);

        $popular = DB::table('products')
        ->select('products.*', 'detail_products.*', 'umkms.umkm_name', 'detail_products.id as product_id')
        ->where('detail_products.qty', '>=', 0)
        ->join('umkms', 'products.umkms_id', '=', 'umkms.id')
        ->join('detail_products', 'detail_products.products_id', '=', 'products.id')
        ->orderBy('detail_products.qty', 'ASC')
        ->paginate(4);

        $all = DB::table('products')
        ->select('products.*', 'detail_products.*')
        ->where('detail_products.qty', '>=', 0)
        ->join('detail_products', 'detail_products.products_id', '=', 'products.id')
        ->paginate(9);

        $banner = Detail_products::select(
            'products.*',
            'detail_products.*',
            'umkms.umkm_name as umkm_name',
            'detail_products.id as product_id',
        )
        ->join('products', 'products.id', '=', 'detail_products.products_id')
        ->join('umkms', 'umkms.id', '=', 'products.umkms_id')
        ->orderBy('detail_products.id', 'desc')
        ->paginate(3);

        // dd(
        //     $info->description_1,
        //     $products,
        //     $banner,
        // );

        if (auth()->user() != null) {
            // Cek data
            $cek = DB::table('customers')
                ->Where('users_id', '=', auth()->user()->id)
                ->count();

            // dd(
            //     $cek
            // );

            if ($cek == 0) {
                //insert data customer dulu
                $pageactive = 'profilecreate';
                
                if (isset($info->title)) {
                    $title = $info->title;
                } else {
                    $title = "Homepage";
                }

                Alert::warning('Proses Gagal', 'Silahkan lengkapi data anda terlebih dahulu');
                return view('customer.pages.profile.create_customer', [
                    // 'page' => $page,
                    'all' => $all,
                    'products' => $products,
                    'popular' => $popular,
                    'info' => $info,
                    'pageactive' => $pageactive,
                    'title' => $title,
                    'banner' => $banner,
                ]);
            } else {
                $pageactive = 'home';

                if (isset($info->title)) {
                    $title = $info->title;
                } else {
                    $title = "Homepage";
                }

                return view('customer.index', [
                    // 'page' => $page,
                    'all' => $all,
                    'products' => $products,
                    'popular' => $popular,
                    'info' => $info,
                    'pageactive' => $pageactive,
                    'banner' => $banner,
                    'title' => $title,
                ]);
            }
        } else {
            $pageactive = 'home';

            if (isset($info->title)) {
                $title = $info->title;
            } else {
                $title = "Homepage";
            }

            return view('customer.index', [
                // 'page' => $page,
                'all' => $all,
                'products' => $products,
                'popular' => $popular,
                'info' => $info,
                'pageactive' => $pageactive,
                'banner' => $banner,
                'title' => $title,
            ]);
        }
        

        // $pageactive = 'adminhome';
        // $title = $info->title;
        // return view('customer.index', [
        //     // 'page' => $page,
        //     'info' => $info,
        //     'pageactive' => $pageactive,
        //     'title' => $title,
        // ]);
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
        //
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
