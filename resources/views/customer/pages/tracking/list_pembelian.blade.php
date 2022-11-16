@extends('customer.layouts.app_custom')
@section('title')
{{ $title }}
@endsection
@section('style')
<style>
    .baru .nice-select {
        -webkit-tap-highlight-color: transparent;
        background-color: #fff;
        border-radius: 5px;
        border: solid 1px #e8e8e8;
        box-sizing: border-box;
        clear: both;
        cursor: pointer;
        display: block;
        float: left;
        font-family: inherit;
        font-size: 14px;
        font-weight: normal;
        height: 42px;
        line-height: 40px;
        outline: none;
        padding-left: 18px;
        padding-right: 30px;
        position: relative;
        text-align: left !important;
        -webkit-transition: all 0.2s ease-in-out;
        transition: all 0.2s ease-in-out;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        white-space: nowrap;
        width: auto;
    }

    .baru .nice-select:hover {
        border-color: #dbdbdb;
    }

    .baru .nice-select:active,
    .baru .nice-select.open,
    .baru .nice-select:focus {
        border-color: #999;
    }

    .baru .nice-select:after {
        border-bottom: 2px solid #999;
        border-right: 2px solid #999;
        content: '';
        display: block;
        height: 5px;
        margin-top: -4px;
        pointer-events: none;
        position: absolute;
        right: 12px;
        top: 50%;
        -webkit-transform-origin: 66% 66%;
        -ms-transform-origin: 66% 66%;
        transform-origin: 66% 66%;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
        -webkit-transition: all 0.15s ease-in-out;
        transition: all 0.15s ease-in-out;
        width: 5px;
    }

    .baru .nice-select.open:after {
        -webkit-transform: rotate(-135deg);
        -ms-transform: rotate(-135deg);
        transform: rotate(-135deg);
    }

    .baru .nice-select.open .list {
        opacity: 1;
        pointer-events: auto;
        -webkit-transform: scale(1) translateY(0);
        -ms-transform: scale(1) translateY(0);
        transform: scale(1) translateY(0);
    }

    .baru .nice-select.disabled {
        border-color: #ededed;
        color: #999;
        pointer-events: none;
    }

    .baru .nice-select.disabled:after {
        border-color: #cccccc;
    }

    .baru .nice-select.wide {
        width: 100%;
    }

    .baru .nice-select.wide .list {
        left: 0 !important;
        right: 0 !important;
    }

    .baru .nice-select.right {
        float: right;
    }

    .baru .nice-select.right .list {
        left: auto;
        right: 0;
    }

    .baru .nice-select.small {
        font-size: 12px;
        height: 36px;
        line-height: 34px;
    }

    .baru .nice-select.small:after {
        height: 4px;
        width: 4px;
    }

    .baru .nice-select.small .option {
        line-height: 34px;
        min-height: 34px;
    }

    .baru .nice-select .list {
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 0 1px rgba(68, 68, 68, 0.11);
        box-sizing: border-box;
        margin-top: 4px;
        opacity: 0;
        overflow: hidden;
        padding: 0;
        pointer-events: none;
        position: absolute;
        top: 100%;
        left: 0;
        -webkit-transform-origin: 50% 0;
        -ms-transform-origin: 50% 0;
        transform-origin: 50% 0;
        -webkit-transform: scale(0.75) translateY(-21px);
        -ms-transform: scale(0.75) translateY(-21px);
        transform: scale(0.75) translateY(-21px);
        -webkit-transition: all 0.2s cubic-bezier(0.5, 0, 0, 1.25), opacity 0.15s ease-out;
        transition: all 0.2s cubic-bezier(0.5, 0, 0, 1.25), opacity 0.15s ease-out;
        z-index: 9;
    }

    .baru .nice-select .list:hover .option:not(:hover) {
        background-color: transparent !important;
    }

    .baru .nice-select .option {
        cursor: pointer;
        font-weight: 400;
        line-height: 40px;
        list-style: none;
        min-height: 40px;
        outline: none;
        padding-left: 18px;
        padding-right: 29px;
        text-align: left;
        -webkit-transition: all 0.2s;
        transition: all 0.2s;
    }

    .baru .nice-select .option:hover,
    .baru .nice-select .option.focus,
    .baru .nice-select .option.selected.focus {
        background-color: #f6f6f6;
    }

    .baru .nice-select .option.selected {
        font-weight: bold;
    }

    .baru .nice-select .option.disabled {
        background-color: transparent;
        color: #999;
        cursor: default;
    }

    .baru .no-csspointerevents .nice-select .list {
        display: none;
    }

    .baru .no-csspointerevents .nice-select.open .list {
        display: block;
    }
