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
                <h1>Tracking Page Custom</h1>
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
        <div class="tracking_box_inner">
            <p>To track your order please enter your Order ID in the box below and press the "Track" button. This
                was given to you on your receipt</p>
            <form class="row tracking_form" action="{{ route('track.customs') }}" method="post" validate>
                @csrf
                <div class="col-md-12 form-group">
                    <input type="number" class="form-control" id="id" name="id" placeholder="Order ID"
                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Order ID'" min="1"
                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)" required
                        oninvalid="this.setCustomValidity('Silahkan masukan order id Anda dengan benar')"
                        oninput="this.setCustomValidity('')">
                </div>
                <small style="margin-left:15px;">
                    Silahkan masukkan nomor id yang terletak paling kanan nomor Invoice <br>
                    Contoh : "INV/CUS/2022-00-00/<b>ID</b>" Masukkan ID nya saja.
                </small>
                <div class="col-md-12 form-group" style="margin-top:10px;">
                    <button type="submit" value="submit" class="primary-btn">Track Order</button>
                </div>
            </form>
        </div>
    </div>
</section>
<!--================End Tracking Box Area =================-->
@endsection