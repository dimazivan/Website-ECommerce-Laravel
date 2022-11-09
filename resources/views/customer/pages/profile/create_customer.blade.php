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
                <h1>Form Profile Page</h1>
                <nav class="d-flex align-items-center">
                    <a href="">Form Profile</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->
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
                        <ul class="list list_2">
                            <li><a href="#">Username : &nbsp;&nbsp;{{ auth()->user()->username }}</a></li>
                            <li><a href="#">Email : &nbsp;&nbsp;{{ auth()->user()->email }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8">
                    <h3>Form Tambah Data Anda</h3>
                    <form class="row contact_form" action="{{ route('profile.store') }}" method="post" validate>
                        @csrf
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="first" name="first_name"
                                placeholder="First Name" onkeydown="return /[a-z, ]/i.test(event.key)" required
                                oninvalid="this.setCustomValidity('Silahkan masukan nama depan Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="last" name="last_name" placeholder="Last Name"
                                onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)" required
                                oninvalid="this.setCustomValidity('Silahkan masukan nama belakang Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" name="phone"
                                onkeydown="return /[0-9,backspace,delete]/i.test(event.key)" placeholder="Nomor Telepon"
                                required minlength="10" maxlength="14"
                                oninvalid="this.setCustomValidity('Silahkan masukan nomor telepon Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" name="postal_code"
                                onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)" placeholder="Kode Pos"
                                required minlength="4" maxlength="6"
                                oninvalid="this.setCustomValidity('Silahkan masukan nomor kode pos Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <textarea class="form-control" name="address" id="" cols="30" rows="10"
                                placeholder="Alamat Anda" required
                                oninvalid="this.setCustomValidity('Silahkan masukan alamat Anda')"
                                oninput="this.setCustomValidity('')"></textarea>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" name="districts" placeholder="Kecamatan"
                                onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)" required
                                oninvalid="this.setCustomValidity('Silahkan masukan nama kecamatan Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" name="ward" placeholder="Kelurahan"
                                onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)" required
                                oninvalid="this.setCustomValidity('Silahkan masukan nama kelurahan Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" name="city" placeholder="Kota"
                                onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)" required
                                oninvalid="this.setCustomValidity('Silahkan masukan nama kota Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" name="province" placeholder="Provinsi"
                                onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)" required
                                oninvalid="this.setCustomValidity('Silahkan masukan nama provinsi Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="creat_account">
                                <h3>Details Alamat</h3>
                            </div>
                            <textarea class="form-control" name="desc" id="message" rows="1"
                                placeholder="Detail alamat"></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" value="submit" class="primary-btn">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection