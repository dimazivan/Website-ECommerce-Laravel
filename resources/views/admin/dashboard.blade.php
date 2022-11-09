@extends('admin.layouts.app')
@section('title')
{{ $title }}
@endsection
@section('content')
<div class="right_col" role="main">
    <!-- Atas -->
    <div class="col-md-6" style="display: inline-block;">
        <div class="tile_count">
            <!-- Jumlah User -->
            <div class="col-md-2 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i>&nbsp;Total Users</span>
                <div class="count blue">
                    {{ str_pad($jml_user, 4, '0' , STR_PAD_LEFT); }}
                </div>
                <span class="count_bottom">
                    Jumlah User Terdaftar
                </span>
            </div>
            <!-- Jumlah Kategori -->
            <div class="col-md-2 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-tag"></i>&nbsp;Jumlah Kategori</span>
                <div class="count" style="color:green">
                    {{ str_pad($jml_kategori, 4, '0' , STR_PAD_LEFT); }}
                </div>
                <span class="count_bottom">
                    Jumlah Jenis Kategori
                </span>
            </div>
            <!-- Jumlah Produk -->
            <div class="col-md-2 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-tag"></i>&nbsp;Jenis Produk</span>
                <div class="count green">
                    {{ str_pad($jml_product, 4, '0' , STR_PAD_LEFT); }}
                </div>
                <span class="count_bottom">
                    Jenis Produk
                </span>
            </div>
            <!-- Jumlah Jenis Produk -->
            <div class="col-md-2 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-tag"></i>&nbsp;Jumlah Produk</span>
                <div class="count" style="color:black;">
                    {{ str_pad($jml_detproduct, 4, '0' , STR_PAD_LEFT); }}
                </div>
                <span class="count_bottom">
                    Jumlah Produk
                </span>
            </div>
            <!-- Jumlah Bahan Baku -->
            <div class="col-md-2 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-dropbox"></i>&nbsp;Jenis Material</span>
                <div class="count" style="color:orange">
                    {{ str_pad($jml_material, 4, '0' , STR_PAD_LEFT); }}
                </div>
                <span class="count_bottom">
                    Jenis Material
                </span>
            </div>
            <!-- Jumlah Supplier -->
            <div class="col-md-2 col-sm-4  tile_stats_count">
                <span class="count_top"> <i class="fa fa-truck"></i>&nbsp;Jumlah Supplier</span>
                <div class="count" style="color:brown;">
                    {{ str_pad($jml_supplier, 4, '0' , STR_PAD_LEFT); }}
                </div>
                <span class="count_bottom">
                    Jumlah Supplier
                </span>
            </div>
        </div>
        <!-- Total Seluruh -->
        <div class="tile_count">
            <!-- Omset -->
            <div class="col-md-4 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-inbox"></i>&nbsp;Omset Keseluruhan(Bersih)</span>
                <div class="count green" style="font-size:30px;">
                    Rp. {{number_format($jml_pemasukkan+$jml_pemasukkancus-$jml_pengeluaran,2,',','.')}}
                </div>
                <span class="count_bottom">
                    Total Omset (Rp.)
                </span>
            </div>
            <!-- Pemasukan -->
            <div class="col-md-4 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-arrow-up"></i>&nbsp;Pemasukan Keseluruhan</span>
                <div class="count blue" style="font-size:30px;">
                    Rp. {{number_format($jml_pemasukkan+$jml_pemasukkancus,2,',','.')}}
                </div>
                <span class="count_bottom">
                    Total Pemasukkan (Rp.)
                </span>
            </div>
            <!-- Pengeluaran -->
            <div class="col-md-4 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-arrow-down"></i>&nbsp;Pengeluaran Keseluruhan</span>
                <div class="count red" style="font-size:30px;">
                    Rp. {{number_format($jml_pengeluaran,2,',','.')}}
                </div>
                <span class="count_bottom">
                    Total Pengeluaran (Rp.)
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-6" style="display: inline-block;">
        <!-- Per Periode -->
        <div class="tile_count">
            <!-- Penjualan Produk -->
            <div class="col-md-4 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-shopping-cart"></i>&nbsp;
                    Pemasukkan Penjualan Produk
                </span>
                <div class="count green" style="font-size:30px;">
                    Rp. {{number_format($jml_pemasukkanper,2,',','.')}}
                </div>
                <span class="count_bottom">
                    Penjualan Produk (Periode
                    {{ Carbon\Carbon::now()->month }}/{{
                    Carbon\Carbon::now()->year }})
                </span>
            </div>
            <!-- Penjualan Custom -->
            <div class="col-md-4 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-filter"></i>&nbsp;
                    Pemasukkan Pemesanan Custom
                </span>
                <div class="count green" style="font-size:30px;">
                    Rp. {{number_format($jml_pemasukkancusper,2,',','.')}}
                </div>
                <span class="count_bottom">
                    Pemesanan Custom (Periode
                    {{ Carbon\Carbon::now()->month }}/{{
                    Carbon\Carbon::now()->year }})
                </span>
            </div>
            <!-- Pembelian -->
            <div class="col-md-4 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-inbox"></i>&nbsp;Transaksi Pembelian</span>
                <div class="count red" style="font-size:30px;">
                    Rp. {{number_format($jml_pengeluaranper,2,',','.')}}
                </div>
                <span class="count_bottom">
                    Pembelian Bahan (Periode
                    {{ Carbon\Carbon::now()->month }}/{{
                    Carbon\Carbon::now()->year }})
                </span>
            </div>
        </div>
        <!-- Keseluruhan -->
        <div class="tile_count">
            <!-- Penjualan Produk -->
            <div class="col-md-4 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-shopping-cart"></i>&nbsp;
                    Pemasukkan Penjualan Produk
                </span>
                <div class="count green" style="font-size:30px;">
                    Rp. {{number_format($jml_pemasukkan,2,',','.')}}
                </div>
                <span class="count_bottom">
                    Total Penjualan Produk
                </span>
            </div>
            <!-- Penjualan Custom -->
            <div class="col-md-4 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-filter"></i>&nbsp;
                    Pemasukkan Pemesanan Custom
                </span>
                <div class="count green" style="font-size:30px;">
                    Rp. {{number_format($jml_pemasukkancus,2,',','.')}}
                </div>
                <span class="count_bottom">
                    Total Pemesanan Custom
                </span>
            </div>
            <!-- Pembelian -->
            <div class="col-md-4 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-inbox"></i>&nbsp;Transaksi Pembelian</span>
                <div class="count red" style="font-size:30px;">
                    Rp. {{number_format($jml_pengeluaran,2,',','.')}}
                </div>
                <span class="count_bottom">
                    Pembelian Bahan
                </span>
            </div>
        </div>
    </div>
    <!-- Bawah -->
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Ringkasan Arus Keuangan</h2>
                    <!-- <div class="filter">
                        <div id="reportrange" class="pull-right"
                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                            <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                        </div>
                    </div> -->
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-6 col-sm-12 ">
                        <!-- Chart Kiri -->
                        <div id="overchartkiri" style="width:100%; height:400px;"></div>
                        <div class="tiles">
                            <div class="col-md-6 tile">
                                <span>Total Pemasukkan</span>
                                <h2>
                                    Rp. {{number_format($jml_pemasukkan+$jml_pemasukkancus,2,',','.')}}
                                </h2>
                            </div>
                            <div class="col-md-6 tile">
                                <span>Total Pengeluaran</span>
                                <h2>
                                    Rp. {{number_format($jml_pengeluaran,2,',','.')}}
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 ">
                        <!-- Chart Kanan -->
                        <div id="overchartkanan" style="width:100%; height:400px;"></div>
                        <div class="tiles">
                            <div class="col-md-6 tile">
                                <span>Total Pemasukkan</span>
                                <h2>
                                    Rp. {{number_format($jml_pemasukkanper+$jml_pemasukkancusper,2,',','.')}}
                                </h2>
                            </div>
                            <div class="col-md-6 tile">
                                <span>Total Pengeluaran</span>
                                <h2>
                                    Rp. {{number_format($jml_pengeluaranper,2,',','.')}}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Penjualan -->
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Transaksi Penjualan Masuk</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-12 col-sm-12 ">
                        <div class="card-box table-responsive">
                            <p class="text-muted font-13 m-b-30">
                                Data transaksi penjualan berisikan informasi daftar transaksi penjualan yang
                                tersimpan pada sistem, digunakan sebagai pencatatan data transaksi penjualan
                                produk yang masuk dalam sistem.
                            </p>
                            <!-- <table id="datatable-responsive" -->
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                cellspacing="0" width="100%" data-order='[[ 2, "asc" ]]'>
                                <thead>
                                    <tr>
                                        <th>Nama Pemesan</th>
                                        <th>Status Pesanan</th>
                                        <th>Batas Pengerjaan (Sisa)</th>
                                        <th>Last Updated (Selisih)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pageorders as $itemorders)
                                    <span hidden>{{ $now = Carbon\Carbon::now(); }}</span>
                                    <span hidden>
                                        {{
                                        $batas = $itemorders->created_at->addHours($deadline[0]->deadline)
                                        }}
                                    </span>
                                    @if($batas >= $now )
                                    <tr>
                                        <td>{{ $itemorders->first_name }}&nbsp;{{ $itemorders->last_name }}</td>
                                        <td style="text-transform:capitalize;">{{ $itemorders->status }}
                                            <span hidden>{{ $batas = 0; }}</span>
                                            <span hidden>{{ $selisih=0; }}</span>
                                        </td>
                                        <td>
                                            @if($itemorders->status == 'Menunggu Konfirmasi')
                                            {{ $batas = $itemorders->created_at->addHours($deadline[0]->deadline) }}
                                            @if($batas >= $now ) ({{$selisih=$batas->diffInHours(); }} Jam)
                                            @else
                                            ({{ $nol = 0; }} Jam) <br>
                                            <b>Telah Melewati Batas Deadline</b>
                                            @endif
                                            @else
                                            {{ $itemorders->status }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $itemorders->updated_at->diffForHumans([
                                            'parts' => 3,
                                            'join' => true,
                                            ])
                                            }}
                                        </td>
                                        <td>
                                            <a href="{{ route('transaksi_penjualan.show',[Crypt::encrypt($itemorders->id_orders)]) }}"
                                                class="btn btn-info btn-xs"><i class="fa fa-eye"></i>
                                                Detail </a>
                                        </td>
                                    </tr>
                                    @endif
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
    <!-- Penjualan Custom -->
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Transaksi Penjualan Custom Masuk</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-12 col-sm-12 ">
                        <div class="card-box table-responsive">
                            <p class="text-muted font-13 m-b-30">
                                Data transaksi penjualan custom berisikan informasi daftar transaksi penjualan
                                custom yang tersimpan pada sistem, digunakan sebagai pencatatan data transaksi
                                penjualan customasi desain produk sablon yang masuk dalam sistem.
                            </p>
                            <!-- <table id="datatable-responsive" -->
                            <table id="datatable-fixed-header"
                                class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                width="100%" data-order='[[ 3, "asc" ]]'>
                                <thead>
                                    <tr>
                                        <th>Nama Pemesan</th>
                                        <th>Request Desain</th>
                                        <th>Status Pesanan</th>
                                        <th>Batas Pengerjaan (Sisa)</th>
                                        <th>Last Updated (Selisih)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pagecustom as $itemcustom)
                                    <span hidden>{{ $now = Carbon\Carbon::now(); }}</span>
                                    <span hidden>
                                        {{
                                        $batas = $itemcustom->created_at->addHours($deadline[0]->deadline)
                                        }}
                                    </span>
                                    @if($batas >= $now )
                                    <tr>
                                        <td>{{ $itemcustom->first_name }}&nbsp;{{ $itemcustom->last_name }}</td>
                                        <td>Depan :
                                            <a href="{{asset('/data_file/custom/'.$itemcustom->pict_desain_depan)}}"
                                                target="_blank">
                                                {{$itemcustom->pict_desain_depan =
                                                Str::limit($itemcustom->pict_desain_depan, 15)}}
                                            </a><br>
                                            Belakang :
                                            <a href="{{asset('/data_file/custom/'.$itemcustom->pict_desain_belakang)}}"
                                                target="_blank">
                                                {{$itemcustom->pict_desain_belakang =
                                                Str::limit($itemcustom->pict_desain_belakang, 15)}}
                                            </a>
                                        </td>
                                        <td style="text-transform:capitalize;">{{ $itemcustom->status }}
                                            <span hidden>{{ $batas = 0; }}</span>
                                            <span hidden>{{ $selisih=0; }}</span>
                                        </td>
                                        <td>
                                            @if($itemcustom->status == 'Menunggu Konfirmasi')
                                            {{ $batas = $itemcustom->created_at->addHours($deadline[0]->deadline) }}
                                            @if($batas >= $now ) ({{$selisih=$batas->diffInHours(); }} Jam)
                                            @else
                                            ({{ $nol = 0; }} Jam) <br>
                                            <b>Telah Melewati Batas Deadline</b>
                                            @endif
                                            @else
                                            {{ $itemcustom->status }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $itemcustom->updated_at->diffForHumans([
                                            'parts' => 3,
                                            'join' => true,
                                            ])
                                            }}
                                        </td>
                                        <td>
                                            <a href="{{ route('transaksi_custom.show',[ Crypt::encrypt($itemcustom->id) ]) }}"
                                                class="btn btn-info btn-xs"><i class="fa fa-eye"></i>
                                                Detail </a>
                                        </td>
                                    </tr>
                                    @endif
                                    @empty
                                    <tr>
                                        <td colspan="6">Data Transaksi Custom Kosong</td>
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
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Eksport Laporan Keuangan</h2>
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
                                <form action="{{ route('pdflaporan.dashboard') }}" method="post" validate
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="field item form-group col-md-3 col-sm-3">
                                        <input type="date" name="dtawal" class="form-control has-feedback-left">
                                        <span class="fa fa-cloud form-control-feedback left" aria-hidden="true"></span>
                                    </div>
                                    <div class="field item form-group col-md-3 col-sm-3">
                                        <input type="date" name="dtakhir" class="form-control has-feedback-left">
                                        <span class="fa fa-cloud form-control-feedback left" aria-hidden="true"></span>
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
    <br>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    // Charts Overal Kiri
    Highcharts.chart('overchartkiri', {
        chart: {
            type: 'column'
        },
        title: {
            align: 'center',
            text: 'Diagram Pemasukkan dan Pengeluaran'
        },
        subtitle: {
            align: 'center',
            text: 'Seluruh Periode'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Nilai IDR (Rp.)'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: 'Rp.{point.y:.1f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>Rp. {point.y:.2f}</b> of total<br/>'
        },

        series: [{
            name: "Details",
            colorByPoint: true,
            data: [{
                    name: "Penjualan Produk</br>({{ $jml_trxorder }} Transaksi)",
                    y: parseInt("{{ $jml_pemasukkan }}"),
                    drilldown: "Penjualan Produk",
                    color: 'blue'
                },
                {
                    name: "Pemesanan Custom</br>({{ $jml_trxcustom }} Transaksi)",
                    y: parseInt("{{ $jml_pemasukkancus }}"),
                    drilldown: "Pemesanan Custom",
                    color: 'green'
                },
                {
                    name: "Pembelian Material</br>({{ $jml_trxpembelian }} Transaksi)",
                    y: parseInt("{{ $jml_pengeluaran }}"),
                    drilldown: "Pembelian Material",
                    color: 'red'
                }
            ]
        }],
    });
    // Chart Overal Kanan Per Periode
    Highcharts.chart('overchartkanan', {
        chart: {
            type: 'column'
        },
        title: {
            align: 'center',
            text: 'Diagram Pemasukkan dan Pengeluaran'
        },
        subtitle: {
            align: 'center',
            text: 'Periode {{ Carbon\Carbon::now()->month }}/{{ Carbon\Carbon::now()->year }}'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Nilai IDR (Rp.)'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: 'Rp.{point.y:.1f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>Rp. {point.y:.2f}</b> of total<br/>'
        },

        series: [{
            name: "Details",
            colorByPoint: true,
            data: [{
                    name: "Penjualan Produk</br>({{ $jml_trxorderper }} Transaksi)",
                    y: parseInt("{{ $jml_pemasukkanper }}"),
                    drilldown: "Penjualan Produk",
                    color: 'blue'
                },
                {
                    name: "Pemesanan Custom</br>({{ $jml_trxcustomper }} Transaksi)",
                    y: parseInt("{{ $jml_pemasukkancusper }}"),
                    drilldown: "Pemesanan Custom",
                    color: 'green'
                },
                {
                    name: "Pembelian Material</br>({{ $jml_trxpembelianper }} Transaksi)",
                    y: parseInt("{{ $jml_pengeluaranper }}"),
                    drilldown: "Pembelian Material",
                    color: 'red'
                }
            ]
        }],
    });
</script>
@endsection