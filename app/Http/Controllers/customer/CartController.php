<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\User;
use App\Models\Orders;
use App\Models\Expeditions;
use App\Models\Detail_orders;
use App\Models\Carts;
use App\Models\Promo;
use App\Models\Umkms;
use App\Models\Detail_products;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Redirect;
use Carbon\Carbon;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Info::first();

        $page = Carts::select(
            'cart.*',
            'products.pict_1 as pict_products',
            'umkms.umkm_name',
            'promos.name as nama_promo',
            'promos.kode as kode_promo',
        )
        ->join('products', 'products.id', '=', 'cart.products_id')
        ->join('umkms', 'umkms.id', '=', 'cart.umkms_id')
        ->leftjoin('promos', 'promos.id', '=', 'cart.promos_id')
        ->where('users_id', '=', auth()->user()->id)->get();

        $total = Carts::where('users_id', '=', auth()->user()->id)
        ->sum('subtotal');

        $promo = Carts::select(
            'promos.name as nama_promo',
            'promos.kode as kode_promo',
            'promos.jumlah as jumlah_promo',
        )
        ->leftjoin('promos', 'promos.id', '=', 'cart.promos_id')
        ->where('cart.promos_id', '>', 0)
        ->where('users_id', '=', auth()->user()->id)->get();

        // dd(
        //     $page,
        //     $total,
        // );

        $pageactive = "cart";
        $title = "Keranjang Anda";
        return view('customer.pages.product.cart', [
            'page' => $page,
            'promo' => $promo,
            'total' => $total,
            'pageactive' => $pageactive,
            'title' => $title,
            'info' => $info,
        ]);
    }

    public function add_cart(Request $request)
    {
        $tanggal = Carbon::now()->toDateTimeString();
        $waktu = Carbon::now();
        $id_umkm = Umkms::where('umkm_name', '=', $request->product_umkm_name)->get();
        $id_product = Detail_products::where('id', '=', $request->product_id)->get();
        $cekdup = Carts::where('products_id', '=', $id_product[0]->products_id)
        ->where('detail_products_id', '=', $request->product_id)
        ->where('umkms_id', '=', $id_umkm[0]->id)
        ->get();

        // dd(
        //     $request->all(),
        //     $tanggal,
        //     $waktu,
        //     $id_product[0]->products_id,
        //     $id_umkm[0]->id,
        // );

        if ($request->product_id != null) {
            // Cek Duplikat
            if (empty($cekdup[0])) {
                //Cek promo
                if ($request->product_promo == null ||
                    $request->product_promo == 0 ||
                    $request->product_promo > $request->product_price) {
                    // Cek Umkm
                    if (empty($id_umkm[0])) {
                        Alert::info('Proses Gagal', 'UMKM tidak Valid');
                        return Redirect::back();
                    } else {
                        if ($request->jumlah_beli <= 0) {
                            Carts::create([
                                'umkms_id' => $id_umkm[0]->id,
                                'users_id' => auth()->user()->id,
                                'promos_id' => 0,
                                'products_id' => $id_product[0]->products_id,
                                'detail_products_id' => $request->product_id,
                                'products_name' => $request->product_name,
                                'color' => $request->product_color,
                                'category' => $request->product_category,
                                'size' => $request->product_size,
                                'qty' => 1,
                                'price' => $request->product_price,
                                'subtotal' => 1*$request->product_price,
                                'date' => $tanggal,
                                'created_at' => $waktu,
                            ]);

                            Alert::success('Proses Berhasil', 'Keranjang berhasil diperbaharui');
                            return Redirect::back();
                        } else {
                            // Harga Normal
                            Carts::create([
                                'umkms_id' => $id_umkm[0]->id,
                                'users_id' => auth()->user()->id,
                                'promos_id' => 0,
                                'products_id' => $id_product[0]->products_id,
                                'detail_products_id' => $request->product_id,
                                'products_name' => $request->product_name,
                                'color' => $request->product_color,
                                'category' => $request->product_category,
                                'size' => $request->product_size,
                                'qty' => $request->jumlah_beli,
                                'price' => $request->product_price,
                                'subtotal' => $request->jumlah_beli*$request->product_price,
                                'date' => $tanggal,
                                'created_at' => $waktu,
                            ]);

                            Alert::success('Proses Berhasil', 'Keranjang berhasil diperbaharui');
                            return Redirect::back();
                        }
                    }
                } else {
                    if ($request->jumlah_beli <= 0) {
                        Carts::create([
                            'umkms_id' => $id_umkm[0]->id,
                            'users_id' => auth()->user()->id,
                            'promos_id' => 0,
                            'products_id' => $id_product[0]->products_id,
                            'detail_products_id' => $request->product_id,
                            'products_name' => $request->product_name,
                            'color' => $request->product_color,
                            'category' => $request->product_category,
                            'size' => $request->product_size,
                            'qty' => 1,
                            'price' => $request->product_promo,
                            'subtotal' => 1*$request->product_promo,
                            'date' => $tanggal,
                            'created_at' => $waktu,
                        ]);

                        Alert::success('Proses Berhasil', 'Keranjang berhasil diperbaharui');
                        return Redirect::back();
                    } else {
                        // Harga Promo
                        Carts::create([
                            'umkms_id' => $id_umkm[0]->id,
                            'users_id' => auth()->user()->id,
                            'promos_id' => 0,
                            'products_id' => $id_product[0]->products_id,
                            'detail_products_id' => $request->product_id,
                            'products_name' => $request->product_name,
                            'color' => $request->product_color,
                            'category' => $request->product_category,
                            'size' => $request->product_size,
                            'qty' => $request->jumlah_beli,
                            'price' => $request->product_promo,
                            'subtotal' => $request->jumlah_beli*$request->product_promo,
                            'date' => $tanggal,
                            'created_at' => $waktu,
                        ]);

                        Alert::success('Proses Berhasil', 'Keranjang berhasil diperbaharui');
                        return Redirect::back();
                    }
                }
            } else {
                if ($request->product_promo == null ||
                    $request->product_promo == 0 ||
                    $request->product_promo > $request->product_price) {
                    // Cek Umkm
                    if (empty($id_umkm[0])) {
                        Alert::info('Proses Gagal', 'UMKM tidak Valid');
                        return Redirect::back();
                    } else {
                        if ($request->jumlah_beli <= 0) {
                            $jml_baru = 0 + $cekdup[0]->qty;

                            DB::table('cart')->where('id', $cekdup[0]->id)->update([
                                'umkms_id' => $id_umkm[0]->id,
                                'users_id' => auth()->user()->id,
                                'promos_id' => 0,
                                'products_id' => $id_product[0]->products_id,
                                'detail_products_id' => $request->product_id,
                                'products_name' => $request->product_name,
                                'color' => $request->product_color,
                                'category' => $request->product_category,
                                'size' => $request->product_size,
                                'qty' => $jml_baru,
                                'price' => $request->product_price,
                                'subtotal' => $jml_baru * $request->product_price,
                                'date' => $tanggal,
                                'created_at' => $waktu,
                            ]);

                            Alert::success('Proses Berhasil', 'Keranjang berhasil diperbaharui');
                            return Redirect::back();
                        } else {
                            // Harga Normal
                            $jml_baru = $request->jumlah_beli + $cekdup[0]->qty;

                            DB::table('cart')->where('id', $cekdup[0]->id)->update([
                                'umkms_id' => $id_umkm[0]->id,
                                'users_id' => auth()->user()->id,
                                'promos_id' => 0,
                                'products_id' => $id_product[0]->products_id,
                                'detail_products_id' => $request->product_id,
                                'products_name' => $request->product_name,
                                'color' => $request->product_color,
                                'category' => $request->product_category,
                                'size' => $request->product_size,
                                'qty' => $jml_baru,
                                'price' => $request->product_price,
                                'subtotal' => $jml_baru * $request->product_price,
                                'date' => $tanggal,
                                'created_at' => $waktu,
                            ]);

                            Alert::success('Proses Berhasil', 'Keranjang berhasil diperbaharui');
                            return Redirect::back();
                        }
                    }
                } else {
                    if ($request->jumlah_beli <= 0) {
                        // Harga Promo
                        $jml_baru = 0 + $cekdup[0]->qty;

                        DB::table('cart')->where('id', $cekdup[0]->id)->update([
                            'umkms_id' => $id_umkm[0]->id,
                            'users_id' => auth()->user()->id,
                            'promos_id' => 0,
                            'products_id' => $id_product[0]->products_id,
                            'detail_products_id' => $request->product_id,
                            'products_name' => $request->product_name,
                            'color' => $request->product_color,
                            'category' => $request->product_category,
                            'size' => $request->product_size,
                            'qty' => $jml_baru,
                            'price' => $request->product_promo,
                            'subtotal' => $jml_baru*$request->product_promo,
                            'date' => $tanggal,
                            'created_at' => $waktu,
                        ]);

                        Alert::success('Proses Berhasil', 'Keranjang berhasil diperbaharui');
                        return Redirect::back();
                    } else {
                        // Harga Promo
                        $jml_baru = $request->jumlah_beli + $cekdup[0]->qty;

                        DB::table('cart')->where('id', $cekdup[0]->id)->update([
                            'umkms_id' => $id_umkm[0]->id,
                            'users_id' => auth()->user()->id,
                            'promos_id' => 0,
                            'products_id' => $id_product[0]->products_id,
                            'detail_products_id' => $request->product_id,
                            'products_name' => $request->product_name,
                            'color' => $request->product_color,
                            'category' => $request->product_category,
                            'size' => $request->product_size,
                            'qty' => $jml_baru,
                            'price' => $request->product_promo,
                            'subtotal' => $jml_baru*$request->product_promo,
                            'date' => $tanggal,
                            'created_at' => $waktu,
                        ]);

                        Alert::success('Proses Berhasil', 'Keranjang berhasil diperbaharui');
                        return Redirect::back();
                    }
                }
            }
        } else {
            Alert::info('Proses Gagal', 'Keranjang Gagal Diperbaharui');
            return Redirect::back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $waktu = carbon::now();

        $tanggal_awal = Carts::select('created_at')
        ->where('users_id', '=', auth()->user()->id)
        ->orderBy('created_at', 'asc')
        ->get();

        $tanggal_akhir = Carts::select('updated_at')
        ->where('users_id', '=', auth()->user()->id)
        ->orderBy('updated_at', 'desc')
        ->get();

        $cart = Carts::select('cart.*', 'products.pict_1 as pict_products', 'umkms.umkm_name')
        ->join('products', 'products.id', '=', 'cart.products_id')
        ->join('umkms', 'umkms.id', '=', 'cart.umkms_id')
        ->where('users_id', '=', auth()->user()->id)->get();

        $user = User::where("users.id", auth()->user()->id)
        ->join('customers', 'customers.users_id', '=', 'users.id')
        ->get();

        $total = Carts::where('users_id', '=', auth()->user()->id)
        ->sum('subtotal');

        $shipping = Expeditions::distinct()
        ->get();

        $info = Info::first();

        // dd(
        //     $cart,
        //     $user,
        //     $waktu,
        //     $shipping,
        // );

        if (empty($cart[0])) {
            Alert::warning('Proses Gagal', 'Keranjang Anda masih kosong...');
            return redirect('/cart');
        } else {
            if (empty($user[0])) {
                Alert::warning('Proses Gagal', 'Silahkan masukkan data diri Anda');
                return redirect('/profile');
            } else {
                $title = "Checkout Page";
                $pageactive = 'checkout';

                return view('customer.pages.order.checkout', [
                'user' => $user,
                'cart' => $cart,
                'shipping' => $shipping,
                'total' => $total,
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir,
                'title' => $title,
                'info' => $info,
                'pageactive' => $pageactive,
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
        // $waktu = Carbon::now();
        // $tanggal = Carbon::now()->toDateTimeString();
        // $cart = Carts::select('cart.*', 'products.pict_1 as pict_products', 'umkms.umkm_name')
        // ->join('products', 'products.id', '=', 'cart.products_id')
        // ->join('umkms', 'umkms.id', '=', 'cart.umkms_id')
        // ->where('users_id', '=', auth()->user()->id)->get();

        $jenis = Carts::select('umkms_id')
        ->distinct()
        ->get();

        // dd(
        //     $request->all(),
        // $waktu,
        // $tanggal,
        // $cart,
        // $cart[0]->products_id,
        // $cart[1]->products_id,
        // $cart[0]->products_name,
        // $cart[1]->products_name,
        // sizeof($cart),
        // $jenis,
        // $jenis[0]->umkms_id,
        // sizeof($jenis),
        // );

        if ($request->cbshipping != null) {
            // Insert
            for ($z=0; $z < sizeof($jenis); $z++) {
                $cart = Carts::select('cart.*')
                ->join('products', 'products.id', '=', 'cart.products_id')
                ->join('umkms', 'umkms.id', '=', 'cart.umkms_id')
                ->where('cart.umkms_id', '=', $jenis[$z]->umkms_id)
                ->where('cart.users_id', '=', auth()->user()->id)
                ->get();

                $waktu = Carbon::now();
                $tanggal = Carbon::now()->toDateTimeString();
                $total = Carts::where('users_id', '=', auth()->user()->id)
                ->where('cart.umkms_id', '=', $jenis[$z]->umkms_id)
                ->sum('subtotal');

                // dd(
                //     $cart,
                // );

                if ($cart[0]->promos_id == 0) {
                    Orders::create([
                        'users_id' => auth()->user()->id,
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'phone' => $request->phone,
                        'postal_code' => $request->postal_code,
                        'address' => $request->address,
                        'districts' => $request->districts,
                        'ward' => $request->ward,
                        'city' => $request->city,
                        'province' => $request->province,
                        'desc' => $request->desc,
                        'date' => $tanggal,
                        'total' => $total,
                        'status' => 'Menunggu Konfirmasi',
                        'keterangan' => $request->detail,
                        'shipping' => $request->cbshipping,
                        'created_at' => $waktu,
                    ]);
                } else {
                    Orders::create([
                        'users_id' => auth()->user()->id,
                        'promos_id' => $cart[0]->promos_id,
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'phone' => $request->phone,
                        'postal_code' => $request->postal_code,
                        'address' => $request->address,
                        'districts' => $request->districts,
                        'ward' => $request->ward,
                        'city' => $request->city,
                        'province' => $request->province,
                        'desc' => $request->desc,
                        'date' => $tanggal,
                        'potongan' => $cart[0]->potongan,
                        'total' => $total,
                        'status' => 'Menunggu Konfirmasi',
                        'keterangan' => $request->detail,
                        'shipping' => $request->cbshipping,
                        'created_at' => $waktu,
                    ]);
                }



                $orders_id = 0;
                $orders_id = Orders::where('phone', '=', $request->phone)
                ->where('users_id', '=', auth()->user()->id)
                ->orderBy('id', 'desc')
                ->first();

                $total = 0;

                // dd(
                //     $tanggal,
                //     $waktu,
                //     $orders_id,
                //     $orders_id[0],
                //     $orders_id->id,
                // );

                if (!empty($orders_id)) {
                    $waktu_detail = Carbon::now();
                    $j = 0;

                    // $cart = Carts::select('cart.*')
                    // ->join('products', 'products.id', '=', 'cart.products_id')
                    // ->join('umkms', 'umkms.id', '=', 'cart.umkms_id')
                    // ->where('cart.umkms_id', '=', $jenis[$z]->umkms_id)
                    // ->where('cart.users_id', '=', auth()->user()->id)->get();

                    for ($i=0; $i < sizeof($cart) ; $i++) {
                        Detail_orders::create([
                            'orders_id' => $orders_id->id,
                            'umkms_id' => $cart[$j]->umkms_id,
                            'products_id' => $cart[$j]->products_id,
                            'detail_products_id' => $cart[$j]->detail_products_id,
                            'products_name' => $cart[$j]->products_name,
                            'category' => $cart[$j]->category,
                            'size' => $cart[$j]->size,
                            'color' => $cart[$j]->color,
                            'qty' => $cart[$j]->qty,
                            'normal_price' => $cart[$j]->price,
                            'price' => $cart[$j]->price,
                            'subtotal' => $cart[$j]->subtotal,
                            'created_at' => $waktu_detail,
                        ]);
                        $j++;
                    }
                }
            }
            $delete = Carts::where('users_id', '=', auth()->user()->id);
            $delete->delete();

            // dd(
            //     $orders_id,
            //     $jenis,
            //     sizeof($jenis),
            //     $total,
            //     $tanggal,
            //     $waktu,
            //     $z,
            // );

            Alert::success('Orderan diterima', 'Cek status pesanan pada halaman history');
            return redirect('/');
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return Redirect::back();
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
        // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
        // return redirect('/error');
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
        // dd(
        //     $id,
        //     $request->all(),
        // );
    }

    public function updatecart(Request $request)
    {
        // $waktu = Carbon::now();

        $id_promos = Promo::where('kode', '=', $request->code_coupon)
        ->where('status', '=', 'aktif')
        ->get();

        if (empty($id_promos[0])) {
            $id_promos = 0;
        }

        // if ($id_promos[0]->umkms_id == $request->product_umkm_id[0]) {
        //     $test = "benar";
        // } else {
        //     $test = "salah";
        // }

        // dd(
        //     $id_promos,
        //     $id_promos[0]->umkms_id,
        //     !empty($id_promos[0]->umkms_id),
        //     $request->product_umkm_id[0],
        //     (int)$request->product_umkm_id[0],
        //     intval($request->product_umkm_id[0]),
        //     $request->all(),
        //     $test,
        // );

        // Perulangan
        $j = 0;
        for ($i=0; $i < sizeof($request->product_id); $i++) {
            if (empty($id_promos[0]->umkms_id)) {
                if ($request->qty[$j] <= 0) {
                    $waktu = Carbon::now();
                    //Update
                    DB::table('cart')->where('id', $request->id[$j])
                    ->where('detail_products_id', '=', $request->detail_products_id[$j])
                    ->where('created_at', '=', $request->created_at[$j])
                    ->update([
                        'promos_id' => $id_promos,
                        'qty' => 1,
                        'potongan' => 0,
                        'subtotal' => $request->product_price[$j]*1,
                        'created_at' => $waktu,
                    ]);
                } else {
                    $waktu = Carbon::now();
                    //Update
                    DB::table('cart')->where('id', $request->id[$j])
                    ->where('detail_products_id', '=', $request->detail_products_id[$j])
                    ->where('created_at', '=', $request->created_at[$j])
                    ->update([
                        'promos_id' => $id_promos,
                        'qty' => $request->qty[$j],
                        'potongan' => 0,
                        'subtotal' => $request->product_price[$j]*$request->qty[$j],
                        'created_at' => $waktu,
                    ]);
                }
            } else {
                if ($id_promos[0]->umkms_id == $request->product_umkm_id[$i]) {
                    // Ada Promo
                    $promo = 0;
                    $sub = 0;
                    if ($id_promos[0]->jumlah <= 100) {
                        // Diskon
                        if ($request->qty[$j] <= 0) {
                            $promo = $request->product_price[$j]*($id_promos[0]->jumlah/100);
                            $sub = ($request->product_price[$j]*1)-$promo;
                            $waktu = Carbon::now();
                            //Update
                            DB::table('cart')->where('id', $request->id[$j])
                            ->where('detail_products_id', '=', $request->detail_products_id[$j])
                            ->where('created_at', '=', $request->created_at[$j])
                            ->update([
                                'promos_id' => $id_promos[0]->id,
                                'qty' => 1,
                                'potongan' => $promo,
                                'subtotal' => $sub,
                                'created_at' => $waktu,
                            ]);
                        } else {
                            $promo = $request->product_price[$j]*($id_promos[0]->jumlah/100);
                            $sub = ($request->product_price[$j]*$request->qty[$j])-$promo;
                            $waktu = Carbon::now();
                            //Update
                            DB::table('cart')->where('id', $request->id[$j])
                            ->where('detail_products_id', '=', $request->detail_products_id[$j])
                            ->where('created_at', '=', $request->created_at[$j])
                            ->update([
                                'promos_id' => $id_promos[0]->id,
                                'qty' => $request->qty[$j],
                                'potongan' => $promo,
                                'subtotal' => $sub,
                                'created_at' => $waktu,
                        ]);
                        }
                    } else {
                        // Nominal
                        if ($request->qty[$j] <= 0) {
                            $promo = $id_promos[0]->jumlah;
                            $sub = ($request->product_price[$j]*1)-$promo;
                            $waktu = Carbon::now();
                            //Update
                            DB::table('cart')->where('id', $request->id[$j])
                            ->where('detail_products_id', '=', $request->detail_products_id[$j])
                            ->where('created_at', '=', $request->created_at[$j])
                            ->update([
                                'promos_id' => $id_promos[0]->id,
                                'qty' => 1,
                                'potongan' => $promo,
                                'subtotal' => $sub,
                                'created_at' => $waktu,
                            ]);
                        } else {
                            $promo = $id_promos[0]->jumlah;
                            $sub = ($request->product_price[$j]*$request->qty[$j])-$promo;
                            $waktu = Carbon::now();
                            //Update
                            DB::table('cart')->where('id', $request->id[$j])
                            ->where('detail_products_id', '=', $request->detail_products_id[$j])
                            ->where('created_at', '=', $request->created_at[$j])
                            ->update([
                                'promos_id' => $id_promos[0]->id,
                                'qty' => $request->qty[$j],
                                'potongan' => $promo,
                                'subtotal' => $sub,
                                'created_at' => $waktu,
                            ]);
                        }
                    }
                // Tanpa Promo
                } else {
                    if ($request->qty[$j] <= 0) {
                        $waktu = Carbon::now();
                        //Update
                        DB::table('cart')->where('id', $request->id[$j])
                        ->where('detail_products_id', '=', $request->detail_products_id[$j])
                        ->where('created_at', '=', $request->created_at[$j])
                        ->update([
                            'promos_id' => $id_promos,
                            'qty' => 1,
                            'potongan' => 0,
                            'subtotal' => $request->product_price[$j]*1,
                            'created_at' => $waktu,
                        ]);
                    } else {
                        $waktu = Carbon::now();
                        //Update
                        DB::table('cart')->where('id', $request->id[$j])
                        ->where('detail_products_id', '=', $request->detail_products_id[$j])
                        ->where('created_at', '=', $request->created_at[$j])
                        ->update([
                            'promos_id' => $id_promos,
                            'qty' => $request->qty[$j],
                            'potongan' => 0,
                            'subtotal' => $request->product_price[$j]*$request->qty[$j],
                            'created_at' => $waktu,
                        ]);
                    }
                }
            }

            $j++;
        }
        // dd(
        //     $request->all(),
        //     $request->id[0],
        //     $request->qty[0],
        //     $request->product_price[0],
        //     sizeof($request->product_id),
        //     $waktu,
        //     $i,
        // );
        Alert::success('Proses Berhasil', 'Item berhasil diperbaharui');
        return Redirect::back();
    }

    public function delcart($id)
    {
        // dd(
        //     $id,
        // );

        if ($id != null) {
            $delete = Carts::findOrFail($id);
            $delete->delete();
            Alert::success('Proses Berhasil', 'Item berhasil dihapus');
            return Redirect::back();
        } else {
            Alert::warning('Proses Gagal', 'Item tidak ditemukan');
            return Redirect::back();
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
        if ($id != null) {
            $delete = Carts::findOrFail($id);
            $delete->delete();
            Alert::success('Proses Berhasil', 'Item berhasil dihapus');
            return Redirect::back();
        } else {
            Alert::warning('Proses Gagal', 'Item tidak ditemukan');
            return Redirect::back();
        }
    }
}
