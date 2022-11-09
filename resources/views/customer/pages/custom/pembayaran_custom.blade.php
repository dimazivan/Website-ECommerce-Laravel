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
                        <h2>Rincian Order Custom</h2>
                        <!-- <ul class="list"> -->
                        <ul class="list">
                            <li><a href="{{asset('/data_file/custom/'.$page[0]->pict_desain_depan)}}"
                                    target="_blank">Desain
                                    Product&nbsp;:
                                    <strong>
                                        <span>
                                            {{ $page[0]->pict_desain_depan }}
                                        </span>
                                    </strong>
                                </a>
                                <a href="{{asset('/data_file/custom/'.$page[0]->pict_desain_belakang)}}"
                                    target="_blank">Desain
                                    Product&nbsp;:
                                    <strong>
                                        <span>
                                            {{ $page[0]->pict_desain_belakang }}
                                        </span>
                                    </strong>
                                </a>
                            </li>
                            <li>Deskripsi Order&nbsp;:<br><span>"{{ $page[0]->desc }}"</span></li>
                            <li><a>Status Pesanan&nbsp;:<span>{{ $page[0]->status }}</span></a></li>
                            <li><a>Status Pembayaran&nbsp;:<span>{{ $page[0]->status_payment }}</span></a></li>
                        </ul>
                        <ul class="list list_2">
                            <li><a href="#">Subtotal
                                    <span>Rp.
                                        {{number_format($page[0]->subtotal,2,',','.')}}
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
                        <form action="{{ route('custom.update',[Crypt::encrypt($page[0]->id)]) }}" method="post"
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
                                <input type="text" name="id" value="{{ $page[0]->id }}" hidden>
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