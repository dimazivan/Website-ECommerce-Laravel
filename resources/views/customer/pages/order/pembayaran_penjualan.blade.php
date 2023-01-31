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
                <h1>Pembayaran</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Pembayaran</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Checkout Area =================-->
<section class="checkout_area section_gap">
    <div class="container">
        <!-- Login tambahan -->
        <div class="returning_customer">
            <div class="check_title">
                <h2>You're login with
                    <strong>
                        <a href="/profile">{{ auth()->user()->username }}</a>
                    </strong>
                </h2>
            </div>
            <p>If you have not loggin with this account, you can change your account by click <a
                    href="/logout">Logout</a>
                to switch
                account
            </p>
        </div>
        <div class="billing_details">
            <div class="row">
                <div class="col-lg-8">
                    <h3>Detail Pembayaran</h3>
                    @if(($errors->any()) != null)
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible " role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">x</span>
                        </button>
                        {{ $error }}
                    </div>
                    @endforeach
                    @endif
                    @if(\Session::has('info'))
                    <div class="alert alert-info alert-dismissible" role="alert" data-timeout="2000">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">x</span>
                        </button>
                        <strong>{{ \Session::get('info') }}</strong>
                    </div>
                    @endif
                    <div class="order_box">
                        <h2>Rincian Order Penjualan&nbsp;({{ $page[0]->nama_umkm }})</h2>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Jumlah Beli (Pcs)</th>
                                        <th scope="col">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($page as $item)
                                    <tr>
                                        <td>
                                            <p>
                                                <a href="{{asset('/data_produk/'.$item->pict_1)}}" target="_blank">
                                                    <span class="fa fa-file-image-o">Lihat Gambar</span>
                                                    <!-- <img src="{{ url('/data_produk/'.$item->pict_1) }}"
                                                        alt="{{ $item->pict_1 }}" width="70px" height="70px"> -->
                                                </a>
                                                {{ $item->products_name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p>{{ $item->products_qty }} Pcs</p>
                                        </td>
                                        <td>
                                            <p>Rp. {{number_format($item->products_subtotal,2,',','.')}}</p>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4">Keranjang kosong....</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- <ul class="list"> -->
                        <ul class="list">
                            <!-- <li>Deskripsi Order&nbsp;:<br><span>"{{ $page[0]->detail }}"</span></li> -->
                            @if(!empty($promos[0]))
                            <li><a>Promo "{{ $promos[0]->name }}"&nbsp;:<span>
                                        Rp. {{number_format(($page[0]->potongan),2,',','.')}}
                                    </span>
                                </a>
                            </li>
                            @else
                            <li><a>Promo &nbsp;:<span>Tidak ada promo yang dipakai.</span></a></li>
                            @endif
                            <li><a>Status Pesanan&nbsp;:<span>{{ $page[0]->status }}</span></a></li>
                            <li><a>Status Pembayaran&nbsp;:<span>{{ $page[0]->status_payment }}</span></a></li>
                        </ul>
                        <ul class="list list_2">
                            <li><a href="#">Subtotal
                                    <span>Rp.
                                        {{number_format(($page[0]->total-$page[0]->ongkir),2,',','.')}}
                                    </span>
                                </a>
                            </li>
                            <li><a href="#">Ongkir
                                    <span>
                                        Rp. {{number_format($page[0]->ongkir,2,',','.')}}
                                    </span>
                                </a>
                            </li>
                            <li><a href="#">Total
                                    <span>
                                        Rp. {{number_format($page[0]->total,2,',','.')}}
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <!-- <a class="primary-btn" href="#">Proceed to Paypal</a> -->
                    </div>
                    <div class="order_box">
                        <h2>Portal Pembayaran</h2>
                        <!-- <ul class="list"> -->
                        <ul class="list">
                            <li><a href="{{ route('portal.show',[$page[0]->umkms_id]) }}" target="_blank">Portal
                                    Pembayaran&nbsp;:
                                    <span>
                                        <strong>
                                            Klik Disini!
                                        </strong>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="order_box" style="margin-top:62px;">
                        <form action="{{ route('order.update',[Crypt::encrypt($page[0]->orders_id)]) }}" method="post"
                            validate enctype="multipart/form-data">
                            @csrf
                            {{method_field("PUT")}}
                            @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <h2>Personal Information</h2>
                            <ul class="list">
                                <li><a href="#">Name : <span>
                                            {{ $page[0]->first_name }} &nbsp; {{ $page[0]->last_name }}</span></a></li>
                                <li><a href="#">Phone : <span>{{ $page[0]->phone }}</span></a></li>
                                <li><a href="https://google.com/maps/search/{{ $page[0]->address }}" target="_blank">
                                        Address :
                                        <span>{{ $page[0]->address }}</span></a></li>
                                <li><a href="#">City : <span>{{ $page[0]->city }}</span></a></li>
                                <li><a href="#">Kecamatan : <span>{{ $page[0]->districts }}</span></a></li>
                                <li><a href="#">Kelurahan : <span>{{ $page[0]->ward }}</span></a></li>
                                <li><a href="#">Kode Pos: <span>{{ $page[0]->postal_code }}</span></a></li>
                                <input type="text" name="id" value="{{ $page[0]->orders_id }}" hidden>
                                <li><strong>Upload Pembayaran :</strong></li>
                                <li><input type="file" name="pict_payment" accept="image/*" required
                                        oninvalid="this.setCustomValidity('Silahkan masukan file bukti pembayaran Anda')"
                                        oninput="this.setCustomValidity('')"></li>
                                <small>Besar file: maksimum 10.000.000 bytes (10 Megabytes). Ekstensi file yang
                                    diperbolehkan: .JPG .JPEG .PNG</small>
                                <br>
                            </ul>
                            <button type="submit" class="btn primary-btn">Upload Pembayaran</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Checkout Area =================-->
<script type="text/javascript">
    $(document).ready(function() {
        window.setTimeout(function() {
            $(".alert").fadeTo(1000, 0).slideUp(1000, function() {
                $(this).remove();
            });
        }, 5000);

    });
</script>
@endsection