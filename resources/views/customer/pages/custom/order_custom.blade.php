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
                <h1>Custom Form</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Custom Form</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Checkout Area =================-->
<section class="checkout_area section_gap">
    <div class="container">
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
                    <h3>Form Order Custom</h3>
                    <p style="margin-top:-20px;">
                        Harap masukkan informasi data pesanan Anda dengan benar, agar pesanan Anda dapat segera
                        diproses.
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
                    <form class="row contact_form" action="{{ route('custom.store') }}" method="post" validate
                        enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="id" value="{{ $user[0]->id }}" hidden>
                        <input type="text" name="umkm_name" value="{{ $umkm_name }}" hidden>
                        <div class="col-md-6 form-group p_star">
                            <label for="">Nama Depan&nbsp;:</label>
                            <input type="text" class="form-control" id="first" name="first_name"
                                placeholder="Nama Depan" onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                value="{{ $user[0]->first_name }}" required
                                oninvalid="this.setCustomValidity('Silahkan masukan nama depan Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label for="">Nama Belakang&nbsp;:</label>
                            <input type="text" class="form-control" id="last" name="last_name"
                                placeholder="Nama Belakang"
                                onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                value="{{ $user[0]->last_name }}" required
                                oninvalid="this.setCustomValidity('Silahkan masukan nama belakang Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label for="">Nomor Telepon&nbsp;:</label>
                            <input type="number" class="form-control" name="phone"
                                onkeydown="return /[0-9,backspace,delete]/i.test(event.key)" placeholder="Nomor Telepon"
                                required minlength="10" maxlength="14" value="{{ $user[0]->phone }}"
                                oninvalid="this.setCustomValidity('Silahkan masukan nomor telepon anda Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label for="">Kode Pos&nbsp;:</label>
                            <input type="number" class="form-control" name="postal_code"
                                onkeydown="return /[0-9, ,backspace,delete]/i.test(event.key)" placeholder="Kode Pos"
                                required minlength="4" maxlength="6" value="{{ $user[0]->postal_code }}"
                                oninvalid="this.setCustomValidity('Silahkan masukan kode pos Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <label for="">Alamat&nbsp;:</label>
                            <textarea class="form-control" style="margin-top: 5px;" name="address" id="" cols="30"
                                rows="10" placeholder="Alamat Anda" required value="{{ $user[0]->address }}"
                                oninvalid="this.setCustomValidity('Silahkan masukan alamat Anda')"
                                oninput="this.setCustomValidity('')">{{ $user[0]->address }}</textarea>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label for="">Kecamatan&nbsp;:</label>
                            <input type="text" class="form-control" name="districts" placeholder="Nama Kecamatan"
                                onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                value="{{ $user[0]->districts }}" required
                                oninvalid="this.setCustomValidity('Silahkan masukan nama kecamatan Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label for="">Kelurahan&nbsp;:</label>
                            <input type="text" class="form-control" name="ward" placeholder="Nama Kelurahan"
                                onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                value="{{ $user[0]->ward }}" required
                                oninvalid="this.setCustomValidity('Silahkan masukan nama kelurahan Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label for="">Kota&nbsp;:</label>
                            <input type="text" class="form-control" name="city" placeholder="Nama Kota"
                                onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                value="{{ $user[0]->city }}" required
                                oninvalid="this.setCustomValidity('Silahkan masukan nama kota Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label for="">Provinsi&nbsp;:</label>
                            <input type="text" class="form-control" name="province" placeholder="Nama Provinsi"
                                onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                value="{{ $user[0]->province }}" required
                                oninvalid="this.setCustomValidity('Silahkan masukan nama provinsi Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label for="">Jumlah Order (Pcs)&nbsp;:</label>
                            <input type="number" class="form-control" name="qty"
                                onkeydown="return /[0-9,backspace,delete]/i.test(event.key)" placeholder="Jumlah Order"
                                required minlength="1" maxlength="4" min="1"
                                oninvalid="this.setCustomValidity('Silahkan masukan jumlah order Anda (pcs)')"
                                oninput="this.setCustomValidity('')">
                            <small>Note: Jumlah order merupakan total order pemesanan anda.</small>
                        </div>
                        <div class="input-group-icon col-md-12 form-group p_star">
                            <label for="">Jasa Pengiriman&nbsp;:</label>
                            <div class="icon" style="margin-left:10px;margin-top:24px;">
                                <i class="fa fa-truck" aria-hidden="true"></i>
                            </div>
                            <div class="baru">
                                <div class="form-select" id="default-select">
                                    <select name="cbshipping" id="cbshipping">
                                        <option value="" selected disabled>Pilih Jasa Pengiriman</option>
                                        @forelse($shipping as $jasa)
                                        <option value="{{ $jasa->name }}&nbsp;{{ $jasa->type }}">
                                            {{ $jasa->name }}&nbsp;{{ $jasa->type }}
                                        </option>
                                        @empty
                                        <option value="">Kosong</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <small>Note: Harus memilih salah satu jasa ekspedisi</small>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="create_account">
                                <h3>Details Alamat</h3>
                            </div>
                            <textarea class="form-control" name="desc" id="message" rows="1"
                                placeholder="Detail alamat">{{ $user[0]->desc }}</textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="create_account" style="margin-bottom:-20px;">
                                <h3>Desain Order</h3>
                            </div>
                            <label for="">Tampak Depan&nbsp;:</label>
                            <input type="file" class="form-control" placeholder="depan" name="file_desain_depan"
                                accept="image/*" required
                                oninvalid="this.setCustomValidity('Silahkan masukan file desain depan custom Anda')"
                                oninput="this.setCustomValidity('')">
                            <small>Besar file: maksimum 10.000.000 bytes (10 Megabytes). Ekstensi file yang
                                diperbolehkan: .JPG .JPEG .PNG</small><br>
                            <label for="">Tampak Belakang&nbsp;:</label>
                            <input type="file" class="form-control" placeholder="belakang" name="file_desain_belakang"
                                accept="image/*" required
                                oninvalid="this.setCustomValidity('Silahkan masukan file desain belakang custom Anda')"
                                oninput="this.setCustomValidity('')">
                            <small>Besar file: maksimum 10.000.000 bytes (10 Megabytes). Ekstensi file yang
                                diperbolehkan: .JPG .JPEG .PNG</small>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="create_account">
                                <h3>Details Order</h3>
                            </div>
                            <textarea class="form-control" name="detail" id="message" rows="1">Contoh Format Order:
