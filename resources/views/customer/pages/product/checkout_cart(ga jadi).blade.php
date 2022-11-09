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
            <p>If you have not loggin with this account, you can change your account by click <a href="#">Logout</a>
                to switch
                account
            </p>
        </div>
        <div class="billing_details">
            <div class="row">
                <div class="col-lg-8">
                    <h3>Form Order Custom</h3>
                    <p>Harap masukkan informasi data pesanan Anda dengan benar, agar pesanan Anda dapat segera diproses.
                    </p>
                    <form class="row contact_form" action="{{ route('custom.store') }}" method="post" validate
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
                        <input type="text" name="id" value="{{ $user[0]->id }}" hidden>
                        <input type="text" name="umkm_name" value="{{ $umkm_name }}" hidden>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="first" name="first_name"
                                placeholder="First Name" onkeydown="return /[a-z, ]/i.test(event.key)"
                                value="{{ $user[0]->first_name }}" required>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="last" name="last_name" placeholder="Last Name"
                                onkeydown="return /[a-z, ]/i.test(event.key)" value="{{ $user[0]->last_name }}"
                                required>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" name="phone"
                                onkeydown="return /[0-9]/i.test(event.key)" placeholder="Nomor Telepon" required
                                minlength="10" maxlength="14" value="{{ $user[0]->phone }}">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" name="postal_code"
                                onkeydown="return /[a-z, ]/i.test(event.key)" placeholder="Kode Pos" required
                                minlength="4" maxlength="6" value="{{ $user[0]->postal_code }}">
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <!-- <input type="text" class="form-control" name="address" placeholder="Alamat Anda"> -->
                            <textarea class="form-control" name="address" id="" cols="30" rows="10"
                                placeholder="Alamat Anda" required>{{ $user[0]->address }}</textarea>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" name="districts" placeholder="Kecamatan"
                                onkeydown="return /[a-z, ]/i.test(event.key)" value="{{ $user[0]->districts }}"
                                required>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" name="ward" placeholder="Kelurahan"
                                onkeydown="return /[a-z, ]/i.test(event.key)" value="{{ $user[0]->ward }}" required>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" name="city" placeholder="Kota"
                                onkeydown="return /[a-z, ]/i.test(event.key)" value="{{ $user[0]->city }}" required>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" name="province" placeholder="Provinsi"
                                onkeydown="return /[a-z, ]/i.test(event.key)" value="{{ $user[0]->province }}" required>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" name="qty"
                                onkeydown="return /[0-9]/i.test(event.key)" placeholder="Jumlah Order" required
                                minlength="1" maxlength="4">
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="create_account">
                                <h3>Details Alamat</h3>
                            </div>
                            <textarea class="form-control" name="desc" id="message" rows="1"
                                placeholder="Detail alamat">{{ $user[0]->desc }}</textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="create_account">
                                <h3>Desain Order</h3>
                            </div>
                            <input type="file" class="form-control" placeholder="depan" name="file_desain_depan"
                                accept="image/*">
                            <small>Besar file: maksimum 10.000.000 bytes (10 Megabytes). Ekstensi file yang
                                diperbolehkan: .JPG .JPEG .PNG</small>
                            <input type="file" class="form-control" placeholder="belakang" name="file_desain_belakang"
                                accept="image/*">
                            <small>Besar file: maksimum 10.000.000 bytes (10 Megabytes). Ekstensi file yang
                                diperbolehkan: .JPG .JPEG .PNG</small>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="create_account">
                                <h3>Details Order</h3>
                            </div>
                            <textarea class="form-control" name="detail" id="message" rows="1"
                                placeholder="Detail order">
                            </textarea>
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
                            <!-- <li><a href="#">Gender : <span>{{ $user[0]->first_name }}</span></a></li> -->
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
                            <!-- <li><a href="#">Username :<span>{{ $user[0]->username }}</span></a></li> -->
                        </ul>
                        <!-- <button type="submit" value="submit" class="primary-btn">Submit Order</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Checkout Area =================-->

@endsection