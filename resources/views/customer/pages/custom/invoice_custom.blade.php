@extends('customer.layouts.app')
@section('title')
{{ $title }}
@endsection
@section('content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Invoice Custom</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Invoice Custom</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Order Details Area =================-->
<section class="order_details section_gap">
    @forelse ($customs as $items)
    <div class="container">
        <h3 class="title_confirmation">Thank you. Your order has been received.</h3>
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
                    <h4>Order Info</h4>
                    <ul class="list">
                        <li><a href="#"><span>Nama Pemesan</span>&nbsp;:
                                {{ $items->first_name }}&nbsp;{{ $items->last_name }}</a>
                        </li>
                        <li><a href="#" style="text-transform:capitalize;">
                                <span>
                                    Status Pemesanan
                                </span>&nbsp;:
                                {{ $items->status }}</a>
                        </li>
                        <li><a href="#" style="text-transform:capitalize;">
                                <span>
                                    Status Pembayaran
                                </span>&nbsp;:
                                @if($items->status_payment == null)
                                Belum Melakukan Pembayaran</a>
                            @else
                            {{ $items->status_payment }}</a>
                            @endif
                        </li>
                        @if($items->pict_payment)
                        <li><a href="{{asset('/data_file/pembayaran/'.$items->pict_payment)}}"
                                target="_blank"><span>Bukti Pembayaran</span>&nbsp;:
                                {{ $items->pict_payment = Str::limit($items->pict_payment,
                                15) }}
                            </a>
                        </li>
                        @endif
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
                                {{ $items->province }}"
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="order_details_table">
            <h2>Detail order custom</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" width="15%">Jumlah Pesanan</th>
                            <th scope="col">File Desain</th>
                            <th scope="col">Deskripsi Order</th>
                            <th scope="col">Deskripsi Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $items->qty }} Pcs</td>
                            <td>Depan&nbsp;:
                                <a href="{{asset('/data_file/custom/'.$items->pict_desain_depan)}}" target="_blank">
                                    {{ $items->pict_desain_depan = Str::limit($items->pict_desain_depan,
                                    15) }}
                                </a><br>
                                Belakang&nbsp;:
                                <a href="{{asset('/data_file/custom/'.$items->pict_desain_belakang)}}" target="_blank">
                                    {{ $items->pict_desain_belakang = Str::limit($items->pict_desain_belakang,
                                    15) }}
                                </a>
                            </td>
                            <td>{{ $items->keterangan = Str::limit($items->keterangan,15) }}</td>
                            <td>{{ $items->desc = Str::limit($items->desc,15) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h4>Subtotal</h4>
                            </td>
                            <td>
                                <p>Rp. {{number_format($items->subtotal,2,',','.')}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h4>Ongkir</h4>
                            </td>
                            <td>
                                <p>Rp. {{number_format($items->ongkir,2,',','.')}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <h4>Total</h4>
                            </td>
                            <td>
                                <p>Rp. {{number_format($items->total,2,',','.')}}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="" style="float:right;">
            <a href="/history" class="btn btn-primary"><span class="fa fa-arrow-left"></span>&nbsp;Kembali</a>
            <a href="/custom/invoice/cetak/{{ $items->id_custom }}" target="_blank" class="btn btn-info">
                <span class="fa fa-print"></span>
                &nbsp;Cetak Invoice
            </a>
        </div>
    </div>
    @empty
    <div class="container">
        <h3 class="title_confirmation">Thank you. Your order has been received.</h3>
    </div>
    @endforelse
</section>
<!--================End Order Details Area =================-->
@endsection