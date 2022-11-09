@extends('customer.layouts.app')
<!-- <meta http-equiv="refresh" content="10"> -->
@section('title')
{{ $title }}
@endsection
@section('content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Tracking your order</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Tracking your order</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Tracking Box Area =================-->
<section class="tracking_box_area section_gap">
    <div class="container">
        <h2>Tracking your order</h2>
        <div class="section-top-border">
            <div class="row">
                <div class="col-lg-12">
                    <blockquote class="generic-blockquote">
                        <div class="row order_d_inner">
                            <div class="col-lg-4">
                                <div class="details_item">
                                    <h4>Order Info</h4>
                                    <ul class="list">
                                        <li><a href="#"><span>Order number</span>&nbsp;:
                                                @if($orders[0]->id_orders)
                                                {{ $orders[0]->id_orders }}
                                                @elseif($orders[0]->id_customs)
                                                {{ $orders[0]->id_customs }}
                                                @endif
                                            </a>
                                        </li>
                                        <li><a href="#"><span>Date</span>&nbsp;:
                                                {{ $orders[0]->date }}
                                            </a>
                                        </li>
                                        <li><a href="#"><span>Last Update</span>&nbsp;:
                                                {{ $orders[0]->updated_at }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="details_item">
                                    <h4>Status Transaksi</h4>
                                    <ul class="list">
                                        <li><a href="#" style="text-transform:capitalize;">
                                                <span>
                                                    Status Pemesanan
                                                </span>&nbsp;:
                                                {{ $orders[0]->status }}
                                            </a>
                                        </li>
                                        <li><a href="#" style="text-transform:capitalize;">
                                                <span>
                                                    Status Pembayaran
                                                </span>&nbsp;:
                                                @if($orders[0]->status_payment == null)
                                                Belum Melakukan Pembayaran</a>
                                            @else
                                            {{ $orders[0]->status_payment }}</a>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="details_item">
                                    <h4>Alamat Pengiriman</h4>
                                    <ul class="list">
                                        <li><a href="#"><span>Alamat</span>&nbsp;:<br>
                                                "{{ $orders[0]->address }},
                                                {{ $orders[0]->districts }},
                                                {{ $orders[0]->ward }},
                                                {{ $orders[0]->city }},
                                                {{ $orders[0]->province }}"
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row order_d_inner">
                            <div class="col-lg-12">
                                <div class="details_item">
                                    <h4 class="mb-0">Status Progress Produksi</h4>
                                    <div class="progress-table" style="background-color:transparent;">
                                        <div class="progress-table" style="background-color:transparent;">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Nama Proses</th>
                                                        <th scope="col">Waktu Proses</th>
                                                        <th scope="col">Estimasi Waktu Selesai</th>
                                                        <th scope="col">Bobot</th>
                                                        <th scope="col" width="25%">Persentase</th>
                                                        <th scope="col" width="3%">(%)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($produksi as $isi)
                                                    @if($isi->status != 'Selesai')
                                                    <tr>
                                                        <td style="text-transform:uppercase;">
                                                            {{ $isi->status_produksi }}
                                                        </td>
                                                        <td>
                                                            {{ $isi->tanggal_mulai }}
                                                        </td>
                                                        <td>
                                                            {{ $isi->tanggal_selesai }}
                                                        </td>
                                                        <td>
                                                            {{
                                                            number_format(($isi->estimasi/$datatotal_estimasi)*100,
                                                            2, '.', '');
                                                            }}%
                                                        </td>
                                                        <span hidden>
                                                            @if($isi->tanggal_selesai != null)
                                                            {{ $sekarang = Carbon\Carbon::now(); }}
                                                            {{ $selisih = Carbon\Carbon::parse($isi->tanggal_selesai)
                                                            ->diffInMinutes(); }}
                                                            {{ $estimasi = $isi->estimasi*60; }}
                                                            {{ $atas = $estimasi-$selisih; }}
                                                            {{ $persen = ($atas/$estimasi)*100; }}
                                                            @else
                                                            {{ $persen = 0; }}
                                                            @endif
                                                        </span>
                                                        <td>
                                                            @if($isi->tanggal_selesai)
                                                            @if($sekarang > $isi->tanggal_selesai)
                                                            <div class="progress-bar color-4" role="progressbar"
                                                                style="width: 100%" aria-valuenow="100"
                                                                aria-valuemin="0" aria-valuemax="100"
                                                                style="height:10px;line-height:10px;">
                                                                100
                                                            </div>
                                                            @elseif($persen <= 0) <div class="progress-bar color-1"
                                                                role="progressbar" style="width: 0%" aria-valuenow="0"
                                                                aria-valuemin="0" aria-valuemax="100">0
                                        </div>
                                        @elseif($persen >= 21 || 40 >= $persen) <div class="progress-bar color-2"
                                            role="progressbar" style="width: {{ $persen }}%"
                                            aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100">{{
                                            $persen }}
                                        </div>
                                        @elseif($persen >= 41 || 60 >=$persen) <div class="progress-bar color-3 "
                                            role="progressbar" style="width: {{ $persen }}%"
                                            aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100">{{
                                            $persen }}
                                        </div>
                                        @else
                                        <div class="progress-bar color-3" role="progressbar"
                                            style="width: {{ $persen }}%" aria-valuenow="{{ $persen }}"
                                            aria-valuemin="0" aria-valuemax="100">{{ $persen }}
                                        </div>
                                        @endif
                                        @endif
                                        </td>
                                        <td>
                                            @if($persen <= 0) <strong>
                                                0%
                                                </strong>
                                                @else
                                                <strong>
                                                    {{ $persen }}%
                                                </strong>
                                                @endif
                                        </td>
                                        <span hidden>
                                            {{ $selisih = 0; }}
                                            {{ $estimasi = 0; }}
                                            {{ $atas = 0; }}
                                            {{ $persen = 0; }}
                                        </span>
                                        </tr>
                                        @elseif($isi->tanggal_mulai != null && $isi->tanggal_selesai != null)
                                        <tr>
                                            <td style="text-transform:uppercase;">
                                                {{ $isi->status_produksi }}
                                            </td>
                                            <td>
                                                {{ $isi->tanggal_mulai }}
                                            </td>
                                            <td>
                                                {{ $isi->tanggal_selesai }}
                                            </td>
                                            <td>
                                                {{
                                                number_format(($isi->estimasi/$datatotal_estimasi)*100,
                                                2, '.', '');
                                                }}%
                                            </td>
                                            <td>Selesai</td>
                                            <td>Selesai</td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td style="text-transform:uppercase;">
                                                {{ $isi->status_produksi }}
                                            </td>
                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>
                                            <td>
                                                {{
                                                number_format(($isi->estimasi/$datatotal_estimasi)*100,
                                                2, '.', '');
                                                }}%
                                            </td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                        @endif
                                        @empty
                                        <tr>
                                            <td colspan="6">Pesanan Anda sedang tidak di produksi</td>
                                        </tr>
                                        @endforelse
                                        @if(($total_persen != null || $total_persen != 0 )&&
                                        $orders[0]->status == 'Proses Produksi')
                                        <tr>
                                            <td colspan="6">Total Penyelesaian Produksi Transaksi (%):
                                                <strong>
                                                    {{ number_format($total_persen, 2, '.', ''); }}&nbsp;%
                                                </strong>
                                            </td>
                                        </tr>
                                        @endif
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </blockquote>
                <div class="float-left">
                    @if(auth()->user())
                    @if(auth()->user()->role == "user")
                    <a href="/history" class="btn btn-primary"><span class="fa fa-arrow-left"></span>&nbsp;Kembali</a>
                    @elseif(auth()->user()->role == "admin")
                    <a href="/admin" class="btn btn-primary"><span class="fa fa-arrow-left"></span>&nbsp;Kembali</a>
                    @else
                    <a href="/" class="btn btn-primary"><span class="fa fa-arrow-left"></span>&nbsp;Kembali</a>
                    @endif
                    @else
                    <a href="/" class="btn btn-primary"><span class="fa fa-arrow-left"></span>&nbsp;Kembali</a>
                    @endif
                    <button class="btn btn-primary" onClick="window.location.reload();">
                        <span class="fa fa-refresh"></span>
                        Refresh Page
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!--================End Tracking Box Area =================-->
@endsection