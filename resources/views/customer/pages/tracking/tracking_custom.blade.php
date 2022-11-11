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
            <p>
                To track your order please enter your Order ID in the box below and press the "Track" button. This
                was given to you on your receipt
            </p>
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
            <form class="row tracking_form" action="{{ route('track.customs') }}" method="post" validate>
                @csrf
                <div class="col-md-12 form-group">
                    <input type="text" class="form-control" id="id" name="id" placeholder="Order ID"
                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Order ID'" min="1" required
                        pattern="[0-9]{4}[-]{1}[0-9]{2}[-]{1}[0-9]{2}[/]{1}[0-9]{1,10}"
                        oninvalid="this.setCustomValidity('Silahkan masukan order id Anda dengan benar')"
                        oninput="this.setCustomValidity('')">
                </div>
                <small style="margin-left:15px;">
                    Silahkan masukkan nomor id yang terletak paling kanan nomor Invoice <br>
                    <!-- Contoh : "INV/CUS/2022-00-00/<b>ID</b>" Masukkan ID nya saja. -->
                    Nomor Invoice : "INV/PRD/<b>2022-00-00/ID</b>" Masukkan tanggal dan ID nya saja. <br>
                    Contoh Inputan : "<b>2022-00-00/ID</b>" Masukkan tanggal dan ID nya saja. (Tanpa tanda petik)
                </small>
                <div class="col-md-12 form-group" style="margin-top:10px;">
                    <button type="submit" value="submit" class="primary-btn">Track Order</button>
                </div>
            </form>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        window.setTimeout(function() {
            $(".alert").fadeTo(1000, 0).slideUp(1000, function() {
                $(this).remove();
            });
        }, 5000);

    });
</script>
<!--================End Tracking Box Area =================-->
@endsection