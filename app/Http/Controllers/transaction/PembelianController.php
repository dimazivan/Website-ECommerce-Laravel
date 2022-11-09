<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Materials;
use App\Models\Suppliers;
use App\Models\Pembelian;
use App\Models\Umkms;
use App\Models\Detail_pembelians;
use App\Models\Arr_pembelians;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;
use Redirect;

class PembelianController extends Controller
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

        $page = Pembelian::select(
            'pembelians.*',
            'pembelians.id as id_pembelian',
            'customers.first_name as nama_depan',
            'customers.last_name as nama_belakang',
        )
        ->join('users', 'users.id', '=', 'pembelians.users_id')
        ->join('customers', 'customers.users_id', '=', 'users.id')
        ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $data_material = Materials::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        if (empty($data_material[0])) {
            // if (!isset($data_material)) {
            Alert::info('Proses Gagal', 'Data Material Kosong');
            return redirect('/bahan_baku/create');
        }

        $data_supplier = Suppliers::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        if (empty($data_supplier[0])) {
            // if (!isset($data_supplier)) {
            Alert::info('Proses Gagal', 'Data Supplier Kosong');
            return redirect('/supplier/create');
        }


        // dd(
        //     $page,
        // );

        $pageactive = 'adminpembelian';
        $title = "Halaman Transaksi Pembelian";
        return view('admin.pages.transaksi_pembelian.data_transaksi_pembelian', [
            'page' => $page,
            'pageactive' => $pageactive,
            'title' => $title,
        ]);
    }

    public function pdflaporan(Request $request)
    {
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

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
            $page = Pembelian::select(
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

            $total = Pembelian::select(
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

            $jumlah = Pembelian::select(
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
            $page = Pembelian::select(
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

            $total = Pembelian::select(
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

            $jumlah = Pembelian::select(
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
            $page = Pembelian::select(
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

            $total = Pembelian::select(
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

            $jumlah = Pembelian::select(
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
            $page = Pembelian::select(
                'pembelians.*',
                'pembelians.id as id_pembelian',
                'customers.first_name as nama_depan',
                'customers.last_name as nama_belakang',
            )
            ->join('users', 'users.id', '=', 'pembelians.users_id')
            ->join('customers', 'customers.users_id', '=', 'users.id')
            ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
            ->get();

            $total = Pembelian::select(
                'pembelians.*',
                'pembelians.id as id_pembelian',
                'customers.first_name as nama_depan',
                'customers.last_name as nama_belakang',
            )
            ->join('users', 'users.id', '=', 'pembelians.users_id')
            ->join('customers', 'customers.users_id', '=', 'users.id')
            ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
            ->sum('pembelians.total');

            $jumlah = Pembelian::select(
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


        if (empty($page[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return view('admin.pages.error.page_404');
        } else {
            $cetak = PDF::loadview('admin.pages.transaksi_pembelian.laporan_pembelian', [
                'page'=>$page,
                'awal'=>$awal,
                'akhir'=>$akhir,
                'total'=>$total,
                'jumlah'=>$jumlah,
                'nama_umkm'=>$nama_umkm,
            ])->setPaper('a4', 'landscape');

            // Tester
            // return view('admin.pages.transaksi_pembelian.laporan_pembelian', [
            //     'page'=>$page,
            //     'awal'=>$awal,
            //     'akhir'=>$akhir,
            //     'total'=>$total,
            //     'jumlah'=>$jumlah,
            //     'nama_umkm'=>$nama_umkm,
            // ]);
            return $cetak->download('Laporan Transaksi Pembelian, Periode '.
            $awal.'-'.$akhir.'.pdf');
        }

        dd(
            $request->all(),
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $page = Pembelian::select(
            'pembelians.*',
            'pembelians.id as id_pembelian',
            'customers.first_name as nama_depan',
            'customers.last_name as nama_belakang',
        )
        ->join('users', 'users.id', '=', 'pembelians.users_id')
        ->join('customers', 'customers.users_id', '=', 'users.id')
        ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();



        $arr_data = Arr_pembelians::select(
            'arr_pembelians.*',
            'suppliers.name as nama_sup',
            'arr_pembelians.id as id_arr',
        )
        ->join('suppliers', 'suppliers.id', '=', 'arr_pembelians.suppliers_id')
        ->where('arr_pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('arr_pembelians.users_id', '=', auth()->user()->id)
        ->get();

        $total = Arr_pembelians::join('suppliers', 'suppliers.id', '=', 'arr_pembelians.suppliers_id')
        ->where('arr_pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('arr_pembelians.users_id', '=', auth()->user()->id)
        ->sum('arr_pembelians.subtotal');

        $material = Materials::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $supplier = Suppliers::where('umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        $pageactive = 'adminpembeliancreate';
        $title = "Form Tambah Transaksi Pembelian";
        return view('admin.pages.transaksi_pembelian.create_transaksi_pembelian', [
            'page' => $page,
            'total' => $total,
            'arr_data' => $arr_data,
            'material' => $material,
            'supplier' => $supplier,
            'idumkm' => $idumkm[0]->umkms_id,
            'pageactive' => $pageactive,
            'title' => $title,
        ]);
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
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        $page = Pembelian::select(
            'pembelians.*',
            'pembelians.id as id_pembelian',
            'customers.users_id as id_user',
            'customers.first_name as nama_depan',
            'customers.last_name as nama_belakang',
            'customers.phone as no_telp',
            'customers.address as alamat',
            'customers.districts as kecamatan',
            'customers.ward as kelurahan',
            'customers.city as kota',
            'customers.province as provinsi',
            'customers.postal_code as kode_pos',
        )
        ->join('users', 'users.id', '=', 'pembelians.users_id')
        ->join('customers', 'customers.users_id', '=', 'users.id')
        ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('pembelians.id', '=', $id)
        ->get();

        if (empty($page[0])) {
            Alert::info('Proses Gagal', 'Data tidak ditemukkan');
            return Redirect::back();
        } else {
            $detail = Detail_pembelians::select(
                'detail_pembelians.*',
                'suppliers.name as nama_suppliers',
            )
            ->join('pembelians', 'pembelians.id', '=', 'detail_pembelians.pembelians_id')
            ->join('suppliers', 'suppliers.id', '=', 'detail_pembelians.suppliers_id')
            ->where('pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('detail_pembelians.pembelians_id', '=', $id)
            ->get();

            // dd(
            //     $id,
            //     $page,
            //     $detail,
            // );

            $pageactive = 'adminpembelian';
            $title = "Halaman Transaksi Pembelian";
            return view('admin.pages.transaksi_pembelian.detail_transaksi_pembelian', [
                'page' => $page,
                'detail' => $detail,
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
        // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
        // return view('admin.pages.error.page_404');
    }
}
