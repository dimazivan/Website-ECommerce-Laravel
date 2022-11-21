<?php

namespace App\Http\Controllers\Produksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Productions;
use App\Models\Deadlines;
use App\Models\Estimations;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\User;
use App\Models\Umkms;
use App\Models\Detail_orders;
use App\Models\Customs;
use App\Models\Expeditions;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ProductionController extends Controller
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

        // Query Update Produksi
        $page = Productions::select(
            'orders.first_name as nama_depan',
            'orders.last_name as nama_belakang',
            'detail_orders.id as id_detail_orders',
            'detail_orders.orders_id as id_orders',
            'productions.*',
            'productions.id as id_produksi',
        )
        ->join('detail_orders', 'detail_orders.id', '=', 'productions.detail_orders_id')
        ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->where('productions.umkms_id', '=', $idumkm[0]->umkms_id)
        ->orderBy('orders.created_at', 'asc')
        ->orderBy('productions.id', 'asc')
        ->get();

        // dd(
        //     $page,
        // );

        $waktu = Carbon::now();

        // dd(
        //     $page,
        //     sizeof($page),
        //     $waktu,
        // );

        if ($page != null) {
            for ($i=0; $i < sizeof($page); $i++) {
                if ($page[$i]->tanggal_selesai <= $waktu && $page[$i]->tanggal_selesai != null) {
                    DB::table('productions')->where('id', $page[$i]->id_produksi)
                    ->where('status', '=', 'Diproses')
                    ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                    ->update([
                        'status' => 'Selesai',
                    ]);
                }
            }
        }

        $pageactive = "adminproduksi";
        $title = "Halaman Data Produksi";
        return view('admin.pages.produksi.data_produksi', [
            'page' => $page,
            'waktusekarang' => $waktu,
            'pageactive' => $pageactive,
            'title' => $title,
        ]);
    }

    public function mulaiproduksi($id_order)
    {
        $pageactive = "adminproduksi";
        $title = "Halaman Data Produksi";
        $update = Carbon::now()->toDateTimeString();

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $waktu = Carbon::now();

        // Query Function
        $est = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->count();

        // Estimasi dulu
        $estimasi = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $tambah = 0;

        $mulai = Productions::select(
            'orders.first_name as nama_depan',
            'orders.last_name as nama_belakang',
            'detail_orders.id as id_detail_orders',
            'productions.*',
        )
        ->join('detail_orders', 'detail_orders.id', '=', 'productions.detail_orders_id')
        ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->where('productions.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('productions.detail_orders_id', '=', $id_order)
        ->where('productions.status', '=', 'Menunggu')
        ->get();

        // dd(
        //     $mulai,
        // );

        if (empty($mulai[0])) {
            return view('admin.pages.error.page_404');
        } else {
            for ($x=0; $x < sizeof($estimasi); $x++) {
                $waktu = Carbon::now();

                $tambah += $estimasi[$x]->durasi;

                $hasil = $waktu->addHours($tambah)->toDateTimeString();

                $isi[] = $hasil;
                $arr_waktu = $isi;
            }

            $awal[] = Carbon::now()->toDateTimeString();
            $tgl_awal = array_merge($awal, $arr_waktu);

            for ($i=0; $i < sizeof($arr_waktu); $i++) {
                DB::table('productions')
                ->where('id', $mulai[$i]->id)
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => "Diproses",
                    'tanggal_mulai' => $tgl_awal[$i],
                    'tanggal_selesai' => $arr_waktu[$i],
                    'updated_at' => $update,
                ]);
            }

            $id_ordernew = Detail_orders::where('id', '=', $id_order)
            ->get();

            // Update data
            DB::table('orders')
            ->where('id', $id_ordernew[0]->orders_id)
            ->update([
                'status' => "Proses Produksi",
                'updated_at' => $update,
            ]);

            Alert::success('Update berhasil', 'Status produksi berhasil diupdate');
            return redirect('/produksi');
        }
        // dd(
            //     $mulai,
            //     $est,
            //     $i,
            //     $arr_waktu,
            //     $tgl_awal,
            //     $tgl_awal[1],
        // );
    }

    public function selesaiproduksi($id_order)
    {
        $pageactive = "adminproduksicustom";
        $title = "Halaman Data Produksi Custom";
        $update = Carbon::now()->toDateTimeString();

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        // dd(
        //     $id_order,
        // );

        $waktu = Carbon::now();

        if ($id_order == null) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            $selesai = Productions::where('detail_orders_id', '=', $id_order)
            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            if (empty($selesai[0])) {
                Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
                return view('admin.pages.error.page_404');
            } else {
                DB::table('productions')->where('detail_orders_id', $id_order)
                ->where('status', '=', 'Diproses')
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => "Diproses",
                    'tanggal_mulai' => $waktu,
                    'tanggal_selesai' => $waktu->addSeconds(10),
                    'updated_at' => $waktu,
                ]);
                Alert::success('Update berhasil', 'Status produksi berhasil diupdate');
                return redirect('/produksi');
            }
        }
    }

    public function ulangproduksi($id_order)
    {
        $pageactive = "adminproduksi";
        $title = "Halaman Data Produksi";
        $update = Carbon::now()->toDateTimeString();

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $waktu = Carbon::now();

        // Query Function
        $est = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->count();

        // Estimasi dulu
        $estimasi = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $tambah = 0;

        $mulai = Productions::select(
            'orders.first_name as nama_depan',
            'orders.last_name as nama_belakang',
            'detail_orders.id as id_detail_orders',
            'productions.*',
            'productions.id as id_produksi',
        )
        ->join('detail_orders', 'detail_orders.id', '=', 'productions.detail_orders_id')
        ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->where('productions.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('productions.detail_orders_id', '=', $id_order)
        // ->Where('productions.status', '=', 'Selesai')
        ->get();

        // dd(
        //     $mulai,
        // );

        if (empty($mulai[0])) {
            return view('admin.pages.error.page_404');
        } else {
            for ($x=0; $x < sizeof($estimasi); $x++) {
                $waktu = Carbon::now();

                $tambah += $estimasi[$x]->durasi;

                $hasil = $waktu->addHours($tambah)->toDateTimeString();

                $isi[] = $hasil;
                $arr_waktu = $isi;
            }

            $awal[] = Carbon::now()->toDateTimeString();
            $tgl_awal = array_merge($awal, $arr_waktu);

            for ($i=0; $i < sizeof($arr_waktu); $i++) {
                DB::table('productions')
                ->where('id', $mulai[$i]->id_produksi)
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => "Diproses",
                    'tanggal_mulai' => $tgl_awal[$i],
                    'tanggal_selesai' => $arr_waktu[$i],
                    'updated_at' => $update,
                ]);
            }

            $id_ordernew = Detail_orders::where('id', '=', $id_order)
            ->get();

            // Update data
            DB::table('orders')
            ->where('id', $id_ordernew[0]->orders_id)
            ->update([
                'status' => "Proses Produksi",
                'updated_at' => $update,
            ]);

            Alert::success('Update berhasil', 'Status produksi berhasil diupdate');
            return redirect('/produksi');
        }
        // dd(
            //     $mulai,
            //     $est,
            //     $i,
            //     $arr_waktu,
            //     $tgl_awal,
            //     $tgl_awal[1],
        // );
    }

    public function selesaiproses($id_produksi)
    {
        // dd(
        //     $id_produksi,
        // );

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $waktu = Carbon::now();

        if ($id_produksi != null) {
            $selesai = Productions::select(
                'productions.*',
            )
            ->where('productions.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('productions.id', '=', $id_produksi)
            ->where('productions.status', '=', 'Diproses')
            ->get();

            // dd(
            //     $id_produksi,
            //     $selesai,
            // );

            if (empty($selesai[0])) {
                Alert::info('Data tidak ditemukan', 'Gagal melakukan aksi');
                return view('admin.pages.error.page_404');
            } else {
                DB::table('productions')
                ->where('id', $id_produksi)
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => "Diproses",
                    'tanggal_mulai' => $waktu,
                    'tanggal_selesai' => $waktu->addSeconds(10),
                    'updated_at' => $waktu,
                ]);

                sleep(7);

                Alert::success('Update berhasil', 'Status produksi berhasil diupdate');
                return redirect('/produksi');
            }
        } else {
            Alert::info('Data tidak ditemukan', 'Id produksi kosong');
            return view('admin.pages.error.page_404');
        }
    }

    public function mulaiproses($id_produksi)
    {
        // dd(
        //     $id_produksi,
        // );

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $waktu = Carbon::now();

        if ($id_produksi != null) {
            $proses = Productions::select(
                'productions.*',
            )
            ->where('productions.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('productions.id', '=', $id_produksi)
            ->where('productions.status', '=', 'Diproses')
            ->get();

            // dd(
            //     $id_produksi,
            //     $proses,
            //     $waktu,
            // );

            if (empty($proses[0])) {
                Alert::info('Data tidak ditemukan', 'Gagal melakukan aksi');
                return view('admin.pages.error.page_404');
            } else {
                DB::table('productions')
                ->where('id', $id_produksi)
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => "Diproses",
                    'tanggal_mulai' => Carbon::now(),
                    'tanggal_selesai' => $waktu->addHours($proses[0]->estimasi),
                    'updated_at' => Carbon::now(),
                ]);

                Alert::success('Update berhasil', 'Status produksi berhasil diupdate');
                return redirect('/produksi');
            }
        } else {
            Alert::info('Data tidak ditemukan', 'Id produksi kosong');
            return view('admin.pages.error.page_404');
        }
    }

    public function berhentiproduksi($id_order)
    {
        // dd(
        //     $id_order,
        // );

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $waktu = Carbon::now();

        if ($id_order != null) {
            $berhenti = Productions::where('detail_orders_id', '=', $id_order)
            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            // dd(
            //     $id_order,
            //     $berhenti,
            // );

            if (empty($berhenti[0])) {
                Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
                return view('admin.pages.error.page_404');
            } else {
                DB::table('productions')->where('detail_orders_id', $id_order)
                ->where('status', '=', 'Diproses')
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => "Menunggu",
                    'tanggal_mulai' => null,
                    'tanggal_selesai' => null,
                    'updated_at' => $waktu,
                ]);

                Alert::success('Update berhasil', 'Status produksi berhasil diupdate');
                return redirect('/produksi');
            }
        } else {
            Alert::info('Proses Gagal', 'id order kosong');
            return view('admin.pages.error.page_404');
        }
    }

    public function berhentiproses($id_produksi)
    {
        // dd(
        //     $id_produksi,
        // );

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $waktu = Carbon::now();

        if ($id_produksi != null) {
            $berhenti = Productions::where('id', '=', $id_produksi)
            ->where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('productions.status', '=', 'Diproses')
            ->get();

            // dd(
            //     $id_produksi,
            //     $berhenti,
            // );

            if (empty($berhenti[0])) {
                Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
                return view('admin.pages.error.page_404');
            } else {
                DB::table('productions')->where('id', $id_produksi)
                ->where('status', '=', 'Diproses')
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => "Diproses",
                    'tanggal_mulai' => null,
                    'tanggal_selesai' => null,
                    'updated_at' => $waktu,
                ]);

                Alert::success('Update berhasil', 'Status produksi berhasil diupdate');
                return redirect('/produksi');
            }
        } else {
            Alert::info('Proses Gagal', 'id produksi kosong');
            return view('admin.pages.error.page_404');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
        // return view('admin.pages.error.page_404');
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
        // return view('admin.pages.error.page_404');
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

        $update = Carbon::now();

        $page = Orders::select(
            'orders.*',
            'detail_orders.*',
            'feedback_orders.desc as feedback_orders',
        )
        ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
        ->leftjoin('feedback_orders', 'feedback_orders.orders_id', '=', 'orders.id')
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('orders.id', '=', $id)
        ->get();

        $cart = Detail_orders::select(
            'detail_orders.*',
            'orders.*',
            'products.name as products_name',
            'products.pict_1 as pict_1',
            'detail_orders.size as products_size',
            'detail_orders.qty as products_qty',
            'detail_orders.price as products_price',
            'detail_orders.subtotal as products_subtotal',
            'detail_products.qty as stok_sekarang',
        )
        ->join('products', 'products.id', '=', 'detail_orders.products_id')
        ->join('detail_products', 'detail_products.id', '=', 'detail_orders.detail_products_id')
        ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->where('detail_orders.orders_id', '=', $id)
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->distinct()
        ->get();

        // Query Update Produksi
        $prod = Productions::select(
            'orders.first_name as nama_depan',
            'orders.last_name as nama_belakang',
            'detail_orders.id as id_detail_orders',
            'productions.*',
            'productions.id as id_produksi',
        )
        ->join('detail_orders', 'detail_orders.id', '=', 'productions.detail_orders_id')
        ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->where('productions.umkms_id', '=', $idumkm[0]->umkms_id)
        ->distinct()
        ->get();

        $waktu = Carbon::now();

        // dd(
        //     $prod,
        //     $prod[0]->id,
        //     $prod[0]->tanggal_selesai,
        //     sizeof($prod),
        //     $waktu,
        // );

        for ($i=0; $i < sizeof($prod); $i++) {
            if ($prod[$i]->tanggal_selesai <= $waktu) {
                DB::table('productions')->where('id', $prod[$i]->id)
                ->where('status', '=', 'Diproses')
                ->where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->update([
                    'status' => 'Selesai',
                ]);
            }
        }

        // Query Update Pesanan

        $produksi = Productions::select(
            'productions.*',
        )
        ->join('detail_orders', 'detail_orders.id', '=', 'productions.detail_orders_id')
        ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->where('detail_orders.orders_id', '=', $id)
        ->where('productions.status', '=', "Diproses")
        ->orWhere('productions.status', '=', "Menunggu")
        ->get();

        // $produksi = Productions::select(
        //     'productions.*',
        // )
        // ->join('detail_orders', 'detail_orders.id', '=', 'productions.detail_orders_id')
        // ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        // ->where('detail_orders.orders_id', '=', $id)
        // ->where('productions.umkms_id', '=', $idumkm[0]->umkms_id)
        // ->orderBy('productions.id', 'desc')
        // ->first();

        // if ($produksi != null) {
        //     if ($produksi->status == 'Selesai') {
        //         DB::table('orders')->where('id', $id)
        //         ->where('status', '=', 'Proses Produksi')
        //         ->update([
        //             'status' => 'Pesanan Siap Dikirim',
        //             'updated_at' => $update,
        //         ]);
        //     }
        // }

        if (empty($produksi[0])) {
            DB::table('orders')->where('id', $id)
            ->where('status', '=', 'Proses Produksi')
            ->update([
                'status' => 'Pesanan Siap Dikirim',
                'updated_at' => $waktu,
            ]);
        }

        // dd(
        //     $id,
        //     $idumkm,
        //     $idumkm[0]->umkms_id,
        //     $page[0]->status_payment,
        //     $page,
        //     $cart,
        //     $produksi,
        //     $produksi->id,
        //     $produksi->status,
        // );

        if (empty($page[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            $tanggal = Carbon::parse($page[0]->date);
            $deadline = Deadlines::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();
            $batas = $tanggal->addHours($deadline[0]->deadline);

            $pageactive = "adminpenjualan";
            $title = "Halaman Data Transaksi Penjualan";
            return view('admin.pages.produksi.detail_produksi', [
                'tanggal' => $tanggal,
                'batas' => $batas,
                'page' => $page,
                'cart' => $cart,
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
        // return view('admin.pages.error.page_404');
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
        // return view('admin.pages.error.page_404');
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
        // return view('admin.pages.error.page_404');
    }
}
