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
                    <a href="#">Data Transaksi Penjualan</a>&nbsp;
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Eksport Data Transaksi Penjualan</h2>
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
                                    <form action="{{ route('pdflaporan.order') }}" method="post" validate
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
                        <h2>Data Transaksi Penjualan</h2>
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
                                        Data transaksi penjualan berisikan informasi daftar transaksi penjualan yang
                                        tersimpan pada sistem, digunakan sebagai pencatatan data transaksi penjualan
                                        produk yang masuk dalam sistem.
                                    </p>
                                    <!-- <table id="datatable-responsive" -->
                                    <table id="datatable-buttons"
                                        class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                        width="100%" data-order='[[ 3, "asc" ]]'>
                                        <thead>
                                            <tr>
                                                <th>Nama Pemesan</th>
                                                <th>Nomor Telepon</th>
                                                <th>Status Pesanan</th>
                                                <th>Batas Pengerjaan (Sisa)</th>
                                                <th>Last Updated (Selisih)</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($page as $item)
                                            <tr>
                                                <td>{{ $item->first_name }}&nbsp;{{ $item->last_name }}</td>
                                                <td><a href="https://wa.me/{{ $item->phone }}" target="_blank">
                                                        {{ $item->phone }}
                                                    </a>
                                                </td>
                                                <td style="text-transform:capitalize;">{{ $item->status }}
                                                    <span hidden>{{ $batas = 0; }}</span>
                                                    <span hidden>{{ $selisih=0; }}</span>
                                                </td>
                                                <td>
                                                    @if($item->status == 'Menunggu Konfirmasi')
                                                    <span hidden>{{ $now = Carbon\Carbon::now(); }}</span>
                                                    <span hidden>
                                                        {{
                                                        $batas = $item->created_at->addHours($deadline[0]->deadline)
                                                        }}
                                                    </span>
                                                    {{ $batas = $item->created_at->addHours($deadline[0]->deadline) }}
                                                    @if($batas >= $now ) ({{$selisih=$batas->diffInHours(); }} Jam)
                                                    @else
                                                    ({{ $nol = 0; }} Jam) <br>
                                                    <b>Telah Melewati Batas Deadline</b>
                                                    @endif
                                                    @else
                                                    {{ $item->status }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $item->updated_at->diffForHumans([
                                                    'parts' => 3,
                                                    'join' => true,
                                                    ])
                                                    }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('transaksi_penjualan.show',[Crypt::encrypt($item->id_orders)]) }}"
                                                        class="btn btn-info btn-xs"><i class="fa fa-eye"></i>
                                                        Detail
                                                    </a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6">Data Transaksi Penjualan Kosong</td>
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
        <!-- Selesai -->
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Data Transaksi Penjualan Selesai</h2>
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
                                        Data transaksi penjualan berisikan informasi daftar transaksi penjualan yang
                                        tersimpan pada sistem, digunakan sebagai pencatatan data transaksi penjualan
                                        produk yang masuk dalam sistem.
                                    </p>
                                    <!-- <table id="datatable-responsive" -->
                                    <table id="datatable"
                                        class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                        width="100%" data-order='[[ 3, "asc" ]]'>
                                        <thead>
                                            <tr>
                                                <th>Nama Pemesan</th>
                                                <th>Nomor Telepon</th>
                                                <th>Status Pesanan</th>
                                                <th>Last Updated (Selisih)</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($pagebawah as $itembawah)
                                            <tr>
                                                <td>{{ $itembawah->first_name }}&nbsp;{{ $itembawah->last_name }}</td>
                                                <td><a href="https://wa.me/{{ $itembawah->phone }}" target="_blank">
                                                        {{ $itembawah->phone }}
                                                    </a>
                                                </td>
                                                <td style="text-transform:capitalize;">
                                                    {{ $itembawah->status }}
                                                </td>
                                                <td>
                                                    {{ $itembawah->updated_at }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('transaksi_penjualan.show',[Crypt::encrypt($itembawah->id_orders)]) }}"
                                                        class="btn btn-info btn-xs"><i class="fa fa-eye"></i>
                                                        Detail
                                                    </a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6">Data Transaksi Penjualan Kosong</td>
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
<!-- <script src="{{asset('customer/js/vendor/disable-dtb.js')}}"></script> -->
@endsection