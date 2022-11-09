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

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $page = DB::table('products')
        // ->select('products.*', 'detail_products.price')
        // ->join('detail_products', 'detail_products.products_id', '=', 'products.id')
        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->distinct()
        ->get();


        // $page->description = Str::limit($product->description, 50);

        // dd(
        //     $page[0]->price,
        //     $page
        // );

        $pageactive = 'adminproduct';
        $title = "Halaman Data Produk";
        return view('admin.pages.produk.data_produk', [
            'page' => $page,
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
        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $page = Categorys::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $cekpage = DB::table('categorys')
        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->count();

        $colors = Colors::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $cekcolors = DB::table('colors')
        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->count();

        // dd(
        //     $page,
        //     $cekpage,
        //     $colors,
        //     $cekcolors,
        // );

        if ($cekpage == 0) {
            Alert::info('Proses Gagal', 'Data Kategori Kosong');
            return redirect('/kategori/create');
        } else {
            if ($cekcolors == 0) {
                Alert::info('Proses Gagal', 'Data Warna Kosong');
                return redirect('/warna/create');
            } else {
                $pageactive = 'adminproductcreate';
                $title = "Form Tambah Data Produk";
                return view('admin.pages.produk.create_produk', [
                    'page' => $page,
                    'idumkm' => $idumkm[0]->umkms_id,
                    'colors' => $colors,
                    'pageactive' => $pageactive,
                    'title' => $title,
                ]);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $idproduct = Products::all()->last();

        // dd(
        //     $request->all(),
        //     $ukuran[] = $request->cbsize,
        //     $ukuran = sizeof($request->cbsize),
        //     $warna[] = $request->cbcolor,
        //     $warna = sizeof($request->cbcolor),
        // );
        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        if ($request->all() != null && $request->cbcategory != null) {
            // cek nama produk
            $cek = DB::table('products')
            ->where('name', '=', $request->name)
            ->where('category', '=', $request->cbcategory)
            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->count();

            // dd(
            //     $cek
            // );

            if ($cek == 0) {
                // Cek ukuran
                if (filesize($request->file_foto1) > 1000 * 10000 &&
                filesize($request->file_foto2) > 1000 * 10000 &&
                filesize($request->file_foto3) > 1000 * 10000) {
                    Alert::warning('Proses Gagal', 'Ukuran gambar harus kurang dari 10MB');
                    return redirect('/produk/create');
                } else {
                    // Cek Tipe Gambar
                    if ($request->file_foto1->getClientOriginalExtension() == "jpg" ||
                    $request->file_foto1->getClientOriginalExtension() == "jpeg" ||
                    $request->file_foto1->getClientOriginalExtension() == "png" ||
                    $request->file_foto1->getClientOriginalExtension() == "jpg" ||
                    $request->file_foto1->getClientOriginalExtension() == "jpeg" ||
                    $request->file_foto1->getClientOriginalExtension() == "png" ||
                    $request->file_foto2->getClientOriginalExtension() == "jpg" ||
                    $request->file_foto2->getClientOriginalExtension() == "jpeg" ||
                    $request->file_foto2->getClientOriginalExtension() == "png") {
                        // insert
                        if ($request->hasFile('file_foto1')
                        && $request->hasFile('file_foto2')
                        && $request->hasFile('file_foto3')
                        && $request->modal > 0
                        && $request->price > 0
                        && ($request->promo < $request->price ||
                        $request->promo == 0)
                        && $request->qty > 0
                        && $request->cbcategory != null
                        && $request->cbsize != null
                        && $request->cbcolor != null) {
                            $file_1 = $request->file('file_foto1');
                            $file_2 = $request->file('file_foto2');
                            $file_3 = $request->file('file_foto3');
                            $nama_file_1 = time() . "_" . $file_1->getClientOriginalName();
                            $nama_file_2 = time() . "_" . $file_2->getClientOriginalName();
                            $nama_file_3 = time() . "_" . $file_3->getClientOriginalName();
                            Products::create([
                                'umkms_id' => $idumkm[0]->umkms_id,
                                'name' => $request->name,
                                'category' => $request->cbcategory,
                                'desc' => $request->desc,
                                'pict_1' => $nama_file_1,
                                'pict_2' => $nama_file_2,
                                'pict_3' => $nama_file_3,
                            ]);
                            $tujuan_upload = 'data_produk';
                            $file_1->move($tujuan_upload, $nama_file_1);
                            $file_2->move($tujuan_upload, $nama_file_2);
                            $file_3->move($tujuan_upload, $nama_file_3);

                            $idproduct = Products::all()->last();

                            for ($i=0; $i < sizeof($request->cbsize); $i++) {
                                for ($j=0; $j < sizeof($request->cbcolor); $j++) {
                                    Detail_products::create([
                                        'products_id' => $idproduct->id,
                                        'color' => $request->cbcolor[$j],
                                        'modal' => $request->modal,
                                        'price' => $request->price,
                                        'promo' => $request->promo,
                                        'size' => $request->cbsize[$i],
                                        'qty' => $request->qty
                                    ]);
                                }
                            }

                            // dd(
                            //     $i
                            // );

                            Alert::success('Proses Berhasil', 'Data telah tersimpan');
                            return redirect('/produk');
                        } else {
                            Alert::warning('Proses Gagal', 'Silahkan cek data kembali');
                            return redirect('/produk/create');
                        }
                    } else {
                        Alert::warning('Proses Gagal', 'Jenis file harus bertipe gambar');
                        return redirect('/produk/create');
                    }
                }
            } else {
                Alert::warning('Proses Gagal', 'Produk yang sama telah terdaftar pada sistem');
                return redirect('/produk/create');
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect('/produk/create');
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

        $page = DB::table('products')
        ->select('products.*', 'detail_products.*')
        ->where('products.id', '=', $id)
        ->where('products.umkms_id', '=', $idumkm[0]->umkms_id)
        ->join('detail_products', 'detail_products.products_id', '=', 'products.id')
        ->get();

        $jml_page = DB::table('products')
        ->select('products.*', 'detail_products.*')
        ->where('products.id', '=', $id)
        ->where('products.umkms_id', '=', $idumkm[0]->umkms_id)
        ->join('detail_products', 'detail_products.products_id', '=', 'products.id')
        ->sum('detail_products.qty');

        $detail = DB::table('detail_products')
        ->where('products_id', '=', $id)
        ->get();

        $cekdetail = DB::table('detail_products')
        ->where('products_id', '=', $id)
        ->count();


        // dd(
        //     $page,
        //     $cekdetail,
        //     $detail,
        // );

        if (empty($page[0]) || empty($detail[0])) {
            return view('admin.pages.error.page_404');
        } else {
            if ($cekdetail == 0) {
                // $page = Detail_products::where("detail_products.products_id", $id)
                // ->join('products', 'products.id', '=', 'detail_products.products_id')
                // ->get();

                $page = Products::where("id", $id)
                // ->join('detail_products', 'products.id', '=', 'detail_products.products_id')
                ->get();

                $detail = DB::table('detail_products')
                ->where('products_id', '=', $id)
                ->get();

                $colors = Colors::where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->get();

                $cekcolors = DB::table('colors')
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->count();

                if ($cekcolors == 0) {
                    Alert::info('Proses Gagal', 'Data Warna Kosong');
                    return redirect('/warna/create');
                } else {
                    Alert::warning('Data Varian Kosong', 'Silahkan masukkan varian terlebih dahulu');

                    // dd(
                    //     $page
                    // );

                    $pageactive = "adminvarianprodukcreate";
                    $title = "Halaman Data Varian Produk";
                    return view('admin.pages.produk.create_detail_produk', [
                    'page' => $page,
                    'jml_page' => $jml_page,
                    'colors' => $colors,
                    'detail' => $detail,
                    'pageactive' => $pageactive,
                    'title' => $title,
                    ]);
                }
            } else {
                $pageactive = "adminproductview";
                $title = "Halaman Data Detail Produk";
                return view('admin.pages.produk.view_produk', [
                'page' => $page,
                'jml_page' => $jml_page,
                'detail' => $detail,
                'pageactive' => $pageactive,
                'title' => $title,
                ]);
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

        $page = Products::where("id", $id)
        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $category = Categorys::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $cekcategory = DB::table('categorys')
        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->count();

        // dd(
        //     $page
        // );

        if (empty($page[0])) {
            Alert::info('Proses Gagal', 'Data tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            if ($cekcategory == 0) {
                Alert::info('Proses Gagal', 'Data Kategori Kosong');
                return redirect('/kategori/create');
            } else {
                $pageactive = "adminproductedit";
                $title = "Halaman Edit Data Produk";
                return view('admin.pages.produk.edit_produk', [
                'page' => $page,
                'category' => $category,
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
        //     $request->all()
        // );
        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        if ($request->all() != null && $request->cbcategory != null) {
            // Cek ukuran
            if (filesize($request->file_foto1) > 1000 * 10000 &&
                filesize($request->file_foto2) > 1000 * 10000 &&
                filesize($request->file_foto3) > 1000 * 10000) {
                Alert::warning('Proses Gagal', 'Ukuran gambar harus kurang dari 10MB');
                return redirect()->route("produk.edit", $id);
            } else {
                // Cek Tipe Gambar
                if ($request->file_foto1->getClientOriginalExtension() == "jpg" ||
                    $request->file_foto1->getClientOriginalExtension() == "jpeg" ||
                    $request->file_foto1->getClientOriginalExtension() == "png" ||
                    $request->file_foto1->getClientOriginalExtension() == "jpg" ||
                    $request->file_foto1->getClientOriginalExtension() == "jpeg" ||
                    $request->file_foto1->getClientOriginalExtension() == "png" ||
                    $request->file_foto2->getClientOriginalExtension() == "jpg" ||
                    $request->file_foto2->getClientOriginalExtension() == "jpeg" ||
                    $request->file_foto2->getClientOriginalExtension() == "png") {
                    // cek
                    if ($request->hasFile('file_foto1')
                    && $request->hasFile('file_foto2')
                    && $request->hasFile('file_foto3')
                    && $request->cbcategory != "Pilih Kategori Produk") {
                        // cek kembar
                        $cek = DB::table('products')
                        ->where('name', '=', $request->name)
                        ->where('category', '=', $request->cbcategory)
                        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                        ->count();

                        $name = DB::table('products')
                        ->select('name')
                        ->where('id', '=', $request->id)
                        ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                        ->get();

                        // dd(
                        //     $name->name
                        // );

                        if ($cek == 0 || $request->name == $name[0]->name) {
                            $file_1 = $request->file('file_foto1');
                            $file_2 = $request->file('file_foto2');
                            $file_3 = $request->file('file_foto3');
                            $nama_file_1 = time() . "_" . $file_1->getClientOriginalName();
                            $nama_file_2 = time() . "_" . $file_2->getClientOriginalName();
                            $nama_file_3 = time() . "_" . $file_3->getClientOriginalName();
                            DB::table('products')->where('id', $request->id)->update([
                                'name' => $request->name,
                                'category' => $request->cbcategory,
                                'desc' => $request->desc,
                                'pict_1' => $nama_file_1,
                                'pict_2' => $nama_file_2,
                                'pict_3' => $nama_file_3,
                            ]);
                            $tujuan_upload = 'data_produk';
                            $file_1->move($tujuan_upload, $nama_file_1);
                            $file_2->move($tujuan_upload, $nama_file_2);
                            $file_3->move($tujuan_upload, $nama_file_3);

                            Alert::success('Update Berhasil', 'Data telah tersimpan');
                            return redirect('/produk');
                        } else {
                            Alert::warning('Proses Gagal', 'Nama Produk yang sama telah terdaftar');
                            return redirect()->route("produk.edit", $id);
                        }
                    } else {
                        Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
                        return redirect()->route("produk.edit", $id);
                    }
                } else {
                    Alert::warning('Proses Gagal', 'Jenis file harus bertipe gambar');
                    return redirect()->route("produk.edit", $id);
                }
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect()->route("produk.edit", $id);
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
        if ($id != null) {
            $delete = Products::findOrFail($id);
            $delete->delete();
            Alert::success('Proses Berhasil', 'Data berhasil dihapus');
            return redirect('/produk');
        } else {
            Alert::warning('Proses Gagal', 'Data tidak ditemukan');
        }
    }
}
