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
                    <a href="#">Data Produksi Custom</a>&nbsp;
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Data Produksi Custom</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="/produksi/create">Tambah Data</a>
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
                                        Data produksi custom merupakan data produksi transaksi penjualan customasi
                                        desain produk sablon yang tersimpan pada sistem, dengan status pengerjaan baik
                                        yang sedang menunggu, diproses, ataupun yang sudah selesai dalam proses produksi
                                        tersebut.
                                    </p>
                                    <Strong>
                                        <Small>
                                            Note: Tombol selesai akan mengupdate status semua proses menjadi selesai
                                            sesuai dengan nomor order yang dipilih
                                        </Small>
                                    </Strong>
                                    <table id="datatable-responsive"
                                        class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>No Id</th>
                                                <th>Nama Customer</th>
                                                <th>Jumlah Beli</th>
                                                <th>Status Produksi</th>
                                                <th>Nama Proses Produksi</th>
                                                <th>Estimasi (Jam)</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Selesai</th>
                                                <th>Persentase</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($page as $item)
                                            <tr>
                                                <td>{{ $item->customs_id }}</td>
                                                <td style="text-transform:capitalize;">
                                                    {{ $item->nama_depan }}&nbsp;
                                                    {{ $item->nama_belakang }}</td>
                                                <td style="text-transform:uppercase;">{{ $item->qty }}</td>
                                                <td style="text-transform:uppercase;">{{ $item->status}}</td>
                                                <td style="text-transform:uppercase;">{{ $item->status_produksi}}
                                                </td>
                                                <td style="text-transform:uppercase;">{{ $item->estimasi}} Jam</td>
                                                <td style="text-transform:uppercase;">{{ $item->tanggal_mulai}}</td>
                                                <td style="text-transform:uppercase;">{{ $item->tanggal_selesai}}
                                                </td>
                                                <td>
                                                    <span hidden>
                                                        {{ $sekarang = Carbon\Carbon::now(); }}
                                                        {{ $selisih = Carbon\Carbon::parse($item->tanggal_selesai)
                                                        ->diffInMinutes(); }}
                                                        {{ $estimasi = $item->estimasi*60; }}
                                                        {{ $atas = $estimasi-$selisih; }}
                                                        {{ $persen = ($atas/$estimasi)*100; }}
                                                    </span>
                                                    @if($sekarang < $item->tanggal_selesai && $persen >= 0 &&
                                                        $item->status != "Selesai")
                                                        <div class="progress progress_sm">
                                                            <div class="progress-bar bg-green" role="progressbar"
                                                                data-transitiongoal="{{ round($persen,2) }}">
                                                            </div>
                                                        </div>
                                                        <small>
                                                            {{ round($persen,2) }}%
                                                        </small>
                                                        @elseif(($sekarang > $item->tanggal_selesai &&
                                                        $item->tanggal_selesai != null) || $item->status == "Selesai")
                                                        SELESAI
                                                        @else
                                                        0
                                                        @endif
                                                        <span hidden>
                                                            {{ $selisih = 0; }}
                                                            {{ $estimasi = 0; }}
                                                            {{ $atas = 0; }}
                                                            {{ $persen = 0; }}
                                                        </span>
                                                </td>
                                                <td>
                                                    <a id="drop4" href="#" class="dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true" role="button"
                                                        aria-expanded="false">
                                                        Aksi
                                                        <span class="caret"></span>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @if($item->status == "Menunggu")
                                                        <a href="/produksi_custom/start/{{ $item->customs_id }}"
                                                            class="dropdown-item"><i class="fa fa-play"></i>
                                                            Mulai Produksi
                                                        </a>
                                                        @elseif($item->status == "Diproses")
                                                        <a href="/produksi_custom/done/{{ $item->customs_id }}"
                                                            class="dropdown-item"><i class="fa fa-play"></i>
                                                            Selesai Produksi
                                                        </a>
                                                        <a href="/produksi_custom/proses/done/{{ $item->id_produksi }}"
                                                            class="dropdown-item"><i class="fa fa-play"></i>
                                                            Selesai Proses
                                                        </a>
                                                        @if($item->status == "Diproses" &&
                                                        $item->tanggal_mulai > $waktusekarang)
                                                        <a href="/produksi_custom/proses/start/{{ $item->id_produksi }}"
                                                            class="dropdown-item"><i class="fa fa-play"></i>
                                                            Mulai Proses
                                                        </a>
                                                        <a href="/produksi_custom/status/pause/{{ $item->id_produksi }}"
                                                            class="dropdown-item"><i class="fa fa-pause"></i>
                                                            Berhenti Proses
                                                        </a>
                                                        @elseif($item->status == "Diproses" &&
                                                        $item->tanggal_mulai == null)
                                                        <a href="/produksi_custom/proses/start/{{ $item->id_produksi }}"
                                                            class="dropdown-item"><i class="fa fa-play"></i>
                                                            Mulai Proses
                                                        </a>
                                                        @else
                                                        <a href="/produksi_custom/status/pause/{{ $item->id_produksi }}"
                                                            class="dropdown-item"><i class="fa fa-pause"></i>
                                                            Berhenti Proses
                                                        </a>
                                                        <a href="/produksi_custom/proses/pause/{{ $item->customs_id }}"
                                                            class="dropdown-item"><i class="fa fa-pause"></i>
                                                            Berhenti Produksi
                                                        </a>
                                                        @endif
                                                        @elseif($item->status == "Selesai")
                                                        <a href="/produksi_custom/start/{{ $item->customs_id }}"
                                                            class="dropdown-item"><i class="fa fa-play"></i>
                                                            Ulangi Produksi
                                                        </a>
                                                        @else
                                                        <!--  -->
                                                        @endif
                                                        <a href="{{ route('produksi_custom.show',[$item->customs_id]) }}"
                                                            target="_blank" class="dropdown-item">
                                                            <i class="fa fa-eye"></i>
                                                            Detail
                                                        </a>
                                                    </div>

                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="10">Data Produksi Kosong</td>
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