</style>
@endsection
@section('content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Daftar Transaksi</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Daftar Transaksi</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Tracking Box Area =================-->
<section class="tracking_box_area section_gap">
    <!-- Transaksi Custom -->
    <div class="container">
        <h2>Daftar Transaksi Custom&nbsp;{{ $tambahanc }}</h2>
        <div class="filter-bar d-flex flex-wrap align-items-center">
            <div class="baru">
                <div class="sorting">
                    <select onchange="if (this.value) window.location.href=this.value">
                        <option value="" selected disabled>-- Filter --</option>
                        <option value="/history?waktuc=desc">Urutkan Transaksi Baru -> Lama</option>
                        <option value="/history?waktuc=asc">Urutkan Transaksi Lama -> Baru</option>
                    </select>
                </div>
            </div>
            <div class="sorting mr-auto"> </div>
            <div class="pagination">
                @if($customs->total() > 3)
                <!-- Mantab -->
                {{ $customs->onEachSide(1)->links() }}
                @else
                <a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
                <a href="#" class="active">1</a>
                <a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                @endif
            </div>
        </div>
        <div class="section-top-border">
            <div class="row">
                <div class="col-lg-12">
                    @forelse ($customs as $items)
                    <blockquote class="generic-blockquote">
                        <div class="row order_d_inner">
                            <div class="col-lg-4">
                                <div class="details_item">
                                    <h4>Order Info</h4>
                                    <ul class="list">
                                        <li><a href="#"><span>Order number</span>&nbsp;:
                                                {{ $items->id_custom }}</a></li>
                                        <li><a href="#"><span>Date</span>&nbsp;:
                                                {{ $items->date }}</a></li>
                                        <li><a href="#"><span>Last Update</span>&nbsp;:
                                                {{ $items->updated_at }}</a></li>
                                        <li><a href="#"><span>UMKM Name:</span>&nbsp;:
                                                {{ $items->umkm_name }}</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="details_item">
                                    <h4>Status Transaksi</h4>
                                    <ul class="list">
                                        <li><a href="#" style="text-transform:capitalize;">
                                                <span hidden>
                                                    {{ $tanggal = Carbon\Carbon::parse($items->created_at); }}
                                                    {{ $batas = $tanggal->addHours($items->deadline); }}
                                                    {{ $waktusekarang = Carbon\Carbon::now(); }}
                                                </span>
                                                <span>
                                                    Status Pemesanan
                                                </span>&nbsp;:
                                                @if($batas < $waktusekarang && $items->status ==
                                                    "Menunggu Konfirmasi")
                                                    Pesanan Anda Melewati Batas Deadline
                                                    @else
                                                    {{ $items->status }}
                                                    @endif
                                            </a>
                                        </li>
                                        <li><a href="#" style="text-transform:capitalize;">
                                                <span>
                                                    Status Pembayaran
                                                </span>&nbsp;:
                                                @if($batas < $waktusekarang && $items->status ==
                                                    "Menunggu Konfirmasi")
                                                    Pesanan Anda Melewati Batas Deadline
                                                    @else
                                                    <span>
                                                        @if($items->status_payment == null)
                                                        Belum Melakukan Pembayaran</a>
                                            @else
                                            {{ $items->status_payment }}</a>
                                            @endif
                                            </span>
                                            @endif
                                        </li>
                                        <span hidden>
                                            {{ $tanggal = 0; }}
                                            {{ $batas = 0; }}
                                            {{ $waktusekarang = 0; }}
                                        </span>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="details_item">
                                    <h4>Alamat Pengiriman</h4>
                                    <ul class="list">
                                        <li><a href="#"><span>Alamat</span>&nbsp;:<br>
                                                "{{ $items->address }},
                                                {{ $items->districts }},
                                                {{ $items->ward }},
                                                {{ $items->city }},
                                                {{ $items->province }}"</a></li>
                                    </ul>
                                    <a class="primary-btn" data-toggle="modal"
                                        data-target="#detailmodalcustom{{ $items->id_custom }}"
                                        style="color:white;">Lihat
                                        Detail</a>
                                </div>
                            </div>
                        </div>
                    </blockquote>
                    <div id="detailmodalcustom{{ $items->id_custom }}" class="modal fade" role="dialog"
                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                            style="max-width:1250px">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Detail Transaksi</h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="row order_d_inner">
                                        <div class="col-lg-4">
                                            <div class="details_item">
                                                <h4>Order Info</h4>
                                                <ul class="list">
                                                    <li><a href="{{ route('contact.show',[$items->id_umkm]) }}"
                                                            target="_blank">
                                                            <span>Order number (Nama UMKM)</span>&nbsp;:
                                                            {{ $items->id_custom }}&nbsp;({{ $items->umkm_name }})</a>
                                                    </li>
                                                    <li><a href="#"><span>Tanggal Pemesanan</span>&nbsp;:
                                                            {{ $items->date }}
                                                        </a>
                                                    </li>
                                                    <li><a href="#"><span>Last Updated</span>&nbsp;:
                                                            {{ $items->updated_at }}
                                                        </a>
                                                    </li>
                                                    <li><a href="#">
                                                            <span>Nomor Resi Pengiriman
                                                            </span>&nbsp;:({{ $items->shipping }})
                                                            <strong>{{ Str::limit($items->no_resi, 15) }}</strong>
                                                        </a>
                                                    </li>
                                                    <li><a href="#"><span>UMKM Name:</span>&nbsp;:
                                                            {{ $items->umkm_name }}
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
                                                            <span hidden>
                                                                {{ $tanggal = Carbon\Carbon::parse($items->created_at);
                                                                }}
                                                                {{ $batas = $tanggal->addHours($items->deadline); }}
                                                                {{ $waktusekarang = Carbon\Carbon::now(); }}
                                                            </span>
                                                            <span>
                                                                Status Pemesanan
                                                            </span>&nbsp;:
                                                            @if($batas < $waktusekarang && $items->status ==
                                                                "Menunggu Konfirmasi")
                                                                Pesanan Anda Melewati Batas Deadline
                                                                @else
                                                                {{ $items->status }}

                                                                @endif
                                                        </a>
                                                    </li>
                                                    <li><a href="#" style="text-transform:capitalize;">
                                                            <span>
                                                                Status Pembayaran
                                                            </span>&nbsp;:
                                                            @if($batas < $waktusekarang && $items->status ==
                                                                "Menunggu Konfirmasi")
                                                                Pesanan Anda Melewati Batas Deadline
                                                                @else
                                                                <span>
                                                                    @if($items->status_payment == null)
                                                                    Belum Melakukan Pembayaran</a>
                                                        @else
                                                        {{ $items->status_payment }}</a>
                                                        @endif
                                                        </span>
                                                        @endif
                                                    </li>
                                                    <span hidden>
                                                        {{ $tanggal = 0; }}
                                                        {{ $batas = 0; }}
                                                        {{ $waktusekarang = 0; }}
                                                    </span>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="details_item">
                                                <h4>Alamat Pengiriman</h4>
                                                <ul class="list">
                                                    <li><a href="#"><span>Alamat</span>&nbsp;:<br>
                                                            "{{ $items->address }},
                                                            {{ $items->districts }},
                                                            {{ $items->ward }},
                                                            {{ $items->city }},
                                                            {{ $items->province }}"</a>
                                                    </li>
                                                    <li><a href="#"><span>Feedback</span>&nbsp;:<br>
                                                            "{{ $items->feedback_customs }}"</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row order_d_inner">
                                        <div class="col-lg-4">
                                            <div class="details_item">
                                                <h4>Order Info</h4>
                                                <ul class="list">
                                                    <li><a href="#"><span>Nama Pemesan</span>&nbsp;:
                                                            {{ $items->first_name }}&nbsp;{{ $items->last_name }}</a>
                                                    </li>
                                                    <li><a href="#"><span>Total</span>&nbsp;:
                                                            Rp. {{number_format($items->total,2,',','.')}}</a></li>
                                                    <li><a href="{{asset('/data_file/custom/'.$items->pict_desain_depan)}}"
                                                            target="_blank"><span>Desain Custom</span>&nbsp;:
                                                            <br>
                                                            Tampak Depan&nbsp;: {{ $items->pict_desain_depan =
                                                            Str::limit($items->pict_desain_depan, 15) }} <br>
                                                        </a>
                                                        <a href="{{asset('/data_file/custom/'.$items->pict_desain_belakang)}}"
                                                            target="_blank">
                                                            Tampak Belakang&nbsp;: {{ $items->pict_desain_belakang =
                                                            Str::limit($items->pict_desain_belakang, 15) }}
                                                        </a>
                                                    </li>
                                                    @if($items->pict_payment)
                                                    <li><a href="{{asset('/data_file/pembayaran/'.$items->pict_payment)}}"
                                                            target="_blank"><span>Bukti Pembayaran</span>&nbsp;:
                                                            {{ $items->pict_payment =
                                                            Str::limit($items->pict_payment, 15) }}
                                                        </a>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-8" style="background-color:transparent;">
                                            <div class="details_item" style="background-color:transparent;">
                                                <h4 class="mb-0">Status Pengerjaan</h4>
                                                <div class="progress-table" style="background-color:transparent;">
                                                    @if($items->status == "Menunggu Konfirmasi")
                                                    <div class="progress-table" style="background-color:transparent;">
                                                        <div class="list">
                                                            <p>Pesanan sedang menunggu konfirmasi</p>
                                                        </div>
                                                    </div>
                                                    @elseif($items->status == "Menunggu Pembayaran")
                                                    <div class="progress-table" style="background-color:transparent;">
                                                        <div class="list">
                                                            <p>Pesanan belum dibayar</p>
                                                        </div>
                                                    </div>
                                                    @elseif($items->status == "Menunggu Konfirmasi Pembayaran")
                                                    <div class="progress-table" style="background-color:transparent;">
                                                        <div class="list">
                                                            <p>Pembayaran belum dikonfirmasi</p>
                                                        </div>
                                                    </div>
                                                    @elseif($items->status == "Menunggu Proses Produksi")
                                                    <div class="progress-table" style="background-color:transparent;">
                                                        <div class="list">
                                                            <p>Menunggu Proses Produksi</p>
                                                        </div>
                                                    </div>
                                                    @elseif($items->status == "Pesanan Ditolak")
                                                    <div class="progress-table" style="background-color:transparent;">
                                                        <div class="list">
                                                            <p>Pesanan Anda Ditolak</p>
                                                        </div>
                                                    </div>
                                                    @elseif($items->status == "Selesai")
                                                    <div class="progress-table" style="background-color:transparent;">
                                                        <div class="list">
                                                            <p>Pesanan Anda Telah Selesai</p>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <form action="{{ route('track.customs') }}" method="post"
                                                        id="trackcustom{{$items->id_custom}}" class="form"
                                                        novalidate="novalidate" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="text" name="id"
                                                            value="{{ $items->date }}/{{ $items->id_custom }}" hidden>
                                                        <a href="javascript:{}"
                                                            onclick="document.getElementById('trackcustom{{ $items->id_custom }}').submit(); return false;">
                                                            Klik Disini...
                                                        </a>
                                                    </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    @if($items->status_payment == "Menunggu Pembayaran" ||
                                    $items->status_payment == "Ditangguhkan")
                                    <a href="/custom/bayar/{{ Crypt::encrypt($items->id_custom) }}"
                                        class="btn btn-success">
                                        Bayar Sekarang
                                    </a>
                                    @endif
                                    @if($items->status_payment == "Lunas")
                                    <a href="/custom/invoice/{{ Crypt::encrypt($items->id_custom) }}" target="_blank"
                                        class="btn btn-success">
                                        Cek Invoice
                                    </a>
                                    @endif
                                    @if($items->status_payment == "Lunas" && $items->status == "Selesai")
                                    <a href="{{ route('custom.show', Crypt::encrypt($items->id_custom)) }}"
                                        class="btn btn-success">
                                        Feedback
                                    </a>
                                    @endif
                                    @if($items->status == "Ditolak" || $items->status == "Selesai")
                                    <a href="https://wa.me/{{ $items->nomor_umkm }}" target="_blank"
                                        class="btn btn-success">
                                        Hubungi Admin
                                    </a>
                                    @endif
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <blockquote class="generic-blockquote">
                        <div class="row order_d_inner">
                            <div class="col-lg-12">
                                <div class="details_item">
                                    <h4>Order Info</h4>
                                    <ul class="list">
                                        <li>Anda belum melakukan transaksi</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </blockquote>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <!-- Transaksi Penjualan -->
    <div class="container">
        <h2>Daftar Transaksi&nbsp;{{ $tambahan }}</h2>
        <div class="filter-bar d-flex flex-wrap align-items-center">
            <div class="baru">
                <div class="sorting">
                    <select onchange="if (this.value) window.location.href=this.value">
                        <option value="" selected disabled>-- Filter --</option>
                        <option value="/history?waktu=desc">Urutkan Transaksi Baru -> Lama</option>
                        <option value="/history?waktu=asc">Urutkan Transaksi Lama -> Baru</option>
                    </select>
                </div>
            </div>
            <div class="sorting mr-auto"> </div>
            <div class="pagination">
                @if($page->total() > 3)
                <!-- Mantab -->
                {{ $page->onEachSide(1)->links() }}
                @else
                <a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
                <a href="#" class="active">1</a>
                <a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                @endif
            </div>
        </div>
        <div class="section-top-border">
            <div class="row">
                <div class="col-lg-12">
                    @forelse ($page as $item)
                    <blockquote class="generic-blockquote">
                        <div class="row order_d_inner">
                            <div class="col-lg-4">
                                <div class="details_item">
                                    <h4>Order Info</h4>
                                    <ul class="list">
                                        <li><a href="#"><span>Order number</span>&nbsp;:
                                                {{ $item->id_orders }}
                                            </a>
                                        </li>
                                        <li><a href="#"><span>Date</span>&nbsp;:
                                                {{ $item->date }}
                                            </a>
                                        </li>
                                        <li><a href="#"><span>Last Update</span>&nbsp;:
                                                {{ $item->updated_at }}
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
                                                <span hidden>
                                                    {{ $tanggal = Carbon\Carbon::parse($item->jam_masuk); }}
                                                    {{ $batas = $tanggal->addHours($item->deadline); }}
                                                    {{ $waktusekarang = Carbon\Carbon::now(); }}
                                                </span>
                                                <span>
                                                    Status Pemesanan
                                                </span>&nbsp;:
                                                @if($batas < $waktusekarang && $item->status ==
                                                    "Menunggu Konfirmasi")
                                                    Pesanan Anda Melewati Batas Deadline
                                                    @else
                                                    {{ $item->status }}
                                                    @endif
                                            </a>
                                        </li>
                                        <li><a href="#" style="text-transform:capitalize;">
                                                <span>
                                                    Status Pembayaran
                                                </span>&nbsp;:
                                                @if($batas < $waktusekarang && $item->status ==
                                                    "Menunggu Konfirmasi")
                                                    Pesanan Anda Melewati Batas Deadline
                                                    @else
                                                    <span>
                                                        @if($item->status_payment == null)
                                                        Belum Melakukan Pembayaran
                                            </a>
                                            @else
                                            {{ $item->status_payment }}
                                            </a>
                                            @endif
                                            </span>
                                            @endif
                                        </li>
                                        <span hidden>
                                            {{ $tanggal = 0; }}
                                            {{ $batas = 0; }}
                                            {{ $waktusekarang = 0; }}
                                        </span>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="details_item">
                                    <h4>Alamat Pengiriman</h4>
                                    <ul class="list">
                                        <li><a href="#"><span>Alamat</span>&nbsp;:<br>
                                                "{{ $item->address }},
                                                {{ $item->districts }},
                                                {{ $item->ward }},
                                                {{ $item->city }},
                                                {{ $item->province }}"
                                            </a>
                                        </li>
                                    </ul>
                                    <a class="primary-btn" data-toggle="modal"
                                        data-target="#detailmodal{{ $item->id_orders }}" style="color:white;">Lihat
                                        Detail</a>
                                </div>
                            </div>
                        </div>
                    </blockquote>
                    <div id="detailmodal{{ $item->id_orders }}" class="modal fade" role="dialog"
                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                            style="max-width:1140px">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Detail Transaksi</h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="row order_d_inner">
                                        <div class="col-lg-4">
                                            <div class="details_item">
                                                <h4>Order Info</h4>
                                                <ul class="list">
                                                    <li><a href="{{ route('contact.show',[$item->id_umkm]) }}"
                                                            target="_blank">
                                                            <span>Order number (Nama UMKM)</span>&nbsp;:
                                                            {{ $item->id_orders }}&nbsp;({{ $item->nama_umkm }})
                                                        </a>
                                                    </li>
                                                    <li><a href="#"><span>Nama Pemesan</span>&nbsp;:
                                                            {{ $item->first_name }}&nbsp;{{ $item->last_name }}</a>
                                                    </li>
                                                    <li><a href="#"><span>Date</span>&nbsp;:
                                                            {{ $item->date }}
                                                        </a>
                                                    </li>
                                                    <li><a href="#" disabled>
                                                            <span>Nomor Resi Pengiriman
                                                            </span>&nbsp;:({{ $item->shipping }})
                                                            <strong>{{ Str::limit($item->no_resi, 15) }}</strong>
                                                        </a>
                                                    </li>
                                                    <li><a href="#"><span>Last Update</span>&nbsp;:
                                                            {{ $item->updated_at }}
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
                                                            <span hidden>
                                                                {{
                                                                $tanggal = Carbon\Carbon::parse($item->created_at);
                                                                }}
                                                                {{ $batas = $tanggal->addHours($item->deadline); }}
                                                                {{ $waktusekarang = Carbon\Carbon::now(); }}
                                                            </span>
                                                            <span>
                                                                Status Pemesanan
                                                            </span>&nbsp;:
                                                            @if($batas < $waktusekarang && $item->status ==
                                                                "Menunggu Konfirmasi")
                                                                Pesanan Anda Melewati Batas Deadline
                                                                @else
                                                                {{ $item->status }}
                                                                @endif
                                                        </a>
                                                    </li>
                                                    <li><a href="#" style="text-transform:capitalize;">
                                                            <span>
                                                                Status Pembayaran
                                                            </span>&nbsp;:
                                                            @if($batas < $waktusekarang && $item->status ==
                                                                "Menunggu Konfirmasi")
                                                                Pesanan Anda Melewati Batas Deadline
                                                                @else
                                                                <span>
                                                                    @if($item->status_payment == null)
                                                                    Belum Melakukan Pembayaran
                                                        </a>
                                                        @else
                                                        {{ $item->status_payment }}
                                                        </a>
                                                        @endif
                                                        </span>
                                                        @endif
                                                    </li>
                                                    <span hidden>
                                                        {{ $tanggal = 0; }}
                                                        {{ $batas = 0; }}
                                                        {{ $waktusekarang = 0; }}
                                                    </span>
                                                    <li><a href="#"><span>Total</span>&nbsp;:
                                                            Rp. {{number_format($item->total,2,',','.')}}
                                                        </a>
                                                    </li>
                                                    <li><a href="#"><span>Promo</span>&nbsp;:
                                                            "{{ $item->nama_promo }}"
                                                        </a>
                                                    </li>
                                                    @if($item->pict_payment)
                                                    <li><a href="{{asset('/data_file/pembayaran/'.$item->pict_payment)}}"
                                                            target="_blank"><span>Bukti Pembayaran</span>&nbsp;:
                                                            {{ $item->pict_payment =
                                                            Str::limit($item->pict_payment, 15) }}
                                                        </a>
                                                    </li>
                                                    @endif
                                                    <li>
                                                        <a href="{{ route('listitem.show',[Crypt::encrypt($item->id_orders)]) }}"
                                                            target="_blank">
                                                            <span>List Item</span>&nbsp;:
                                                            Klik disini...
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="details_item">
                                                <h4>Alamat Pengiriman</h4>
                                                <ul class="list">
                                                    <li><a href="#"><span>Alamat</span>&nbsp;:<br>
                                                            "{{ $item->address }},
                                                            {{ $item->districts }},
                                                            {{ $item->ward }},
                                                            {{ $item->city }},
                                                            {{ $item->province }}"
                                                        </a>
                                                    </li>
                                                    <li><a href="#"><span>Feedback</span>&nbsp;:<br>
                                                            "{{ $item->feedback_orders }}"
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row order_d_inner">
                                        <div class="col-lg-12" style="background-color:transparent;">
                                            <div class="details_item" style="background-color:transparent;">
                                                <!-- Disini aja -->
                                                <div class="progress-table" style="background-color:transparent;">
                                                    <div class="progress-table" style="background-color:transparent;">
                                                        <div class="table-head">
                                                            <h4>Rincian Order</h4>
                                                        </div>
                                                        <div class="table-row justify-content-center">
                                                            <!-- Get -->
                                                            @if($item->status == "Menunggu Konfirmasi")
                                                            <p>Pesanan sedang menunggu konfirmasi</p>
                                                            @elseif($item->status == "Menunggu Pembayaran")
                                                            <p>Pesanan belum dibayar</p>
                                                            @elseif($item->status == "Menunggu Konfirmasi Pembayaran")
                                                            <p>Pembayaran belum dikonfirmasi</p>
                                                            @elseif($item->status == "Menunggu Proses Produksi")
                                                            <p>Menunggu Proses Produksi</p>
                                                            @elseif($item->status == "Pesanan Ditolak")
                                                            <p>Pesanan Anda Ditolak</p>
                                                            @elseif($item->status == "Selesai")
                                                            <p>Pesanan Anda Telah Selesai</p>
                                                            @else
                                                            <form action="{{ route('track.orders') }}" method="post"
                                                                id="track{{$item->id_orders}}" class="form"
                                                                novalidate="novalidate" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="text" name="id"
                                                                    value="{{ $item->date }}/{{ $item->id_orders }}"
                                                                    hidden>
                                                                <a href="javascript:{}"
                                                                    onclick="document.getElementById('track{{ $item->id_orders }}').submit(); return false;">
                                                                    Klik Disini...
                                                                </a>
                                                            </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    @if($item->status_payment == "Menunggu Pembayaran" ||
                                    $item->status_payment == "Ditangguhkan")
                                    <a href="/order/bayar/{{ Crypt::encrypt($item->id_orders) }}"
                                        class="btn btn-success">
                                        Bayar Sekarang
                                    </a>
                                    @endif
                                    @if($item->status_payment == "Lunas")
                                    <a href="/order/invoice/{{ Crypt::encrypt($item->id_orders) }}" target="_blank"
                                        class="btn btn-success">
                                        Cek Invoice
                                    </a>
                                    @endif
                                    @if($item->status_payment == "Lunas" && $item->status == "Selesai")
                                    <a href="{{ route('order.show', Crypt::encrypt($item->id_orders) )}}"
                                        class="btn btn-success">
                                        Feedback
                                    </a>
                                    @endif
                                    @if($item->status == "Ditolak" || $item->status == "Selesai")
                                    <a href="https://wa.me/{{ $item->nomor_umkm }}" target="_blank"
                                        class="btn btn-success">
                                        Hubungi Admin
                                    </a>
                                    @endif
                                    <button type="submit" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <blockquote class="generic-blockquote">
                        <div class="row order_d_inner">
                            <div class="col-lg-12">
                                <div class="details_item">
                                    <h4>Order Info</h4>
                                    <ul class="list">
                                        <li>Anda belum melakukan transaksi</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </blockquote>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
<!--================ End Tracking Box Area =================-->
@endsection