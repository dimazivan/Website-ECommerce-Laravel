<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Umkms;
use App\Models\Deadlines;
use App\Models\Estimations;
use App\Models\Payments;
use App\Models\Colors;
use App\Models\Categorys;
use App\Models\Expeditions;
use App\Models\Products;
use App\Models\Customers;
use App\Models\Materials;
use App\Models\Suppliers;
use App\Models\Orders;
use App\Models\Customs;
use App\Models\Detail_orders;
use App\Models\Pembelian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Redirect;
use PDF;

class DashboardController extends Controller
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

        $waktu = Carbon::now();

        if (auth()->user()->role != "super") {
            // Data UMKM
            $data_umkm = Umkms::where('id', '=', $idumkm[0]->umkms_id)
            ->get();

            if ($data_umkm[0]->districts == null ||
            $data_umkm[0]->ward == null ||
            $data_umkm[0]->city == null ||
            $data_umkm[0]->province == null ||
            $data_umkm[0]->postal_code == null) {
                Alert::info('Proses Gagal', 'Data UMKM ada yang Kosong');
                return redirect('/info/create');
            }

            // Estimation
            $data_estimasi = Estimations::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            if (empty($data_estimasi[0])) {
                // if (!isset($data_estimasi)) {
                Alert::info('Proses Gagal', 'Data Estimasi Produksi Kosong');
                return redirect('/estimasi/create');
            }

            // Pembayaran
            $data_pembayaran = Payments::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            if (empty($data_pembayaran[0])) {
                Alert::info('Proses Gagal', 'Data Portal Pembayaran Kosong');
                return redirect('/pembayaran/create');
            }

            // Color
            $data_color = Colors::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            if (empty($data_color[0])) {
                Alert::info('Proses Gagal', 'Data Warna Produk Kosong');
                return redirect('/warna/create');
            }

            // Category
            $data_kategori = Categorys::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            if (empty($data_kategori[0])) {
                Alert::info('Proses Gagal', 'Data Kategori Produk Kosong');
                return redirect('/kategori/create');
            }

            // Ekpedisi
            $data_ekspedisi = Expeditions::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            if (empty($data_ekspedisi[0])) {
                Alert::info('Proses Gagal', 'Data Jasa Ekspedisi Kosong');
                return redirect('/jasa_ekspedisi/create');
            }

            // Deadline
            $data_deadline = Deadlines::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            if (empty($data_deadline[0])) {
                Alert::info('Proses Gagal', 'Data Deadline Kosong');
                return redirect('/deadline/create');
            }
        }

        // Data Dashboard
        $jml_user = User::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->count();

        $jml_kategori = Categorys::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->count();

        $jml_product = Products::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->count();

        $jml_detproduct = Products::join('detail_products', 'detail_products.products_id', '=', 'products.id')
        ->where('products.umkms_id', '=', $idumkm[0]->umkms_id)
        ->count();

        $jml_material = Materials::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->count();

        $jml_supplier = Suppliers::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->count();

        // Dashboard Bawah
        $jml_trxorder = Detail_orders::select(
            'orders_id'
        )
        ->leftjoin('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->where('orders.status', '=', 'Selesai')
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->distinct()
        ->count('detail_orders.orders_id');

        $jml_trxcustom = Customs::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('status', '=', 'Selesai')
        ->count();

        $jml_trxpembelian = Pembelian::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->count();

        $jml_trxorderper = Detail_orders::select(
            'orders_id'
        )
        ->leftjoin('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->where('orders.status', '=', 'Selesai')
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->whereMonth('detail_orders.created_at', '=', $waktu->month)
        ->whereYear('detail_orders.created_at', '=', $waktu->year)
        ->distinct()
        ->count('detail_orders.orders_id');

        $jml_trxcustomper = Customs::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('status', '=', 'Selesai')
        ->whereMonth('created_at', '=', $waktu->month)
        ->whereYear('created_at', '=', $waktu->year)
        ->count();

        $jml_trxpembelianper = Pembelian::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->whereMonth('created_at', '=', $waktu->month)
        ->whereYear('created_at', '=', $waktu->year)
        ->count();

        // Omset
        $jml_pemasukkanper = Detail_orders::leftjoin('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->where('orders.status', '=', 'Selesai')
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->whereMonth('detail_orders.created_at', '=', $waktu->month)
        ->whereYear('detail_orders.created_at', '=', $waktu->year)
        ->sum('detail_orders.subtotal');

        $jml_totalcusper = Customs::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('status', '=', 'Selesai')
        ->whereMonth('created_at', '=', $waktu->month)
        ->whereYear('created_at', '=', $waktu->year)
        ->sum('total');

        $jml_ongkircusper = Customs::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('status', '=', 'Selesai')
        ->whereMonth('created_at', '=', $waktu->month)
        ->whereYear('created_at', '=', $waktu->year)
        ->sum('ongkir');

        $jml_pemasukkancusper = $jml_totalcusper - $jml_ongkircusper;

        $jml_pengeluaranper = Pembelian::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->whereMonth('created_at', '=', $waktu->month)
        ->whereYear('created_at', '=', $waktu->year)
        ->sum('total');

        $jml_pemasukkan = Detail_orders::leftjoin('orders', 'orders.id', '=', 'detail_orders.orders_id')
        ->where('orders.status', '=', 'Selesai')
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->sum('detail_orders.subtotal');

        $jml_totalcus = Customs::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('status', '=', 'Selesai')
        ->sum('total');

        $jml_ongkircus = Customs::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('status', '=', 'Selesai')
        ->sum('ongkir');

        $jml_pemasukkancus = $jml_totalcus - $jml_ongkircus;

        $jml_pengeluaran = Pembelian::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->sum('total');

        // dd(
        //     $jml_trxorder,
        // );

        $pageorders = Orders::select(
            'orders.*',
            'orders.id as id_orders'
        )
        ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
        ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('orders.status', '=', 'Menunggu Konfirmasi')
        ->orWhere('orders.status', '=', 'Menunggu Konfirmasi Pembayaran')
        ->orderBy('created_at', 'asc')
        ->distinct()
        ->get();

        $pagecustom = Customs::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('customs.status', '=', 'Menunggu Konfirmasi')
        ->orWhere('customs.status', '=', 'Menunggu Konfirmasi Pembayaran')
        ->orderBy('created_at', 'asc')
        ->get();

        $deadline = Deadlines::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $pageactive = "dashboard";
        $title = "Dashboard UMKM ".$data_umkm[0]->umkm_name;
        return view('admin.dashboard', [
            'pageorders' => $pageorders,
            'pagecustom' => $pagecustom,
            'deadline' => $deadline,
            'jml_user' => $jml_user,
            'jml_ongkircus' => $jml_ongkircus,
            'jml_kategori' => $jml_kategori,
            'jml_product' => $jml_product,
            'jml_detproduct' => $jml_detproduct,
            'jml_material' => $jml_material,
            'jml_supplier' => $jml_supplier,
            'jml_trxorder' => $jml_trxorder,
            'jml_trxcustom' => $jml_trxcustom,
            'jml_trxpembelian' => $jml_trxpembelian,
            'jml_trxorderper' => $jml_trxorderper,
            'jml_trxcustomper' => $jml_trxcustomper,
            'jml_trxpembelianper' => $jml_trxpembelianper,
            'jml_pengeluaran' => $jml_pengeluaran,
            'jml_pengeluaranper' => $jml_pengeluaranper,
            'jml_pemasukkan' => $jml_pemasukkan,
            'jml_pemasukkanper' => $jml_pemasukkanper,
            'jml_pemasukkancus' => $jml_pemasukkancus,
            'jml_pemasukkancusper' => $jml_pemasukkancusper,
            'pageactive' => $pageactive,
            'title' => $title,
        ]);
    }

    public function pdflaporan(Request $request)
    {
        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $nama_umkm = Umkms::where('id', '=', $idumkm[0]->umkms_id)
        ->get();

        $awal = "";
        $akhir = "";

        if ($request->dtawal > $request->dtakhir && $request->dtakhir != null) {
            Alert::info('Proses Gagal', 'Perhatikan kembali nilai tanggal');
            return Redirect::back();
        }

        if ($request->dtakhir == null && $request->dtawal != null) {
            $custom = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '>=', $request->dtawal)
            ->where('customs.status_payment', '=', 'Lunas')
            ->get();

            $totalcus = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '>=', $request->dtawal)
            ->where('customs.status_payment', '=', 'Lunas')
            ->sum('customs.subtotal');
            // ->sum('customs.total');

            $jumlahcus = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '>=', $request->dtawal)
            ->where('customs.status_payment', '=', 'Lunas')
            ->count();

            $page = Orders::select(
                'orders.*',
            )
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.date', '>=', $request->dtawal)
            ->where('orders.status', '=', "Selesai")
            ->distinct()
            ->get();

            // $totalder = Orders::select(
            //     'orders.*',
            // )
            // ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            // ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            // ->where('orders.date', '>=', $request->dtawal)
            // ->where('orders.status', '=', "Selesai")
            // ->distinct()
            // ->sum('orders.total');

            $totalder = Detail_orders::leftjoin('orders', 'orders.id', '=', 'detail_orders.orders_id')
            ->where('orders.status', '=', 'Selesai')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.date', '>=', $request->dtawal)
            ->sum('detail_orders.subtotal');

            $ongkirder = Orders::select(
                'orders.*',
            )
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.date', '>=', $request->dtawal)
            ->where('orders.status', '=', "Selesai")
            ->distinct()
            ->sum('orders.ongkir');

            $totalnewder = $totalder -$ongkirder;

            $jumlahder = sizeof($page);

            $pembelian = Pembelian::select(
                'pembelians.*',
                'pembelians.id as id_pembelian',
                'customers.first_name as nama_depan',
                'customers.last_name as nama_belakang',
            )
            ->join('users', 'users.id', '=', 'pembelians.users_id')
            ->join('customers', 'customers.users_id', '=', 'users.id')
            ->where('pembelians.date', '>=', $request->dtawal)
            ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            $totalpem = Pembelian::select(
                'pembelians.*',
                'pembelians.id as id_pembelian',
                'customers.first_name as nama_depan',
                'customers.last_name as nama_belakang',
            )
            ->join('users', 'users.id', '=', 'pembelians.users_id')
            ->join('customers', 'customers.users_id', '=', 'users.id')
            ->where('pembelians.date', '>=', $request->dtawal)
            ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
            ->sum('pembelians.total');

            $jumlahpem = Pembelian::select(
                'pembelians.*',
                'pembelians.id as id_pembelian',
                'customers.first_name as nama_depan',
                'customers.last_name as nama_belakang',
            )
            ->join('users', 'users.id', '=', 'pembelians.users_id')
            ->join('customers', 'customers.users_id', '=', 'users.id')
            ->where('pembelians.date', '>=', $request->dtawal)
            ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
            ->count();

            $awal = $request->dtawal;
            $akhir = "";
        } elseif ($request->dtawal == null && $request->dtakhir != null) {
            $custom = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '<=', $request->dtakhir)
            ->where('customs.status_payment', '=', 'Lunas')
            ->get();

            $totalcus = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '<=', $request->dtakhir)
            ->where('customs.status_payment', '=', 'Lunas')
            ->sum('customs.subtotal');
            // ->sum('customs.total');

            $jumlahcus = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '<=', $request->dtakhir)
            ->where('customs.status_payment', '=', 'Lunas')
            ->count();

            $page = Orders::select(
                'orders.*',
            )
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.date', '<=', $request->dtakhir)
            ->where('orders.status', '=', "Selesai")
            ->distinct()
            ->get();

            // $totalder = Orders::select(
            //     'orders.*',
            // )
            // ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            // ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            // ->where('orders.date', '<=', $request->dtakhir)
            // ->where('orders.status', '=', "Selesai")
            // ->distinct()
            // ->sum('orders.total');

            $totalder = Detail_orders::leftjoin('orders', 'orders.id', '=', 'detail_orders.orders_id')
            ->where('orders.status', '=', 'Selesai')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.date', '<=', $request->dtakhir)
            ->sum('detail_orders.subtotal');

            $ongkirder = Orders::select(
                'orders.*',
            )
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.date', '<=', $request->dtakhir)
            ->where('orders.status', '=', "Selesai")
            ->distinct()
            ->sum('orders.ongkir');

            $totalnewder = $totalder - $ongkirder;

            $jumlahder = sizeof($page);

            $pembelian = Pembelian::select(
                'pembelians.*',
                'pembelians.id as id_pembelian',
                'customers.first_name as nama_depan',
                'customers.last_name as nama_belakang',
            )
            ->join('users', 'users.id', '=', 'pembelians.users_id')
            ->join('customers', 'customers.users_id', '=', 'users.id')
            ->where('pembelians.date', '<=', $request->dtakhir)
            ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            $totalpem = Pembelian::select(
                'pembelians.*',
                'pembelians.id as id_pembelian',
                'customers.first_name as nama_depan',
                'customers.last_name as nama_belakang',
            )
            ->join('users', 'users.id', '=', 'pembelians.users_id')
            ->join('customers', 'customers.users_id', '=', 'users.id')
            ->where('pembelians.date', '<=', $request->dtakhir)
            ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
            ->sum('pembelians.total');

            $jumlahpem = Pembelian::select(
                'pembelians.*',
                'pembelians.id as id_pembelian',
                'customers.first_name as nama_depan',
                'customers.last_name as nama_belakang',
            )
            ->join('users', 'users.id', '=', 'pembelians.users_id')
            ->join('customers', 'customers.users_id', '=', 'users.id')
            ->where('pembelians.date', '<=', $request->dtakhir)
            ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
            ->count();


            $awal = "";
            $akhir = $request->dtakhir;
        } elseif ($request->dtawal != null && $request->dtakhir != null) {
            $custom = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '>=', $request->dtawal)
            ->where('customs.date', '<=', $request->dtakhir)
            ->where('customs.status_payment', '=', 'Lunas')
            ->get();

            $totalcus = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '>=', $request->dtawal)
            ->where('customs.date', '<=', $request->dtakhir)
            ->where('customs.status_payment', '=', 'Lunas')
            ->sum('customs.subtotal');
            // ->sum('customs.total');

            $jumlahcus = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.date', '>=', $request->dtawal)
            ->where('customs.date', '<=', $request->dtakhir)
            ->where('customs.status_payment', '=', 'Lunas')
            ->count();

            $page = Orders::select(
                'orders.*',
            )
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.date', '>=', $request->dtawal)
            ->where('orders.date', '<=', $request->dtakhir)
            ->where('orders.status', '=', "Selesai")
            ->distinct()
            ->get();

            // $totalder = Orders::select(
            //     'orders.*',
            // )
            // ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            // ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            // ->where('orders.date', '>=', $request->dtawal)
            // ->where('orders.date', '<=', $request->dtakhir)
            // ->where('orders.status', '=', "Selesai")
            // ->distinct()
            // ->sum('orders.total');

            $totalder = Detail_orders::leftjoin('orders', 'orders.id', '=', 'detail_orders.orders_id')
            ->where('orders.status', '=', 'Selesai')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.date', '>=', $request->dtawal)
            ->where('orders.date', '<=', $request->dtakhir)
            ->sum('detail_orders.subtotal');

            $ongkirder = Orders::select(
                'orders.*',
            )
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.date', '>=', $request->dtawal)
            ->where('orders.date', '<=', $request->dtakhir)
            ->where('orders.status', '=', "Selesai")
            ->distinct()
            ->sum('orders.ongkir');

            $totalnewder = $totalder - $ongkirder;

            $jumlahder = sizeof($page);

            $pembelian = Pembelian::select(
                'pembelians.*',
                'pembelians.id as id_pembelian',
                'customers.first_name as nama_depan',
                'customers.last_name as nama_belakang',
            )
            ->join('users', 'users.id', '=', 'pembelians.users_id')
            ->join('customers', 'customers.users_id', '=', 'users.id')
            ->where('pembelians.date', '>=', $request->dtawal)
            ->where('pembelians.date', '<=', $request->dtakhir)
            ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            $totalpem = Pembelian::select(
                'pembelians.*',
                'pembelians.id as id_pembelian',
                'customers.first_name as nama_depan',
                'customers.last_name as nama_belakang',
            )
            ->join('users', 'users.id', '=', 'pembelians.users_id')
            ->join('customers', 'customers.users_id', '=', 'users.id')
            ->where('pembelians.date', '>=', $request->dtawal)
            ->where('pembelians.date', '<=', $request->dtakhir)
            ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
            ->sum('pembelians.total');

            $jumlahpem = Pembelian::select(
                'pembelians.*',
                'pembelians.id as id_pembelian',
                'customers.first_name as nama_depan',
                'customers.last_name as nama_belakang',
            )
            ->join('users', 'users.id', '=', 'pembelians.users_id')
            ->join('customers', 'customers.users_id', '=', 'users.id')
            ->where('pembelians.date', '>=', $request->dtawal)
            ->where('pembelians.date', '<=', $request->dtakhir)
            ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
            ->count();

            $awal = $request->dtawal;
            $akhir = $request->dtakhir;
        } else {
            $custom = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.status_payment', '=', 'Lunas')
            ->get();

            $totalcus = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.status_payment', '=', 'Lunas')
            ->sum('customs.subtotal');
            // ->sum('customs.total');

            $jumlahcus = Customs::select(
                'customs.id as id_custom',
                'customs.*',
                'umkms.umkm_name',
                'umkms.phone as no_umkm',
            )
            ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
            ->where('customs.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('customs.status_payment', '=', 'Lunas')
            ->count();

            $page = Orders::select(
                'orders.*',
            )
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.status', '=', "Selesai")
            ->distinct()
            ->get();

            // $totalder = Orders::select(
            //     'orders.*',
            // )
            // ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            // ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            // ->where('orders.status', '=', "Selesai")
            // ->distinct()
            // ->sum('orders.total');

            $totalder = Detail_orders::leftjoin('orders', 'orders.id', '=', 'detail_orders.orders_id')
            ->where('orders.status', '=', 'Selesai')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->sum('detail_orders.subtotal');

            $ongkirder =Orders::select(
                'orders.*',
            )
            ->join('detail_orders', 'detail_orders.orders_id', '=', 'orders.id')
            ->where('detail_orders.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('orders.status', '=', "Selesai")
            ->distinct()
            ->sum('orders.ongkir');

            $totalnewder = $totalder - $ongkirder;

            $jumlahder = sizeof($page);

            $pembelian = Pembelian::select(
                'pembelians.*',
                'pembelians.id as id_pembelian',
                'customers.first_name as nama_depan',
                'customers.last_name as nama_belakang',
            )
            ->join('users', 'users.id', '=', 'pembelians.users_id')
            ->join('customers', 'customers.users_id', '=', 'users.id')
            ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            $totalpem = Pembelian::select(
                'pembelians.*',
                'pembelians.id as id_pembelian',
                'customers.first_name as nama_depan',
                'customers.last_name as nama_belakang',
            )
            ->join('users', 'users.id', '=', 'pembelians.users_id')
            ->join('customers', 'customers.users_id', '=', 'users.id')
            ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
            ->sum('pembelians.total');

            $jumlahpem = Pembelian::select(
                'pembelians.*',
                'pembelians.id as id_pembelian',
                'customers.first_name as nama_depan',
                'customers.last_name as nama_belakang',
            )
            ->join('users', 'users.id', '=', 'pembelians.users_id')
            ->join('customers', 'customers.users_id', '=', 'users.id')
            ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
            ->count();
        }

        // dd(
        //     $request->all(),
        //     $totalder,
        //     $ongkirder,
        //     $totalnewder,
        // );

        if (empty($page[0]) && empty($custom[0]) && empty($pembelian[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            $cetak = PDF::loadview('admin.laporan_keuangan', [
                'page'=>$page,
                'pembelian'=>$pembelian,
                'custom'=>$custom,
                'awal'=>$awal,
                'akhir'=>$akhir,
                'totalpem'=>$totalpem,
                'totalcus'=>$totalcus,
                'totalder'=>$totalder,
                'totalnewder'=>$totalnewder,
                'jumlahpem'=>$jumlahpem,
                'jumlahcus'=>$jumlahcus,
                'jumlahder'=>$jumlahder,
                'nama_umkm'=>$nama_umkm,
            ])->setPaper('a4', 'landscape');

            // return view('admin.laporan_keuangan', [
            //     'page'=>$page,
            //     'pembelian'=>$pembelian,
            //     'custom'=>$custom,
            //     'awal'=>$awal,
            //     'akhir'=>$akhir,
            //     'totalpem'=>$totalpem,
            //     'totalcus'=>$totalcus,
            //     'totalder'=>$totalder,
            //     'jumlahpem'=>$jumlahpem,
            //     'jumlahcus'=>$jumlahcus,
            //     'jumlahder'=>$jumlahder,
            //     'nama_umkm'=>$nama_umkm,
            // ]);

            return $cetak->download('Laporan Keuangan, Periode '.
            $awal.'-'.$akhir.'.pdf');
        }


        // dd(
        //     $request->all(),
        // );
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
