<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Materials;
use App\Models\Suppliers;
use App\Models\Pembelian;
use App\Models\Detail_pembelians;
use App\Models\Arr_pembelians;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Redirect;

class Arr_pembelianController extends Controller
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

    public function simpantransaksi($id_user)
    {
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        $waktu = Carbon::now();

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        if ($id_user != auth()->user()->id) {
            Alert::info('Proses Gagal', 'Data user tidak sama');
            return Redirect::back();
        }

        $arr_data = Arr_pembelians::select(
            'arr_pembelians.*',
            'suppliers.name as nama_sup',
        )
        ->join('suppliers', 'suppliers.id', '=', 'arr_pembelians.suppliers_id')
        ->where('arr_pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('arr_pembelians.users_id', '=', auth()->user()->id)
        ->get();

        $total = Arr_pembelians::join('suppliers', 'suppliers.id', '=', 'arr_pembelians.suppliers_id')
        ->where('arr_pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
        ->where('arr_pembelians.users_id', '=', auth()->user()->id)
        ->sum('arr_pembelians.subtotal');

        // dd(
        //     $id_user,
        //     $arr_data,
        //     $arr_data[0]->suppliers_id,
        //     sizeof($arr_data),
        //     $waktu,
        // );

        if (empty($arr_data[0])) {
            Alert::info('Proses Gagal', 'Anda belum menambahkan data apapun!');
            return Redirect::back();
        } else {
            // Insert code
            Pembelian::create([
                'umkms_id' => $idumkm[0]->umkms_id,
                'users_id' => auth()->user()->id,
                'date' => $waktu,
                'total' => $total,
            ]);

            $id_pembelian = Pembelian::where('umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('users_id', '=', auth()->user()->id)
            ->orderBy('id', 'desc')
            ->get();

            for ($i=0; $i < sizeof($arr_data); $i++) {
                // Insert code
                Detail_pembelians::create([
                    'pembelians_id' => $id_pembelian[0]->id,
                    'suppliers_id' => $arr_data[$i]->suppliers_id,
                    'name_material' => $arr_data[$i]->name_material,
                    'qty' => $arr_data[$i]->qty,
                    'price' => $arr_data[$i]->price,
                    'subtotal' => $arr_data[$i]->subtotal,
                    'tgl_pengiriman' => $arr_data[$i]->tgl_pengiriman,
                    'tgl_penerimaan' => $arr_data[$i]->tgl_penerimaan,
                ]);

                $material = Materials::where('umkms_id', '=', $idumkm[0]->umkms_id)
                ->where('name', '=', $arr_data[$i]->name_material)
                ->get();

                if (empty($material[0])) {
                    // nothing
                } else {
                    // Penambahan Stok
                    $penambahan = 0;
                    $penambahan = $material[0]->qty + $arr_data[$i]->qty;
                    DB::table('materials')->where('umkms_id', '=', $idumkm[0]->umkms_id)
                    ->where('id', $material[0]->id)
                    ->update([
                        'qty' => $penambahan,
                    ]);
                }
            }
            // Delete arr
            $delete = Arr_pembelians::where('users_id', '=', auth()->user()->id);
            $delete->delete();

            Alert::success('Update Berhasil', 'Data telah tersimpan');
            return redirect('/transaksi_pembelian');
        }
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
        // dd(
        //     $request->all(),
        //     auth()->user()->id,
        // );

        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        $waktu = Carbon::now();
        if ($request->date_pengiriman > $request->date_penerimaan ||
        $request->date > $request->date_pengiriman ||
        $request->date > $request->date_penerimaan) {
            Alert::info('Proses Gagal', 'Perhatikan urutan tanggal');
            return Redirect::back();
        } else {
            // Validasi Tanggal dulu ges
            if ($request->cbname != null && $request->cbsup != null) {
                //insert
                Arr_pembelians::create([
                    'umkms_id' => $request->umkms_id,
                    'users_id' => auth()->user()->id,
                    'suppliers_id' => $request->cbsup,
                    'name_material' => $request->cbname,
                    'date' => $request->date,
                    'tgl_pengiriman' => $request->date_pengiriman,
                    'tgl_penerimaan' => $request->date_penerimaan,
                    'qty' => $request->qty,
                    'price' => $request->price,
                    'subtotal' => $request->sub,
                    'created_at' => $waktu,
                ]);

                Alert::success('Proses Berhasil', 'Data telah tersimpan');
                return redirect('/transaksi_pembelian/create');
            } else {
                Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
                return redirect('/transaksi_pembelian/create');
            }
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
        if (auth()->user()->role == "produksi") {
            Alert::info('Proses Gagal', 'Anda tidak memiliki akses');
            return view('admin.pages.error.page_404');
        }

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        // dd(
        //     $id,
        // );

        if ($id != null) {
            //cek
            $cek = Arr_pembelians::join('suppliers', 'suppliers.id', '=', 'arr_pembelians.suppliers_id')
            ->where('arr_pembelians.umkms_id', '=', $idumkm[0]->umkms_id)
            ->where('arr_pembelians.users_id', '=', auth()->user()->id)
            ->where('arr_pembelians.id', '=', $id)
            ->get();

            if (empty($cek[0])) {
                Alert::info('Proses Gagal', 'Data tidak dapat ditemukan');
                return Redirect::back();
            } else {
                $delete = Arr_pembelians::findOrFail($id);
                $delete->delete();
                Alert::success('Proses Berhasil', 'Data berhasil dihapus');
                return Redirect::back();
            }
        } else {
            Alert::info('Proses Gagal', 'Data tidak dapat ditemukan');
            return Redirect::back();
        }
    }
}
