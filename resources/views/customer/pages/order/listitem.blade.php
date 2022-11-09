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
                <h1>List Item</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">List Item</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Tracking Box Area =================-->
<section class="tracking_box_area section_gap">
    <div class="container">
        <h2>List Item</h2>
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
                                        <li><a href="#" style="text-transform:capitalize;">
                                                <span>
                                                    Promo
                                                </span>&nbsp;:
                                                {{ $orders[0]->nama_promo }}
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
                                    <h4 class="mb-0">List Item</h4>
                                    <div class="progress-table" style="background-color:transparent;">
                                        <div class="progress-table" style="background-color:transparent;">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Nama Item</th>
                                                        <th scope="col">Jumlah Item</th>
                                                        <th scope="col">Harga Item</th>
                                                        <th scope="col">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($page as $item)
                                                    <tr>
                                                        <td>{{ $item->nama_produk }} <br>
                                                            <strong style="text-transform:uppercase;">
                                                                Ukuran&nbsp;:&nbsp;"{{ $item->ukuran_produk}}"<br>
                                                                Warna&nbsp;:&nbsp;"{{ $item->warna_produk}}"
                                                            </strong>
                                                        </td>
                                                        <td>{{ $item->jumlah }} Pcs</td>
                                                        <td>Rp. {{number_format($item->harga,2,',','.')}}</td>
                                                        <td>Rp. {{number_format($item->sub,2,',','.')}}</td>
                                                    </tr>

                                                    @empty
                                                    <tr colspan="4"></tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </blockquote>
                    <div class="float-left">
                        <a href="/history" class="btn btn-primary"><span
                                class="fa fa-arrow-left"></span>&nbsp;Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Tracking Box Area =================-->
@endsection