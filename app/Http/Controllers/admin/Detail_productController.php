<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Detail_products;
use App\Models\Categorys;
use App\Models\Colors;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class Detail_productController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $idumkm = DB::table('users')
        // ->where('username', '=', auth()->user()->username)
        // ->get();

        // $page = Categorys::where('umkms_id', '=', $idumkm[0]->umkms_id)
        // ->get();

        // $cekpage = DB::table('categorys')
        // ->where('umkms_id', '=', $idumkm[0]->umkms_id)
        // ->count();

        // $page = Detail_products::where("detail_products.products_id", $id)
        // ->where('products.umkms_id', '=', $idumkm[0]->umkms_id)
        // ->join('products', 'products.id', '=', 'detail_products.products_id')
        // ->get();

        // dd(
        //     $page[0]->id,
        //     $page[0]->products_id,
        // );
        // $detail = DB::table('detail_products')
        //     ->where('products_id', '=', $id)
        //     ->get();

        // $colors = Colors::where('umkms_id', '=', $idumkm[0]->umkms_id)
        //     ->get();

        // $cekcolors = DB::table('colors')
        //     ->where('umkms_id', '=', $idumkm[0]->umkms_id)
        //     ->count();

        // if ($cekcolors == 0) {
        //     Alert::info('Proses Gagal', 'Data Warna Kosong');
        //     return redirect('/warna/create');
        // } else {
        //     if ($cekpage == 0) {
        //         Alert::info('Proses Gagal', 'Data Kategori Kosong');
        //         return redirect('/kategori/create');
        //     } else {
        //         // dd(
        //         //     $page
        //         // );

        //         $pageactive = "adminvarianprodukcreate";
        //         $title = "Halaman Data Varian Produk";
        //         return view('admin.pages.produk.create_detail_produk', [
        //         'page' => $page,
        //         'colors' => $colors,
        //         'detail' => $detail,
        //         'pageactive' => $pageactive,
        //         'title' => $title,
        //         ]);
        //     }
        // }
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
            //cek
            if ($request->cbsize != null
                && $request->cbcolor != null
                && $request->modal > 0
                && $request->price > 0
                && $request->qty > 0
                && ($request->promo < $request->price ||
                $request->promo == 0)) {
                for ($i=0; $i < sizeof($request->cbsize); $i++) {
                    for ($j=0; $j < sizeof($request->cbcolor); $j++) {
                        $cek = DB::table('detail_products')
                        ->where('products_id', '=', $request->id)
                        ->Where('size', '=', $request->cbsize[$i])
                        ->Where('color', '=', $request->cbcolor[$j])
                        ->count();

                        if ($cek == 0) {
                            Detail_products::create([
                                'products_id' => $request->id,
                                'color' => $request->cbcolor[$j],
                                'modal' => $request->modal,
                                'price' => $request->price,
                                'promo' => $request->promo,
                                'size' => $request->cbsize[$i],
                                'qty' => $request->qty
                            ]);
                        } else {
                            Alert::warning('Proses Gagal', 'Nama Produk yang sama telah terdaftar');
                            return redirect()->route("detail_produk.show", $request->id);
                        }
                    }
                }
                Alert::success('Proses Berhasil', 'Data telah tersimpan');
                return redirect()->route("produk.show", $request->id);
            } else {
                Alert::warning('Proses Gagal', 'Silahkan cek data kembali');
                return redirect()->route("detail_produk.show", $request->id);
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect()->route("detail_produk.show", $request->id);
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
        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        // $page = Detail_products::where("detail_products.products_id", $id)
        // ->where('products.umkms_id', '=', $idumkm[0]->umkms_id)
        // ->join('products', 'products.id', '=', 'detail_products.products_id')
        // ->get();

        // $page = Products::where("products.id", $id)
        // ->where('products.umkms_id', '=', $idumkm[0]->umkms_id)
        // ->join('detail_products', 'products.id', '=', 'detail_products.products_id')
        // ->get();

        $page = Products::where("id", $id)
        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
        // ->join('detail_products', 'products.id', '=', 'detail_products.products_id')
        ->get();

        $cat = Categorys::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $cekcat = DB::table('categorys')
        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->count();

        // dd(
        //     $page[0]->id,
        //     $page[0]->products_id,
        // );
        // if (empty($page[0])) {
        //     return view('admin.pages.error.page_404');
        // } else {
        $detail = DB::table('detail_products')
        ->where('products_id', '=', $id)
        ->get();

        $colors = Colors::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $cekcolors = DB::table('colors')
        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->count();

        if (empty($page[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            if ($cekcolors == 0) {
                Alert::info('Proses Gagal', 'Data Warna Kosong');
                return redirect('/warna/create');
            } else {
                if ($cekcat == 0) {
                    Alert::info('Proses Gagal', 'Data Kategori Kosong');
                    return redirect('/kategori/create');
                } else {
                    // dd(
                    //     $page
                    // );

                    $pageactive = "adminvarianprodukcreate";
                    $title = "Halaman Data Varian Produk";
                    return view('admin.pages.produk.create_detail_produk', [
                    'page' => $page,
                    'colors' => $colors,
                    'detail' => $detail,
                    'pageactive' => $pageactive,
                    'title' => $title,
                    ]);
                }
            }
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
        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $page = DB::table('detail_products')
        ->select('*', 'detail_products.id as idvarian')
        ->where("detail_products.id", $id)
        ->where('products.umkms_id', '=', $idumkm[0]->umkms_id)
        ->join('products', 'products.id', '=', 'detail_products.products_id')
        ->get();

        // dd(
        //     $page,
        //     $page[0]->id,
        //     $page[0]->products_id,
        //     $page[0]->idvarian,
        // );
        if (empty($page[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            $colors = Colors::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            $cekcolors = DB::table('colors')
            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->count();

            if ($cekcolors == 0) {
                Alert::info('Proses Gagal', 'Data Warna Kosong');
                return redirect('/warna/create');
            } else {
                // dd(
                //     $page
                // );

                $pageactive = "adminvarianprodukedit";
                $title = "Halaman Edit Data Varian Produk";
                return view('admin.pages.produk.edit_detail_produk', [
                'page' => $page,
                'colors' => $colors,
                // 'detail' => $detail,
                'pageactive' => $pageactive,
                'title' => $title,
                ]);
            }
        }
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
        //     $id,
        // );

        if ($request->all() != null) {
            //cek
            if ($request->cbsize != null
                && $request->cbcolors != null
                && $request->modal > 0
                && $request->price > 0
                && ($request->promo < $request->price ||
                $request->promo == 0)) {
                $cek = DB::table('detail_products')
                        ->where('products_id', '=', $request->idproduk)
                        ->Where('size', '=', $request->cbsize)
                        ->Where('color', '=', $request->cbcolor)
                        ->count();

                $size = DB::table('detail_products')
                ->select('size')
                ->Where('id', '=', $request->id)
                ->get();

                $color = DB::table('detail_products')
                ->select('color')
                ->Where('id', '=', $request->id)
                ->get();

                $cek_products_id = Detail_products::where('id', '=', $request->id)
                ->get();

                if ($cek == 0 || $request->cbsize == $size[0]->size || $request->cbcolors == $color[0]->color) {
                    DB::table('detail_products')->where('id', $request->id)->update([
                        'color' => $request->cbcolors,
                        'modal' => $request->modal,
                        'price' => $request->price,
                        'qty' => $request->qty,
                        'promo' => $request->promo,
                        'size' => $request->cbsize,
                        // 'qty' => $request->qty
                    ]);

                    Alert::success('Proses Berhasil', 'Data telah tersimpan');
                    return redirect()->route("produk.show", $cek_products_id[0]->products_id);
                } else {
                    Alert::warning('Proses Gagal', 'Nama Produk yang sama telah terdaftar');
                    return redirect()->route("detail_produk.edit", $request->id);
                }
            } else {
                Alert::warning('Proses Gagal', 'Silahkan cek data kembali');
                return redirect()->route("detail_produk.edit", $request->id);
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect()->route("detail_produk.edit", $request->id);
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
        // dd(
        //     $id
        // );
        $produk_id = DB::table('detail_products')
        ->select('products_id')
        ->where('id', '=', $id)
        ->get();

        // dd(
        //     $produk_id[0]->products_id
        // );

        if ($id != null) {
            $delete = Detail_products::findOrFail($id);
            $delete->delete();
            Alert::success('Proses Berhasil', 'Data berhasil dihapus');
            return redirect()->route("produk.show", $produk_id[0]->products_id);
        } else {
            Alert::warning('Proses Gagal', 'Data tidak ditemukan');
        }
    }
}
