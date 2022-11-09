<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\Categorys;
use App\Models\Colors;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class View_productController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Info::latest()->first();
        // $products = Products::all();
        $title = "Semua Produk";

        $products = DB::table('products')
        ->select(
            'products.*',
            'detail_products.*',
            'umkms.umkm_name',
            'detail_products.id as product_id'
        )
        ->where('detail_products.qty', '>=', 0);

        if (request()->has('kategori')) {
            $title = "Semua Produk, Kategori - ".request('kategori');
            $products = $products
            ->where('products.category', '=', request('kategori'));
        }

        if (request()->has('warna')) {
            $title = "Semua Produk, Warna - ".request('warna');
            $products = $products
            ->where('detail_products.color', '=', request('warna'));
        }

        if (request()->has('ukuran')) {
            $title = "Semua Produk, Ukuran - ".request('ukuran');
            $products = $products
            ->where('detail_products.size', '=', request('ukuran'));
        }

        if (request()->has('nama')) {
            $title = "Semua Produk,".request('nama');
            $products = $products
            ->where('products.name', 'like', '%'.request('nama').'%')
            ->orWhere('products.category', 'like', '%'.request('nama').'%')
            ->orWhere('detail_products.color', 'like', '%'.request('nama').'%')
            ->orWhere('detail_products.price', 'like', '%'.request('nama').'%');
        }

        $products = $products
        ->join('umkms', 'products.umkms_id', '=', 'umkms.id')
        ->join('detail_products', 'detail_products.products_id', '=', 'products.id')
        ->paginate(9) //ini buat nampilin jumlah nya
        ->appends([
            'kategori' => request('kategori'),
            'warna' => request('warna'),
            'ukuran' => request('ukuran'),
        ]);
        // ->get();

        // $category = DB::table('products as p')
        // ->select('p.category as name', 'count(a.id) as count')
        // ->join('products AS a', 'p.id', '=', 'a.id')
        // ->groupBy('p.category')
        // ->orderBy('p.category')
        // ->get();

        $category = DB::table('products as p')
        ->select('p.category as name')->distinct()
        ->selectRaw('count(a.id) as count')
        ->leftJoin('products as a', 'p.id', '=', 'a.id')
        ->groupby('p.category')
        ->orderby('p.category')
        ->get();

        // $color = Colors::all();
        $color = DB::table('detail_products as p')
        ->select('p.color as name')->distinct()
        ->selectRaw('count(a.id) as count')
        ->leftJoin('products as a', 'p.products_id', '=', 'a.id')
        ->groupby('p.color')
        ->orderby('p.color')
        ->get();

        // dd(
        //     $category,
        //     $color,
        // );

        $pageactive = 'shop';
        return view('customer.pages.product.shop', [
            // 'page' => $page,
            // compact('products'),
            'products' => $products,
            'category' => $category,
            'color' => $color,
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
        $info = Info::first();
        $products = DB::table('products')
        ->select(
            'products.*',
            'detail_products.*',
            'umkms.umkm_name',
            'umkms.id as umkms_id',
            'detail_products.id as product_id'
        )
        ->where('detail_products.qty', '>=', 0)
        ->where('detail_products.id', '=', $id)
        ->join('umkms', 'products.umkms_id', '=', 'umkms.id')
        ->join('detail_products', 'detail_products.products_id', '=', 'products.id')
        ->get();

        $all = DB::table('products')
        ->select('products.*', 'detail_products.*')
        ->where('detail_products.qty', '>=', 0)
        ->join('detail_products', 'detail_products.products_id', '=', 'products.id')
        ->paginate(9);

        // dd(
        //     $products,
        //     $products[0]->pict_1,
        // );

        if (empty($products[0])) {
            return redirect('/error');
        } else {
            $title = "Detail Produk ".$products[0]->umkm_name.", Number Id : ".$id;
            $pageactive = 'detail_product';
            return view('customer.pages.product.detail_product', [
            // 'page' => $page,
            // compact('products'),
            'all' => $all,
            'products' => $products,
            'title' => $title,
            'info' => $info,
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
