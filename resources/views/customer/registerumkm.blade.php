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
                <h1>Register Page</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Register UMKM</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Login Box Area =================-->
<section class="login_box_area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login_box_img">
                    <img class="img-fluid" src="{{asset('customer/img/login.jpg')}}" alt="">
                    <div class="hover">
                        @if(isset($info->description_register))
                        <h4>Welcome to {{ $info->title }} register page</h4>
                        <p>{{ $info->description_register }}</p>
                        @else
                        <p>Silahkan hubungi admin</p>
                        @endif
                        <a class="primary-btn" href="/login">Login Here</a>
                        <a class="primary-btn" href="/register">Register User</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Register UMKM Here</h3>
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
                    <form class="row login_form" action="{{ route('umkm.store') }}" method="post" id="contactForm"
                        validate>
                        @csrf
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="umkm_name" name="umkm_name"
                                placeholder="Nama UMKM" onfocus="this.placeholder = ''"
                                onblur="this.placeholder = 'Nama UMKM'" required
                                oninvalid="this.setCustomValidity('Silahkan masukan nama UMKM Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama Pemilik"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nama Pemilik'" required
                                oninvalid="this.setCustomValidity('Silahkan masukan nama pemilik UMKM')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="location" name="location"
                                placeholder="Alamat UMKM" onfocus="this.placeholder = ''"
                                onblur="this.placeholder = 'Alamat UMKM'" required
                                oninvalid="this.setCustomValidity('Silahkan masukan alamat UMKM Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <!-- Tambah kecamatan dll select ajax -->
                        <div class="col-md-12 form-group">
                            <input type="number" class="form-control" id="phone" name="phone" placeholder="Phone Number"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone Number'" required
                                oninvalid="this.setCustomValidity('Silahkan masukan nomor telepon Anda atau UMKM')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'" required
                                oninvalid="this.setCustomValidity('Silahkan masukan username Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="email" class="form-control" name="email" class="email" placeholder="Email Anda"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Anda'" required
                                oninvalid="this.setCustomValidity('Silahkan masukan alamat email Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" onfocus="this.placeholder = ''"
                                onblur="this.placeholder = 'Password'" required
                                oninvalid="this.setCustomValidity('Silahkan masukan password Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" id="confirm" name="confirmpassword"
                                placeholder="Confirm Password" onfocus="this.placeholder = ''"
                                onblur="this.placeholder = 'Confirm Password'" required
                                oninvalid="this.setCustomValidity('Silahkan masukan password Anda')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" value="submit" class="primary-btn">Register</button>
                            <a href="/login">Have an account ?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Login Box Area =================-->
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