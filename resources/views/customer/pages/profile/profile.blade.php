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
                <h1>Profile Page</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Profile</a>
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
                        <a href="#">{{ auth()->user()->username }}</a>
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
                <div class="col-lg-4">
                    <div class="order_box">
                        <h2>Your Profile</h2>
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
                            <li><a href="#">Username :
                                    <span style="text-transform:none;">
                                        {{ $user[0]->username }}
                                    </span>
                                </a>
                            </li>
                            <li><a href="#">Email :
                                    <span style="text-transform:none;">
                                        {{ $user[0]->email }}
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8">
                    <h3>Form Change</h3>
                    <form class="row contact_form" action="{{ route('profile.update', [$user[0]->id]) }}" method="post"
                        validate>
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
                                oninvalid="this.setCustomValidity('Silahkan masukan nomor telepon Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label for="">Kode Pos&nbsp;:</label>
                            <input type="number" class="form-control" name="postal_code"
                                onkeydown="return /[0-9, ,backspace,delete]/i.test(event.key)" placeholder="Kode Pos"
                                required minlength="4" maxlength="6" value="{{ $user[0]->postal_code }}"
                                oninvalid="this.setCustomValidity('Silahkan masukan nomor kode pos Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <label for="">Alamat&nbsp;:</label>
                            <textarea class="form-control" style="margin-top: 5px;" name="address" id="" cols="30"
                                rows="10" placeholder="Alamat Anda" required
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
                        <div class="col-md-12 form-group">
                            <div class="creat_account">
                                <h3>Details Alamat</h3>
                            </div>
                            <textarea class="form-control" name="desc" id="message" rows="1"
                                placeholder="Detail alamat">{{ $user[0]->desc }}</textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" value="submit" class="primary-btn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Checkout Area =================-->
@endsection