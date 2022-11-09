<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Deadlines;
use App\Models\Umkms;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Redirect;
use PDF;

class DeadlineController extends Controller
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

        $page = Deadlines::select(
            'deadlines.id as id_deadline',
            'deadlines.*',
        )
        ->join('umkms', 'deadlines.umkms_id', '=', 'umkms.id')
        ->where('deadlines.umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        if (empty($page[0])) {
            Alert::info('Proses Gagal', 'Data Deadline tidak boleh kosong');
            $pageactive = "admintambahdeadline";
            $title = "Halaman Tambah Data Deadline";
            return view('admin.pages.deadline.create_deadline', [
                'page' => $page,
                'pageactive' => $pageactive,
                'title' => $title,
            ]);
        } else {
            $pageactive = "admindeadline";
            $title = "Halaman Data Deadline";
            return view('admin.pages.deadline.data_deadline', [
                'page' => $page,
                'pageactive' => $pageactive,
                'title' => $title,
            ]);
        }

        // dd(
        //     $idumkm,
        //     $page,
        // );
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

        $page = Deadlines::join('umkms', 'deadlines.umkms_id', '=', 'umkms.id')
        ->where('deadlines.umkms_id', '=', $idumkm[0]->umkms_id)
        ->get();

        // dd(
        //     $idumkm,
        //     $page,
        // );

        if (empty($page[0])) {
            $pageactive = "admintambahdeadline";
            $title = "Halaman Tambah Data Deadline";
            return view('admin.pages.deadline.create_deadline', [
                'page' => $page,
                'pageactive' => $pageactive,
                'title' => $title,
            ]);
        } else {
            Alert::info('Proses Gagal', 'Data telah ada pada sistem');
            return Redirect::back();
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
        // dd(
        //     $request->all(),
        // );

        $validator = Validator::make(request()->all(), [
            'deadline' => 'required|numeric|min:1',
        ])->setAttributeNames(
            [
                'deadline' => '"Batas Deadline"'
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        if ($request->all() != null) {
            if ($request->deadline <= 0) {
                Alert::info('Proses Gagal', 'Inputan tidak boleh kurang dari 0');
                return Redirect::back();
            } else {
                Deadlines::create([
                    'umkms_id' => $request->id_umkm,
                    'deadline' => $request->deadline,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                // Alert::success('Proses Berhasil', 'Data telah tersimpan');
                // return redirect('/deadline');
                return redirect()->route("deadline.index")->with("info", "Data Deadline berhasil disimpan");
            }
        } else {
            Alert::info('Proses Gagal', 'Inputan tidak boleh kosong');
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
        // dd(
        //     $id,
        // );

        $idumkm = DB::table('users')
        ->where('username', '=', auth()->user()->username)
        ->get();

        if ($id != null) {
            $delete = Deadlines::findOrFail($id);
            $delete->delete();

            // Alert::success('Proses Berhasil', 'Data berhasil dihapus');
            // return Redirect::back();
            return redirect()->route("deadline.index")->with("info", "Data Deadline berhasil dihapus");
        } else {
            Alert::info('Proses Gagal', 'Data tidak ditemukan');
            return Redirect::back();
        }
    }
}