1. Ukuran&nbsp;:XL
Lengan&nbsp;:Panjang/Pendek
Jumlah&nbsp;:20pcs
Warna Kain  :Hitam Polos
Keterangan  :Kain tebal
=================================
dst.
=================================
dst."</textarea>
                        </div>
                        <button type="submit" value="submit" class="primary-btn">Submit Order</button>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="order_box" style="margin-top:32px;">
                        <h2>Your Informations</h2>
                        <ul class="list">
                            <li><a href="#">Name : <span>
                                        {{ $user[0]->first_name }} &nbsp; {{ $user[0]->last_name }}</span></a></li>
                            <li><a href="#">Phone : <span>{{ $user[0]->phone }}</span></a></li>
                            <li><a href="https://google.com/maps/search/{{ $user[0]->address }}" target="_blank">
                                    Address :
                                    <span>{{ $user[0]->address }}</span></a></li>
                            <li><a href="#">City : <span>{{ $user[0]->city }}</span></a></li>
                            <li><a href="#">Kecamatan : <span>{{ $user[0]->districts }}</span></a></li>
                            <li><a href="#">Kelurahan : <span>{{ $user[0]->ward }}</span></a></li>
                            <li><a href="#">Kode Pos: <span>{{ $user[0]->postal_code }}</span></a></li>
                        </ul>
                        <hr>
                        <ul class="list list_2">
                            <li>
                                You'll order to this store
                                <a href="#">UMKM Name :<span style="color:green;">{{ $umkm_name }}</span></a>
                            </li>
                        </ul>
                    </div>
                    <div class="order_box" style="margin-top:32px;">
                        <h2>Cek Ongkir (Src : Raja Ongkir)</h2>
                        <a class="primary-btn" href="/ongkir" style="color:white;">
                            Cek Harga Ongkir
                        </a>
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