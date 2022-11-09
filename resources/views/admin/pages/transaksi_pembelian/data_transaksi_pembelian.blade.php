@extends('admin.layouts.app')
@section('title')
{{ $title }}
@endsection
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <p>
                    <a href="/admin">Home</a>&nbsp;<small><i class="fa fa-long-arrow-right"></small></i>
                    <a href="#">Data Transaksi Pembelian</a>&nbsp;
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Eksport Data Transaksi Pembelian</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                </div>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <p class="text-muted font-13 m-b-30">
                                        Masukkan tanggal awal dan akhir untuk memfilter data yang ingin dieksport.
                                        <b>*kosongkan semua inputan jika ingin mengeksport semua data.</b>
                                    </p>
                                    <form action="{{ route('pdflaporan.pembelian') }}" method="post" validate
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="field item form-group col-md-3 col-sm-3">
                                            <input type="date" name="dtawal" class="form-control has-feedback-left">
                                            <span class="fa fa-cloud form-control-feedback left"
                                                aria-hidden="true"></span>
                                        </div>
                                        <div class="field item form-group col-md-3 col-sm-3">
                                            <input type="date" name="dtakhir" class="form-control has-feedback-left">
                                            <span class="fa fa-cloud form-control-feedback left"
                                                aria-hidden="true"></span>
                                        </div>
                                        <div class="form-group">
                                            <button type='submit' class="btn btn-primary">Eksport</button>
                                        </div>
                                    </form>
                                    <!--  -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Data Transaksi Pembelian</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="/transaksi_pembelian/create">Tambah Data</a>
                                </div>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <p class="text-muted font-13 m-b-30">
                                        Data transaksi pembelian berisikan informasi daftar transaksi pembelian yang
                                        tersimpan pada sistem, digunakan sebagai pencatatan data transaksi pembelian
                                        bahan baku yang telah dilakukan.
                                    </p>
                                    <!-- <table id="datatable-responsive" -->
                                    <table id="datatable-buttons"
                                        class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>Nama Admin</th>
                                                <th>Tanggal Input</th>
                                                <th>Aksi</th>
                                                @if(auth()->user()->role == "admin")
                                                <th></th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($page as $item)
                                            <tr>
                                                <td style="text-transform:uppercase;">
                                                    {{ $item->nama_depan }}&nbsp;{{ $item->nama_belakang }}
                                                </td>
                                                <td>{{ $item->date }}</td>
                                                <td>
                                                    <a href="{{ route('transaksi_pembelian.show', $item->id_pembelian) }}"
                                                        class="btn btn-primary btn-xs">
                                                        <i class="fa fa-folder"></i>
                                                        View
                                                    </a>
                                                </td>
                                                @if(auth()->user()->role == "admin")
                                                <td>
                                                    <form action="" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger btn-xs"><i
                                                                class="fa fa-trash-o"></i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                                @endif
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7">Data Transaksi Pembelian Kosong</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection