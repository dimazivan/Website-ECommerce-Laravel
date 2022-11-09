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
                <h1>Feedback Order</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Feedback Order</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Order Details Area =================-->
<section class="order_details section_gap">
    <div class="container">
        <h3 class="title_confirmation">Thank you. Your order has been received.</h3>
        <div class="row order_d_inner">
            <div class="col-lg-4">
                <div class="details_item">
                    <h4>Order Info</h4>
                    <ul class="list">
                        <li><a href="#"><span>Order number</span>&nbsp;:
                                {{ $orders[0]->orders_id }}</a></li>
                        <li><a href="#"><span>Date</span>&nbsp;:
                                {{ $orders[0]->tanggal }}</a></li>
                        <li><a href="#"><span>Last Update</span>&nbsp;:
                                {{ $orders[0]->last_updated }}</a></li>
                        <li><a href="#"><span>UMKM Name:</span>&nbsp;:
                                {{ $orders[0]->nama_umkm }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="details_item">
                    <h4>Order Info</h4>
                    <ul class="list">
                        <li><a href="#"><span>Nama Pemesan</span>&nbsp;:
                                {{ $orders[0]->first_name }}&nbsp;{{ $orders[0]->last_name }}</a>
                        </li>
                        <li><a href="#" style="text-transform:capitalize;">
                                <span>
                                    Status Pemesanan
                                </span>&nbsp;:
                                {{ $orders[0]->status }}</a>
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
                        @if($orders[0]->pict_payment)
                        <li><a href="{{asset('/data_file/pembayaran/'.$orders[0]->pict_payment)}}"
                                target="_blank"><span>Bukti Pembayaran</span>&nbsp;:
                                {{ $orders[0]->pict_payment = Str::limit($orders[0]->pict_payment,
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
        <div class="order_details_table">
            <h2>Detail order penjualan</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" width="35%">Nama Produk (Nama UMKM)</th>
                            <th scope="col">Jumlah Beli (Pcs)</th>
                            <th scope="col">Harga Produk</th>
                            <th scope="col">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $item)
                        <tr>
                            <td>{{ $item->products_name }} Pcs</td>
                            <td>{{ $item->products_qty }} Pcs</td>
                            <td>Rp. {{number_format($item->products_price,2,',','.')}}</td>
                            <td>Rp. {{number_format($item->subtotal,2,',','.')}}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">Keranjang kosong....</td>
                        </tr>
                        @endforelse
                        <tr>
                            <td>Detail Orders: <br>{{ $orders[0]->keterangan = Str::limit($orders[0]->keterangan,15) }}
                            </td>
                            <td>Detail Alamat: <br>{{ $orders[0]->desc = Str::limit($orders[0]->desc,15) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h4>Subtotal</h4>
                            </td>
                            <td>
                                <p>Rp. {{number_format(($orders[0]->total-$orders[0]->ongkir),2,',','.')}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h4>Ongkir</h4>
                            </td>
                            <td>
                                <p>Rp. {{number_format($orders[0]->ongkir,2,',','.')}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h4>Pajak</h4>
                            </td>
                            <td>
                                <p>Rp. 0</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <h4>Total</h4>
                            </td>
                            <td>
                                <p>Rp. {{number_format($orders[0]->total,2,',','.')}}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="billing_details">
            <form class="row contact_form" action="{{ route('order.feedback') }}" method="post" validate
                enctype="multipart/form-data">
                @csrf
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="col-md-12" style="margin-left:-15px;">
                    <!-- <div class="col-md-12 form-group p_star">
                        <label for="">Rating Produk&nbsp;:</label>
                        <input type="text" class="form-control" id="rating" name="rating" placeholder=""
                            onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)" required>
                    </div> -->
                    <input type="text" name="umkm_name" value="{{ $orders[0]->nama_umkm }}" hidden>
                    <input type="text" name="id_order" value="{{ $orders[0]->orders_id }}" hidden>
                    <div class="col-md-12 form-group p_star">
                        <label for="">Deskripsi&nbsp;:</label>
                        <textarea class="form-control" name="desc" id="message" rows="1"
                            placeholder="Ulasan, Kritik, dan Saran" value=""></textarea>
                    </div>
                </div>
                <div class="div" style="margin-bottom:-200px;margin-left:13px;">
                    <button type="submit" class=" btn btn-success">
                        <span class="fa fa-comments"></span>
                        Send Feedback
                    </button>
                </div>
            </form>
        </div>
        <div class="" style="float:right;">
            <a href="/history" class="btn btn-primary"><span class="fa fa-arrow-left"></span>&nbsp;Kembali</a>
            <a href="/order/invoice/cetak/{{ $item->id_penjualan }}" target="_blank" class="btn btn-info"><span
                    class="fa fa-print"></span>&nbsp;Cetak Invoice</a>
        </div>
    </div>
</section>
<!--================End Order Details Area =================-->
@endsection