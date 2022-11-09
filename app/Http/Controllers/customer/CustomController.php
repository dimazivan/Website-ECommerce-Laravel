<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\User;
use App\Models\Umkms;
use App\Models\Province;
use App\Models\City;
use App\Models\Courier;
use App\Models\Expeditions;
use App\Models\Customs;
use App\Models\Estimations;
use App\Models\Feedback_customs;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Redirect;

class CustomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Info::first();

        $listumkm = Estimations::select(
            'umkms.*',
            'estimations.*',
            DB::raw('SUM(estimations.durasi) AS jumlah'),
            'estimations.umkms_id as id_umkm',
            'infos.title as alias',
        )
        ->leftjoin('umkms', 'umkms.id', '=', 'estimations.umkms_id')
        ->leftjoin('infos', 'infos.umkms_id', '=', 'estimations.umkms_id')
        ->groupBy('estimations.umkms_id')
        ->orderBy('estimations.durasi', 'ASC')
        ->get();
        // ->sum('estimations.durasi');

        // $listumkm = Estimations::select('umkms.*', 'estimations.*', 'sum(estimations.durasi)')
        // ->whereNotIn('umkms.umkm_name', ['CUSTOMER'])
        // ->whereNotIn('umkms.umkm_name', ['SUPER'])
        // ->join('umkms', 'umkms.id', '=', 'estimations.umkms_id')
        // ->groupBy('estimations.umkms_id')
        // ->get();

        // $jumlah = [];

        // $jumlah = Estimations::whereNotIn('umkms.umkm_name', ['CUSTOMER'])
        // ->whereNotIn('umkms.umkm_name', ['SUPER'])
        // ->join('umkms', 'umkms.id', '=', 'estimations.umkms_id')
        // ->groupBy('estimations.umkms_id')
        // ->sum('estimations.durasi');
        // ->first();

        // $arr = [];
        // foreach ($listumkm as $row) {
        //     $jumlah = Estimations::whereNotIn('umkms.umkm_name', ['CUSTOMER'])
        //     ->whereNotIn('umkms.umkm_name', ['SUPER'])
        //     ->where('estimations.id', '=', $row->id)
        //     ->join('umkms', 'umkms.id', '=', 'estimations.umkms_id')
        //     ->groupBy('estimations.umkms_id')
        //     ->sum('estimations.durasi');

        //     // $stock = DB::table('stocks')
        //     //     ->where('products_id', $row->id_products)
        //     //     ->where('size', $row->size)
        //     //     ->first();

        //     $jumlah = collect($jumlah);
        //     $baris = collect($row);
        //     $gabung = $jumlah->merge($baris);
        //     array_push($arr, $gabung);
        // }

        // $arr = json_decode(json_encode($arr, true));


        // dd(
        // $listumkm,
        // $listumkm[0]->id,
        // $jumlah,
        // $arr,
        // $durasi,
        // $gabungan,
        // );

        $isi =[];
        for ($i=0; $i < sizeof($listumkm) ; $i++) {
            $waktu = $listumkm[$i]->jumlah;
        }
        $isi = $waktu;

        // $test = 72%24;

        // $sekarang = Carbon::now()->timezone('Asia/Jakarta');
        // $test = Carbon::now()->addHours(11);
        // $current = Carbon::now();
        // $estimasi = $current->addHours($listumkm[0]->jumlah);

        // $arr = [];
        // foreach ($listumkm as $row) {
        //     $waktu = $row->jumlah;
        //     $current = Carbon::now('Asia/Jakarta');
        //     $current->setTimezone('Asia/Jakarta');
        //     $jumlah = $current->addHours($waktu);

        //     $jumlah = collect($jumlah);
        //     $baris = collect($row);
        //     $gabung = $jumlah->merge($baris);
        //     array_push($arr, $gabung);
        //     $arr[] = $jumlah;
        // }

        // $arr = json_decode(json_encode($arr, true));

        // dd(
        //     $sekarang,
        //     $waktu,
        //     $jumlah,
        //     $arr,
        //     $test,
        // );


        // dd(
        // $jumlah,
        // $arr,
        // $isi,
        // $sekarang,
        // $current,
        // $estimasi,
        // );

        $user = User::where("users.id", auth()->user()->id)
        ->join('customers', 'customers.users_id', '=', 'users.id')
        ->get();

        $title = "Form Custom Order";
        $pageactive = 'customs';
        return view('customer.pages.custom.precustom', [
            // 'page' => $page,
            'user' => $user,
            // 'arr' => $arr,
            'umkm' => $listumkm,
            // 'umkm' => $gabungan,
            'title' => $title,
            'info' => $info,
            'pageactive' => $pageactive,
        ]);
    }

    public function listumkm()
    {
        $info = Info::first();

        $listumkm = Estimations::select(
            'umkms.*',
            'estimations.*',
            DB::raw('SUM(estimations.durasi) AS jumlah'),
            'estimations.umkms_id as id_umkm',
            'infos.title as alias',
        )
        ->leftjoin('umkms', 'umkms.id', '=', 'estimations.umkms_id')
        ->leftjoin('infos', 'infos.umkms_id', '=', 'estimations.umkms_id')
        ->groupBy('estimations.umkms_id')
        ->orderBy('estimations.durasi', 'ASC')
        ->get();

        // dd(
        //     $listumkm,
        // );

        if (isset($info->title)) {
            $title = $info->title;
        } else {
            $title = "Homepage";
        }

        $pageactive = "listumkm";

        return view('customer.pages.custom.list_umkm', [
            // 'user' => $user,
            'umkm' => $listumkm,
            'title' => $title,
            'info' => $info,
            'pageactive' => $pageactive,
        ]);
    }

    public function getumkm($umkm_name)
    {
        try {
            $decrypted = decrypt($umkm_name);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newname = Crypt::decrypt($umkm_name);

        $nama_umkm = $newname;
        $info = Info::first();
        $shipping = Expeditions::distinct()
        ->get();

        $listumkm = Estimations::select('umkms.*', 'estimations.*', DB::raw('SUM(estimations.durasi) AS jumlah'), 'estimations.umkms_id as id_umkm')
        ->leftjoin('umkms', 'umkms.id', '=', 'estimations.umkms_id')
        ->groupBy('estimations.umkms_id')
        ->get();

        $list_umkm = Umkms::where('id', '>', 2)
        ->get();

        // dd(
        //     $umkm_name,
        // );

        $user = User::where("users.id", auth()->user()->id)
        ->join('customers', 'customers.users_id', '=', 'users.id')
        ->get();

        // Raja Ongkir
        $couriers = Courier::pluck('title', 'code');
        $provinces = Province::pluck('title', 'province_id');

        // dd(
        //     $couriers,
        //     $provinces,
        // );

        if (empty($user[0])) {
            Alert::info('Informasi Data', 'Silahkan masukkan data diri Anda');
            return redirect('/profile');
        } else {
            $title = "Form Custom Order";
            $pageactive = 'customs';

            return view('customer.pages.custom.order_custom', [
            'user' => $user,
            'couriers' => $couriers,
            'provinces' => $provinces,
            'list_umkm' => $list_umkm,
            'umkm_name' => $nama_umkm,
            'umkm' => $listumkm,
            'shipping' => $shipping,
            'title' => $title,
            'info' => $info,
            'pageactive' => $pageactive,
            ]);
        }
    }

    public function bayarcustom($id_transaksi)
    {
        $info = Info::first();
        $title = "Form Pembayaran Transaksi Custom";
        $pageactive = "pembayarancustom";

        try {
            $decrypted = decrypt($id_transaksi);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id_transaksi);

        $page = Customs::where('id', '=', $newid)
        ->where('users_id', '=', auth()->user()->id)
        ->where('status', '=', 'Menunggu Pembayaran')
        ->orWhere('status_payment', '=', 'Ditangguhkan')
        ->get();

        $user = Customs::where("users_id", auth()->user()->id)
        ->get();

        // return redirect('/error');

        // dd(
        //     $page,
        //     $page[0]->id,
        //     $page[0]->first_name,
        // );

        if (empty($page[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return redirect('/error');
        } else {
            return view('customer.pages.custom.pembayaran_custom', [
                'page' => $page,
                'user' => $user,
                'title' => $title,
                'info' => $info,
                'pageactive' => $pageactive,
            ]);
        }
        //
    }

    public function feedbackcustom(Request $request)
    {
        $waktu = Carbon::now();
        $umkms_id = Umkms::where('umkm_name', '=', $request->umkm_name)
        ->get();

        // dd(
        //     $request->all(),
        //     $waktu,
        //     $umkms_id[0]->id,
        // );

        if ($request->desc != null) {
            //insert
            Feedback_customs::create([
                'umkms_id' => $umkms_id[0]->id,
                'customs_id' => $request->id_custom,
                'rating' => 0,
                'desc' => $request->desc,
                'created_at' => $waktu,
            ]);

            Alert::success('Feedback Diterima', 'Terima kasih telah melakukan transaksi');
            return redirect('/');
        } else {
            Alert::info('Proses Gagal', 'Inputan tidak boleh kosong');
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
        $umkms_id = Umkms::where('umkm_name', '=', $request->umkm_name)
        ->get();

        $waktu = Carbon::now();
        $date = Carbon::now()->toDateString();

        $validator = Validator::make(request()->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone' => 'required|numeric|digits_between:10,13',
            'postal_code' => 'required|numeric|digits_between:5,7',
            'address' => 'required|max:255',
            'districts' => 'required|max:255',
            'ward' => 'required|max:255',
            'city' => 'required|max:255',
            'province' => 'required|max:255',
            'desc' => 'required|max:255',
            'qty' => 'required|numeric|min:1',
            'cbshipping' => 'required',
            'detail' => 'required|max:255',
        ])->setAttributeNames(
            [
                'first_name' => '"Nama Depan"',
                'last_name' => '"Nama Belakang"',
                'phone' => '"Nomor Telepon"',
                'postal_code' => '"Kode Pos"',
                'address' => '"Alamat"',
                'districts' => '"Kecamatan"',
                'ward' => '"Kelurahan"',
                'city' => '"Kota"',
                'province' => '"Provinsi"',
                'desc' => '"Detail Alamat"',
                'qty' => '"Jumlah Order"',
                'cbshipping' => '"Jasa Pengiriman"',
                'detail' => '"Details Order"',
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        // if (filesize($request->file_desain) > 1000 * 10000) {
        //     $ukuran = 10000000 - filesize($request->file_desain);
        //     $hasil = $ukuran/1000000;
        //     $convert = filesize($request->file_desain)/1000000;
        //     $test = "ukurannya kebesaran ".$hasil."MB , Soalnya ukurannya ".$convert."MB";
        // } else {
        //     $ukuran = 10000000 - filesize($request->file_desain);
        //     $hasil = $ukuran/1000000;
        //     $convert = filesize($request->file_desain)/1000000;
        //     $test = "ukurannya masih bisa ".$hasil."MB , Soalnya ukurannya hanya ".$convert."MB";
        // }
        // dd(
        //     $request->all(),
        //     $request->file_desain,
        //     filesize($request->file_desain),
        //     $test,
        //     $request->file_desain->getClientOriginalExtension(),
        //     $umkms_id,
        //     $umkms_id[0]->id,
        //     auth()->user()->id,
        //     $waktu,
        //     $date,
        // );

        if ($request->cbshipping != null) {
            //validasi file
            if ($request->file_desain_depan != null &&
            $request->file_desain_belakang != null &&
            $request->qty > 0) {
                // Ukuran gambar
                if (filesize($request->file_desain_depan) > 1000 * 10000 &&
                filesize($request->file_desain_belakang) > 1000 * 10000) {
                    // Alert::warning('Proses Gagal', 'Ukuran File Gambar Harus Kurang dari 10MB');
                    // return redirect()->route("precustom.store", $request->umkm_name);
                    return back()->with("info", "Ukuran File Gambar Harus Kurang dari 10MB");
                } else {
                    // Cek Tipe Gambar
                    if (($request->file_desain_depan->getClientOriginalExtension() == "jpg" ||
                    $request->file_desain_depan->getClientOriginalExtension() == "jpeg" ||
                    $request->file_desain_depan->getClientOriginalExtension() == "png")&&(
                        $request->file_desain_belakang->getClientOriginalExtension() == "jpg" ||
                        $request->file_desain_belakang->getClientOriginalExtension() == "jpeg" ||
                        $request->file_desain_belakang->getClientOriginalExtension() == "png"
                    )) {
                        // Insert Database
                        $file_depan = $request->file('file_desain_depan');
                        $file_belakang = $request->file('file_desain_belakang');
                        $nama_file_depan = time() . "_" . $file_depan->getClientOriginalName();
                        $nama_file_belakang = time() . "_" . $file_belakang->getClientOriginalName();

                        $tujuan_upload = 'data_file/custom';
                        $file_depan->move($tujuan_upload, $nama_file_depan);
                        $file_belakang->move($tujuan_upload, $nama_file_belakang);

                        Customs::create([
                            'users_id' => auth()->user()->id,
                            'umkms_id' => $umkms_id[0]->id,
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
                            'qty' => $request->qty,
                            'date' => $date,
                            'status' => 'Menunggu Konfirmasi',
                            'shipping' => $request->cbshipping,
                            'pict_desain_depan' => $nama_file_depan,
                            'pict_desain_belakang' => $nama_file_belakang,
                            'keterangan' => $request->detail,
                            'created_at' => $waktu,
                        ]);

                        // $file = $request->file('file_desain');
                        // $nama_file = time() . "_" . $file->getClientOriginalName();

                        // $tujuan_upload = 'data_file';
                        // $file->move($tujuan_upload, $nama_file);
                        Alert::success('Orderan diterima', 'Cek status pesanan pada halaman history');
                        return redirect('/');
                    } else {
                        // Alert::warning('Proses Gagal', 'Jenis File Desain Harus Gambar');
                        // return redirect()->route("precustom.store", $request->umkm_name);
                        return back()->with("info", "Jenis File Desain Harus Gambar");
                    }
                }
            } else {
                Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
                return Redirect::back();
                // return redirect()->route("precustom.store", $request->umkm_name);
                // return redirect('precustom.store');
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return Redirect::back();
            // return redirect()->route("precustom.store", $request->umkm_name);
            // return redirect('precustom.store');
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
        try {
            $decrypted = decrypt($id);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id);

        $customs = Customs::select('customs.id as id_custom', 'customs.*', 'umkms.umkm_name')
        ->leftjoin('umkms', 'customs.umkms_id', '=', 'umkms.id')
        ->where('customs.users_id', '=', auth()->user()->id)
        ->where('customs.id', '=', $newid)
        ->where('customs.status_payment', '=', 'Lunas')
        ->get();

        // Cek feedback
        $cek = Feedback_customs::where('customs_id', '=', $newid)
        ->get();

        // dd(
        //     $id,
        //     $customs,
        // );

        $info = Info::first();
        $title = 'Feedback Transaksi Custom';
        $pageactive = 'feedbackcustom';

        if (empty($customs[0])) {
            Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
            return redirect('/error');
        } else {
            if (empty($cek[0])) {
                return view('customer.pages.custom.feedback_custom', [
                    // 'page' => $page,
                    'customs' => $customs,
                    'title' => $title,
                    'info' => $info,
                    'pageactive' => $pageactive,
                ]);
            } else {
                Alert::info('Proses Gagal', 'Anda pernah melakukan feedback');
                return redirect('/');
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
        // dd(
        //     $request->all(),
        // );

        try {
            $decrypted = decrypt($id);
            // Log
        } catch (DecryptException $e) {
            return view('admin.pages.error.page_404', [
                'e' => ["Invalid Data"],
            ]);
        }

        $newid = Crypt::decrypt($id);

        $update = Carbon::now();

        if ($request->all() != null) {
            //validasi file
            if ($request->pict_payment != null) {
                // Ukuran gambar
                if (filesize($request->pict_payment) > 1000 * 10000) {
                    // Alert::warning('Proses Gagal', 'Ukuran File Gambar Harus Kurang dari 10MB');
                    // return redirect()->route("bayarcustom.create", $id);
                    return back()->with("info", "Ukuran File Gambar Harus Kurang dari 10MB");
                } else {
                    // Cek Tipe Gambar
                    if ($request->pict_payment->getClientOriginalExtension() == "jpg" ||
                    $request->pict_payment->getClientOriginalExtension() == "jpeg" ||
                    $request->pict_payment->getClientOriginalExtension() == "png") {
                        // Insert Database
                        $file = $request->file('pict_payment');
                        $nama_file = time() . "_" . $file->getClientOriginalName();

                        $tujuan_upload = 'data_file/pembayaran';
                        $file->move($tujuan_upload, $nama_file);

                        DB::table('customs')->where('id', $request->id)->update([
                            'pict_payment' => $nama_file,
                            'status' => 'Menunggu Konfirmasi Pembayaran',
                            'status_payment' => 'Menunggu Konfirmasi Pembayaran',
                            'updated_at' => $update,
                        ]);

                        Alert::success('Berhasil upload bukti pembayaran', 'Cek status pesanan pada halaman history');
                        return redirect('/');
                    } else {
                        // Alert::warning('Proses Gagal', 'Jenis File Bukti Pembayaran Harus Gambar');
                        // return redirect()->route("bayarcustom.create", $id);
                        return back()->with("info", "Jenis File Bukti Pembayaran Harus Gambar");
                    }
                }
            } else {
                Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
                return redirect()->route("bayarcustom.create", $newid);
            }
        } else {
            Alert::warning('Proses Gagal', 'Inputan tidak boleh kosong');
            return redirect()->route("bayarcustom.create", $newid);
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
        // Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
        // return redirect('/error');
    }
}
