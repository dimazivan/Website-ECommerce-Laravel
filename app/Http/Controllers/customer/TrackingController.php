<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\Orders;
use App\Models\Customs;
use App\Models\Productions;
use App\Models\Production_customs;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Info::first();

        $title = 'Tracking Your Order';
        $pageactive = 'tracking';
        return view('customer.pages.tracking.tracking', [
            // 'page' => $page,
            'title' => $title,
            'info' => $info,
            'pageactive' => $pageactive,
        ]);
    }

    public function indexcustom()
    {
        $info = Info::first();

        $title = 'Tracking Your Order';
        $pageactive = 'trackingcustom';
        return view('customer.pages.tracking.tracking_custom', [
            // 'page' => $page,
            'title' => $title,
            'info' => $info,
            'pageactive' => $pageactive,
        ]);
    }

    public function trackingorders(Request $request)
    {
        $info = Info::first();
        $title = 'Tracking Your Order';
        $pageactive = 'tracking';

        // Query Update Produksi
        $upd = Productions::select(
            'orders.first_name as nama_depan',
            'orders.last_name as nama_belakang',
            'productions.*',
        )
        ->join('detail_orders', 'detail_orders.id', '=', 'productions.detail_orders_id')
        ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->distinct()
        ->get();

        $waktu = Carbon::now();

        for ($i=0; $i < sizeof($upd); $i++) {
            if ($upd[$i]->tanggal_selesai <= $waktu && $upd[$i]->tanggal_selesai != null) {
                DB::table('productions')->where('id', $upd[$i]->id)
                ->where('status', '=', 'Diproses')
                ->update([
                    'status' => 'Selesai',
                ]);
            }
        }

        // Query Update Pesanan
        // $produksi = Productions::select(
        //     'productions.*',
        // )
        // ->join('detail_orders', 'detail_orders.id', '=', 'productions.detail_orders_id')
        // ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        // ->where('detail_orders.orders_id', '=', $request->id)
        // ->orderBy('productions.id', 'desc')
        // ->first();

        // if ($produksi != null) {
        //     if ($produksi->status == 'Selesai') {
        //         DB::table('orders')->where('id', $request->id)
        //         ->where('status', '=', "Proses Produksi")
        //         ->update([
        //             'status' => 'Pesanan Siap Dikirim',
        //             'updated_at' => $waktu,
        //         ]);
        //     }
        // }


        // Query Update Pesanan
        // $produksi = Productions::select(
        //     'productions.*',
        // )
        // ->join('detail_orders', 'detail_orders.id', '=', 'productions.detail_orders_id')
        // ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        // ->where('detail_orders.orders_id', '=', $id)
        // ->where('productions.umkms_id', '=', $idumkm[0]->umkms_id)
        // ->orderBy('productions.id', 'desc')
        // ->first();

        $produksi = Productions::select(
            'productions.*',
        )
        ->join('detail_orders', 'detail_orders.id', '=', 'productions.detail_orders_id')
        ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->where('detail_orders.orders_id', '=', $request->id)
        ->where('productions.status', '=', "Diproses")
        ->orWhere('productions.status', '=', "Menunggu")
        ->get();

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
            DB::table('orders')->where('id', $request->id)
            ->where('status', '=', 'Proses Produksi')
            ->update([
                'status' => 'Pesanan Siap Dikirim',
                'updated_at' => $waktu,
            ]);
        }

        if ($request->id != null) {
            $data = explode("/", $request->id);

            if (empty($data[1])) {
                return redirect()->route("tracking.index")->with("info", "Masukkan Nomor dengan Benar");
            }

            // dd(
            //     $request->all(),
            //     $request->id,
            //     explode("/", $request->id),
            //     $data,
            //     $data[0],
            // );

            $orders = Orders::select(
                'orders.id as id_orders',
                'orders.*',
                'users.*',
                'orders.updated_at',
                'detail_orders.umkms_id as id_umkm',
            )
            ->join('users', 'users.id', '=', 'orders.users_id')
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('orders.id', '=', $data[1])
            ->where('orders.date', '=', $data[0])
            ->get();

            if (empty($orders[0])) {
                // Alert::info('Proses Gagal', 'Data transaksi tidak ditemukan');
                // return redirect('/tracking');
                return redirect()->route("tracking.index")->with("info", "Data transaksi tidak ditemukan");
            } else {
                $jumlah = Productions::select(
                    'productions.*',
                    // DB::raw('sum(productions.estimasi) as total_estimasi'),
                )
                ->join('detail_orders', 'detail_orders.id', '=', 'productions.detail_orders_id')
                ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
                ->where('productions.umkms_id', '=', $orders[0]->id_umkm)
                ->where('orders.id', '=', $request->id)
                ->where('productions.status', '=', 'Diproses')
                ->orWhere('productions.status', '=', 'Selesai')
                ->count();


                $produksi = Productions::select(
                    'productions.*',
                    // DB::raw('sum(productions.estimasi) as total_estimasi'),
                )
                ->join('detail_orders', 'detail_orders.id', '=', 'productions.detail_orders_id')
                ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
                ->where('productions.umkms_id', '=', $orders[0]->id_umkm)
                ->where('orders.id', '=', $request->id)
                ->where('productions.status', '=', 'Diproses')
                ->orWhere('productions.status', '=', 'Selesai')
                ->get();

                $datatotal_estimasi = Productions::join('detail_orders', 'detail_orders.id', '=', 'productions.detail_orders_id')
                ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
                ->where('productions.umkms_id', '=', $orders[0]->id_umkm)
                ->where('orders.id', '=', $request->id)
                ->where('productions.status', '=', 'Diproses')
                ->orWhere('productions.status', '=', 'Selesai')
                ->sum('productions.estimasi');

                // $arr_produksi = [];
                $total_progress = 0;
                $total_estimasi = 0;
                $est_data = 0;
                $est_tanggal_selesai = 0;
                $tambah = 0;
                // $i = 0;
                $time_now = Carbon::now()->parse();
                foreach ($produksi as $items) {
                    $arr_item_tgl_mulai[] = $items->tanggal_mulai;
                    $arr_item_tgl_selesai[] = $items->tanggal_selesai;
                    $arr_estimasi[] = Carbon::now()->addHours($items->estimasi)->diffInMinutes();
                    $est_data = Carbon::now()->addHours($items->estimasi)->diffInMinutes();
                    $est_tanggal_selesai = Carbon::parse($items->tanggal_selesai)->diffInMinutes();
                    $arr_produksi[] = Carbon::parse($items->tanggal_selesai)->diffInMinutes();
                    if ($items->tanggal_selesai != null) {
                        if ($time_now->gt($items->tanggal_selesai)) {
                            // eksekusi
                            // $i++;
                            $tambah = $est_data;
                        } elseif ($est_tanggal_selesai <= $est_data) {
                            $tambah = $est_data-$est_tanggal_selesai;
                        } else {
                            $tambah = 0;
                        }
                    }
                    $total_progress += $tambah;
                    $total_estimasi += $est_data;
                    // Tanggal Bawah
                    $tanggal_bawah = Carbon::parse($items->tanggal_selesai)->diffInMinutes();
                    $total_estimasi_menit = Carbon::now()->addHours($datatotal_estimasi)->diffInMinutes();
                    $est_tanggal_data = 0;
                    $est_tanggal_selesai = 0;
                    $tambah = 0;
                }

                if ($total_estimasi != null ||
                                $total_estimasi != 0 ||
                                $total_progress != null ||
                                $total_progress != 0) {
                    $total_persen = ($total_progress/$total_estimasi)*100;
                } else {
                    $total_persen = 0;
                }

                // dd(
                //     $produksi,
                //     $total_estimasi,
                //     $jumlah,
                //     $arr_estimasi,
                //     $arr_produksi,
                //     $total_progress,
                //     $total_estimasi,
                //     $total_persen,
                // );

                // dd(
                //     $arr_item_tgl_mulai,
                //     $arr_item_tgl_selesai,
                //     $tanggal_bawah,
                //     $total_estimasi_menit,
                //     (($total_estimasi_menit-$tanggal_bawah)/$total_estimasi_menit)*100,
                // );

                // $produksi = $produksi->unique();

                return view('customer.pages.tracking.tracking_produksi', [
                    'orders' => $orders,
                    'datatotal_estimasi'=> $datatotal_estimasi,
                    'total_persen' => $total_persen,
                    'jumlah' => $jumlah,
                    'produksi' => $produksi,
                    'title' => $title,
                    'info' => $info,
                    'pageactive' => $pageactive,
                ]);
            }
        } else {
            // Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            // return redirect('/tracking');
            return redirect()->route("tracking.index")->with("info", "Masukkan Nomor dengan Benar");
        }

        // dd(
        //     $request->all(),
        //     $orders,
        //     $orders[0]->id_umkm,
        //     $orders[0]->updated_at,
        //     $produksi,
        // );
    }

    public function trackingcustoms(Request $request)
    {
        $info = Info::first();
        $title = 'Tracking Your Order';
        $pageactive = 'tracking';

        // Query Update Produksi
        $upd = Production_customs::select(
            'customs.first_name as nama_depan',
            'customs.last_name as nama_belakang',
            'production_customs.*',
            'production_customs.id as id_produksi',
        )
        ->join('customs', 'customs.id', '=', 'production_customs.customs_id')
        ->distinct()
        ->get();

        $waktu = Carbon::now();

        for ($i=0; $i < sizeof($upd); $i++) {
            if ($upd[$i]->tanggal_selesai <= $waktu && $upd[$i]->tanggal_selesai != null) {
                DB::table('production_customs')->where('id', $upd[$i]->id_produksi)
                ->where('status', '=', 'Diproses')
                ->update([
                    'status' => 'Selesai',
                ]);
            }
        }

        // Query Update Pesanan
        // $produksi = Production_customs::select(
        //     'customs.first_name as nama_depan',
        //     'customs.last_name as nama_belakang',
        //     'production_customs.*',
        //     'production_customs.id as id_produksi',
        // )
        // ->join('customs', 'customs.id', '=', 'production_customs.customs_id')
        // ->where('customs.id', '=', $id)
        // ->orderBy('production_customs.id', 'desc')
        // ->first();

        $produksi = Production_customs::select(
            'customs.first_name as nama_depan',
            'customs.last_name as nama_belakang',
            'production_customs.*',
            'production_customs.id as id_produksi',
        )
        ->join('customs', 'customs.id', '=', 'production_customs.customs_id')
        ->where('customs.id', '=', $request->id)
        ->where('production_customs.status', '=', "Diproses")
        ->orWhere('production_customs.status', '=', "Menunggu")
        ->get();

        if ($request->id != null) {
            // if ($produksi != null) {
            //     if ($produksi->status == 'Selesai') {
            //         DB::table('customs')->where('id', $id)
            //         ->where('status', '=', "Proses Produksi")
            //         ->update([
            //             'status' => 'Pesanan Siap Dikirim',
            //             'updated_at' => $waktu,
            //         ]);
            //     }
            // }

            if (empty($produksi[0])) {
                DB::table('customs')->where('id', $request->id)
                ->where('status', '=', "Proses Produksi")
                ->update([
                    'status' => 'Pesanan Siap Dikirim',
                    'updated_at' => $waktu,
                ]);
            }
        }

        // $produksi = Production_customs::select(
        //     'customs.first_name as nama_depan',
        //     'customs.last_name as nama_belakang',
        //     'production_customs.*',
        //     'production_customs.id as id_produksi',
        // )
        // ->join('customs', 'customs.id', '=', 'production_customs.customs_id')
        // ->where('customs.id', '=', $request->id)
        // ->orderBy('production_customs.id', 'desc')
        // ->first();

        // if ($request->id != null) {
        //     if ($produksi != null) {
        //         if ($produksi->status == 'Selesai') {
        //             DB::table('customs')->where('id', $request->id)
        //             ->where('status', '=', "Proses Produksi")
        //             ->update([
        //                 'status' => 'Pesanan Siap Dikirim',
        //                 'updated_at' => $waktu,
        //             ]);
        //         }
        //     }
        // }
        // Dari sini


        if ($request->id != null) {
            $data = explode("/", $request->id);

            if (empty($data[1])) {
                return redirect()->route("customs.tracking")->with("info", "Masukkan Nomor dengan Benar");
            }

            // dd(
            //     $request->all(),
            //     $request->id,
            //     explode("/", $request->id),
            //     $data,
            //     $data[0],
            // );

            $customs = Customs::select(
                'customs.id as id_customs',
                'customs.*',
                'users.*',
                'customs.updated_at',
                'customs.umkms_id as id_umkm',
            )
            ->join('users', 'users.id', '=', 'customs.users_id')
            ->where('customs.id', '=', $data[1])
            ->where('customs.date', '=', $data[0])
            ->get();

            if (empty($customs[0])) {
                // Alert::info('Proses Gagal', 'Data transaksi tidak ditemukan');
                // return redirect('/trackingcustom');
                return redirect()->route("customs.tracking")->with("info", "Data transaksi tidak ditemukan");
            } else {
                $jumlah = Production_customs::join('customs', 'customs.id', '=', 'production_customs.customs_id')
                ->where('production_customs.umkms_id', '=', $customs[0]->id_umkm)
                ->where('customs.id', '=', $request->id)
                ->where('production_customs.status', '=', 'Diproses')
                ->orWhere('production_customs.status', '=', 'Selesai')
                ->count();

                $produksi = Production_customs::select(
                    'production_customs.*',
                )
                ->join('customs', 'customs.id', '=', 'production_customs.customs_id')
                ->where('production_customs.umkms_id', '=', $customs[0]->id_umkm)
                ->where('customs.id', '=', $request->id)
                ->where('production_customs.status', '=', 'Diproses')
                ->orWhere('production_customs.status', '=', 'Selesai')
                ->get();

                $datatotal_estimasi = Production_customs::join('customs', 'customs.id', '=', 'production_customs.customs_id')
                ->where('production_customs.umkms_id', '=', $customs[0]->id_umkm)
                ->where('customs.id', '=', $request->id)
                ->where('production_customs.status', '=', 'Diproses')
                ->orWhere('production_customs.status', '=', 'Selesai')
                ->sum('production_customs.estimasi');

                // $arr_produksi = [];
                $total_progress = 0;
                $total_estimasi = 0;
                $est_data = 0;
                $est_tanggal_selesai = 0;
                $tambah = 0;
                // $i = 0;
                $time_now = Carbon::now()->parse();
                foreach ($produksi as $items) {
                    $arr_item_tgl_mulai[] = $items->tanggal_mulai;
                    $arr_item_tgl_selesai[] = $items->tanggal_selesai;
                    $arr_estimasi[] = Carbon::now()->addHours($items->estimasi)->diffInMinutes();
                    $est_data = Carbon::now()->addHours($items->estimasi)->diffInMinutes();
                    $est_tanggal_selesai = Carbon::parse($items->tanggal_selesai)->diffInMinutes();
                    $arr_produksi[] = Carbon::parse($items->tanggal_selesai)->diffInMinutes();

                    if ($items->tanggal_mulai != null) {
                        if ($time_now->gt($items->tanggal_selesai)) {
                            // eksekusi
                            // $i++;
                            $tambah = $est_data;
                        } elseif ($est_tanggal_selesai <= $est_data) {
                            $tambah = $est_data-$est_tanggal_selesai;
                        } else {
                            $tambah = 0;
                        }
                    }
                    $total_progress += $tambah;
                    $total_estimasi += $est_data;
                    // Tanggal Bawah
                    $tanggal_bawah = Carbon::parse($items->tanggal_selesai)->diffInMinutes();
                    $total_estimasi_menit = Carbon::now()->addHours($datatotal_estimasi)->diffInMinutes();
                    $est_tanggal_data = 0;
                    $est_tanggal_selesai = 0;
                    $tambah = 0;
                }
                if ($total_estimasi != null ||
                $total_estimasi != 0 ||
                $total_progress != null ||
                $total_progress != 0) {
                    $total_persen = ($total_progress/$total_estimasi)*100;
                } else {
                    $total_persen = 0;
                }

                // dd(
                //     $produksi,
                //     $total_estimasi,
                //     $jumlah,
                //     $arr_estimasi,
                //     $arr_produksi,
                //     $total_progress,
                //     $total_estimasi,
                //     $total_persen,
                // );

                // $produksi = $produksi->unique();

                return view('customer.pages.tracking.tracking_produksi', [
                'orders' => $customs,
                'datatotal_estimasi'=> $datatotal_estimasi,
                'total_persen' => $total_persen,
                'jumlah' => $jumlah,
                'produksi' => $produksi,
                'title' => $title,
                'info' => $info,
                'pageactive' => $pageactive,
                ]);
            }
        } else {
            // Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            // return redirect('/trackingcustom');
            return redirect()->route("customs.tracking")->with("info", "Masukkan Nomor dengan Benar");
        }

        // dd(
        //     $request->all(),
        //     $orders,
        //     $orders[0]->id_umkm,
        //     $orders[0]->updated_at,
        //     $produksi,
        // );
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
