<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\User;
use App\Models\Umkms;
use App\Models\Customs;
use App\Models\Deadlines;
use App\Models\Orders;
use App\Models\Detail_orders;
use App\Models\Estimations;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use PDF;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Info::first();
        $tambahanc = "";
        $tambahan = "";

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        // $update = Customs::all();
        $customs = Customs::select(
            'customs.id as id_custom',
            'customs.*',
            'umkms.umkm_name',
            'umkms.id as id_umkm',
            'umkms.phone as nomor_umkm',
            'feedback_customs.desc as feedback_customs',
            'deadlines.deadline as deadline',
        )
        ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
        ->leftjoin('deadlines', 'umkms.id', '=', 'deadlines.umkms_id')
        ->leftjoin('feedback_customs', 'feedback_customs.customs_id', '=', 'customs.id')
        ->where('customs.users_id', '=', auth()->user()->id);

        if (request()->has('waktuc')) {
            if (request('waktuc') == "asc") {
                $tambahanc = "(Filter by Oldest)";
            } elseif (request('waktuc') == "desc") {
                $tambahanc = "(Filter by Newest)";
            } else {
                $tambahanc = "";
            }
            $customs = $customs
            ->orderBy('created_at', request('waktuc'));
        }

        $customs = $customs
        ->paginate(3) //ini buat nampilin jumlah nya
        ->appends([
            'waktuc' => request('waktuc'),
        ]);

        // $page = Orders::join('detail_orders', 'orders.id', '=', 'detail_orders.orders_id')
        // ->join('umkms', 'umkms.id', '=', 'detail_orders.umkms_id')
        // ->join('users', 'users.id', '=', 'orders.users_id')
        // ->where('users_id', '=', auth()->user()->id)
        // ->get();

        $page = Orders::select(
            'orders.id as id_orders',
            'orders.*',
            'orders.created_at as jam_masuk',
            'feedback_orders.desc as feedback_orders',
            'promos.name as nama_promo',
            'deadlines.deadline as deadline',
            'umkms.umkm_name as nama_umkm',
            'umkms.id as id_umkm',
            'umkms.phone as nomor_umkm',
        )
        ->join('users', 'users.id', '=', 'orders.users_id')
        ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
        ->leftjoin('umkms', 'umkms.id', '=', 'detail_orders.umkms_id')
        ->leftjoin('deadlines', 'umkms.id', '=', 'deadlines.umkms_id')
        ->leftjoin('feedback_orders', 'feedback_orders.orders_id', '=', 'orders.id')
        ->leftjoin('promos', 'orders.promos_id', '=', 'promos.id')
        ->where('orders.users_id', '=', auth()->user()->id);

        // $page = Detail_orders::select(
        //     'orders.id as id_orders',
        //     'orders.*',
        //     'users.*',
        //     'orders.updated_at',
        //     'feedback_orders.desc as feedback_orders',
        //     'promos.name as nama_promo',
        // )
        // ->leftjoin('orders', 'orders.id', '=', 'detail_orders.orders_id')
        // ->join('users', 'users.id', '=', 'orders.users_id')
        // ->leftjoin('feedback_orders', 'feedback_orders.orders_id', '=', 'orders.id')
        // ->leftjoin('promos', 'orders.promos_id', '=', 'promos.id')
        // ->where('users_id', '=', auth()->user()->id);

        $umkm = Orders::select(
            'umkms.phone as nomor_umkm',
            // 'deadlines.deadline as deadline',
        )
        ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
        ->leftjoin('umkms', 'umkms.id', '=', 'detail_orders.umkms_id')
        // ->leftjoin('deadlines', 'umkms.id', '=', 'deadlines.umkms_id')
        ->where('orders.users_id', '=', auth()->user()->id)
        ->get();

        if (request()->has('waktu')) {
            if (request('waktu') == "asc") {
                $tambahan = "(Filter by Oldest)";
            } elseif (request('waktu') == "desc") {
                $tambahan = "(Filter by Newest)";
            } else {
                $tambahan = "";
            }
            $page = $page
            ->orderBy('orders.created_at', request('waktu'));
        }

        $page = $page
        // ->distinct()
        ->groupBy('orders.id')
        ->paginate(3) //ini buat nampilin jumlah nya
        ->appends([
            'waktu' => request('waktu'),
        ]);

        // dd(
        //     $page,
        //     sizeof($page),
        //     $page->links(),
        //     $page->onEachSide(1)->links(),
        // );

        // dd(
        //     $customs,
        //     $customs[0]->created_at,
        //     $customs[0]->deadline,
        //     $page,
        //     $page[0]->jam_masuk,
        //     $page[0]->created_at,
        //     $page[0]->deadline,
        //     $umkm,
        //     sizeof($page->items()),
        // );

        $title = 'History Transaksi';
        $pageactive = 'history';
        return view('customer.pages.tracking.list_pembelian', [
            'page' => $page,
            'umkm' => $umkm,
            // 'deadline' => $deadline,
            'tambahan' => $tambahan,
            'tambahanc' => $tambahanc,
            'customs' => $customs,
            'title' => $title,
            'info' => $info,
            'pageactive' => $pageactive,
        ]);
    }

    public function invoicecustom($id_custom)
    {
        try {
            $decrypted = decrypt($id_custom);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id_custom);

        $customs = Customs::select(
            'customs.id as id_custom',
            'customs.*',
            'umkms.umkm_name',
        )
        ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id');
        if (auth()->user()->role == "admin") {
            $customs = $customs;
        } else {
            $customs = $customs
            ->where('customs.users_id', '=', auth()->user()->id);
        }
        $customs = $customs
        ->where('customs.id', '=', $newid)
        ->where('customs.status_payment', '=', 'Lunas')
        ->get();

        // dd(
        //     $id_custom,
        //     $customs,
        // );

        $info = Info::first();
        $title = 'Invoice Transaksi Custom';
        $pageactive = 'invoicecustom';

        if (empty($customs[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return redirect('/error');
        } else {
            return view('customer.pages.custom.invoice_custom', [
            // 'page' => $page,
            'customs' => $customs,
            'title' => $title,
            'info' => $info,
            'pageactive' => $pageactive,
            ]);
        }
    }

    public function invoicepenjualan($id_orders)
    {
        try {
            $decrypted = decrypt($id_orders);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id_orders);

        $orders = Orders::select(
            'orders.*',
            'orders.id as id_penjualan',
            'orders.date as tanggal',
            'orders.updated_at as last_updated',
            'umkms.umkm_name as nama_umkm',
            'detail_orders.*',
            'products.*',
            'detail_products.*',
            'products.name as products_name',
            'detail_orders.qty as products_qty',
            'detail_orders.price as products_price',
            'detail_orders.subtotal as products_subtotal',
            'promos.name as nama_promo'
        )
        ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
        ->join('products', 'products.id', '=', 'detail_orders.products_id')
        ->join('detail_products', 'detail_products.id', '=', 'detail_orders.detail_products_id')
        ->leftjoin('promos', 'promos.id', '=', 'orders.promos_id')
        ->join('umkms', 'umkms.id', '=', 'detail_orders.umkms_id')
        ->where('orders.id', '=', $newid);
        if (auth()->user()->role == "admin") {
            $orders = $orders;
        } else {
            $orders = $orders
            ->where('orders.users_id', '=', auth()->user()->id);
        }
        $orders = $orders
        ->where('orders.status_payment', '=', 'Lunas')
        ->get();

        // dd(
        //     $id_orders,
        //     $orders,
        // );

        $info = Info::first();
        $title = 'Invoice Transaksi Penjualan';
        $pageactive = 'invoicepenjualan';

        if (empty($orders[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return redirect('/error');
        } else {
            return view('customer.pages.order.invoice_penjualan', [
            // 'page' => $page,
            'orders' => $orders,
            'title' => $title,
            'info' => $info,
            'pageactive' => $pageactive,
            ]);
        }
    }

    public function cetakinvoicecustom($id_custom)
    {
        $custom = Customs::select(
            'customs.id as id_custom',
            'customs.*',
            'umkms.umkm_name',
            'umkms.phone as no_umkm',
        )
        ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id');
        if (auth()->user()->role == "admin") {
            $custom = $custom;
        } else {
            $custom = $custom
            ->where('customs.users_id', '=', auth()->user()->id);
        }
        $custom = $custom
        ->where('customs.id', '=', $id_custom)
        ->where('customs.status_payment', '=', 'Lunas')
        ->get();

        // dd(
        //     $id_custom,
        //     $custom,
        // );

        if (empty($custom[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return redirect('/error');
        } else {
            $cetak = PDF::loadview('customer.pages.custom.print_invoice_custom', ['custom'=>$custom])
            ->setPaper('a4', 'landscape');
            // Tester
            // return view('customer.pages.custom.print_invoice_custom', ['custom'=>$custom]);
            return $cetak->download('Invoice Custom '.$custom[0]->id_custom.'.pdf');
        }
        // return $cetak->stream('test-invoice.pdf', array("Attachment" => false));
        // return $cetak->download('test-invoice'.$custom[0]->id_custom.'.pdf');
    }

    public function cetakinvoicepenjualan($id_orders)
    {
        $cart = Detail_orders::select(
            'detail_orders.*',
            'orders.*',
            'products.name as products_name',
            'products.pict_1 as pict_1',
            'detail_orders.size as products_size',
            'detail_orders.qty as products_qty',
            'detail_orders.price as products_price',
            'detail_orders.subtotal as products_subtotal',
            'umkms.umkm_name as umkm_name',
            'umkms.phone as no_umkm',
        )
        ->join('products', 'products.id', '=', 'detail_orders.products_id')
        ->join('detail_products', 'detail_products.products_id', '=', 'products.id')
        ->join('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->join('umkms', 'umkms.id', '=', 'detail_orders.umkms_id')
        ->where('detail_orders.orders_id', '=', $id_orders)
        ->where('orders.status_payment', '=', "Lunas")
        ->distinct()
        ->get();

        $orders = Orders::join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
        ->where('orders.id', '=', $id_orders);
        if (auth()->user()->role == "admin") {
            $orders = $orders;
        } else {
            $orders = $orders
            ->where('orders.users_id', '=', auth()->user()->id);
        }
        $orders = $orders
        ->where('orders.status_payment', '=', "Lunas")
        ->get();

        // dd(
        //     $id_orders,
        //     $orders,
        //     $cart,
        // );

        if (empty($orders[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return redirect('/error');
        } else {
            $cetak = PDF::loadview('customer.pages.order.print_invoice_penjualan', [
                'orders'=>$orders,
                'cart'=>$cart,
            ])->setPaper('a4', 'landscape');

            return $cetak->download('Invoice Produk '.$orders[0]->orders_id.'.pdf');

            // Tester
            // return view('customer.pages.order.print_invoice_penjualan', [
            //     'orders'=>$orders,
            //     'cart'=>$cart,
            // ]);
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
