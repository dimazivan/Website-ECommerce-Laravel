<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{asset('toko/production/images/favicon.ico')}}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Author Meta -->
    <meta name="dimaz" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- preloader -->
    <style>
        #preloader {
            background: white url("<?php echo asset('toko/production/images/loading.gif') ?>") no-repeat center center;
            height: 100vh;
            width: 100%;
            position: fixed;
            z-index: 99999;
            opacity: 50%;
        }
    </style>
    <!--CSS============================================= -->
    <link rel="stylesheet" href="{{asset('customer/css/linearicons.css')}}">
    <link rel="stylesheet" href="{{asset('customer/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('customer/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('customer/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('customer/css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('customer/css/nouislider.min.css')}}">
    <link rel="stylesheet" href="{{asset('customer/css/ion.rangeSlider.css')}}" />
    <link rel="stylesheet" href="{{asset('customer/css/ion.rangeSlider.skinFlat.css')}}" />
    <link rel="stylesheet" href="{{asset('customer/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('customer/css/main.css')}}">
    <title>Cek Ongkir Raja Ongkir</title>
</head>

<body>
    <div id="preloader" class="preloader"></div>
    <!-- Header -->
    <header class="header_area sticky-header">
        <div class="main_menu">
            <nav class="navbar navbar-expand-lg navbar-light main_box">
                <div class="container">
                    <!-- Logo Brand Dinamis -->
                    <a class="navbar-brand logo_h" href="/"><img src="{{asset('toko/production/images/favicon.ico')}}"
                            alt="" width="40%" height="40%"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                        <ul class="nav navbar-nav menu_nav ml-auto">
                            @if($pageactive == "home")
                            <li class="nav-item active">
                                @else
                            <li class="nav-item">
                                @endif
                                <a class="nav-link" href="/">Home</a>
                            </li>
                            <li class="nav-item submenu dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false">Shop</a>
                                <ul class="dropdown-menu">
                                    <!-- shop -->
                                    @if($pageactive == "shop")
                                    <li class="nav-item active">
                                        @else
                                    <li class="nav-item">
                                        @endif
                                        <a class="nav-link" href="/shop">Shop Category</a>
                                    </li>
                                    <!-- detail produk -->
                                    <!-- Kosong -->
                                    <!-- end -->
                                    @if(auth()->user())
                                    <!-- checkoutkelihatannya gabung sama cart deh -->
                                    <!-- <li class="nav-item"><a class="nav-link" href="/shop/checkout">Product Checkout</a></li> -->
                                    <!-- end checkout -->

                                    <!-- cart -->
                                    @if($pageactive == "cart")
                                    <li class="nav-item active">
                                        @else
                                    <li class="nav-item">
                                        @endif
                                        <a class="nav-link" href="/cart">Shopping Cart</a>
                                    </li>
                                    <!-- invoice ya ga kelihatan deh keluar setelah check out -->
                                    <!-- <li class="nav-item"><a class="nav-link" href="/shop/checkout/invoice">Confirmation</a>
								</li> -->
                                    <!-- end invoice -->
                                    @endif
                                </ul>
                            </li>
                            <li class="nav-item submenu dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false">Tracking</a>
                                <ul class="dropdown-menu">
                                    @if($pageactive == "tracking")
                                    <li class="nav-item active">
                                        @else
                                    <li class="nav-item">
                                        @endif
                                        <a class="nav-link" href="/tracking">Tracking</a>
                                    </li>
                                    @if($pageactive == "trackingcustom")
                                    <li class="nav-item active">
                                        @else
                                    <li class="nav-item">
                                        @endif
                                        <a class="nav-link" href="/trackingcustom">Tracking Custom</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item submenu dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false">Pages</a>
                                <ul class="dropdown-menu">
                                    @if($pageactive == "listumkm")
                                    <li class="nav-item active">
                                        @else
                                    <li class="nav-item">
                                        @endif
                                        <a class="nav-link" href="/list">List UMKM</a>
                                    </li>
                                    @if($pageactive == "customs")
                                    <li class="nav-item active">
                                        @else
                                    <li class="nav-item">
                                        @endif
                                        <a class="nav-link" href="/custom">Custom Order</a>
                                    </li>
                                    @if($pageactive == "pembayaran")
                                    <li class="nav-item active">
                                        @else
                                    <li class="nav-item">
                                        @endif
                                        <a class="nav-link" href="/portal">Pembayaran</a>
                                    </li>
                                    @if($pageactive == "promo")
                                    <li class="nav-item active">
                                        @else
                                    <li class="nav-item">
                                        @endif
                                        <a class="nav-link" href="/coupon">Promo</a>
                                    </li>
                                </ul>
                            </li>
                            @if($pageactive == "contact")
                            <li class="nav-item active">
                                @else
                            <li class="nav-item">
                                @endif<a class="nav-link" href="/contact">Contact</a>
                            </li>
                            @if(auth()->user() == null)
                            @if($pageactive == "login")
                            <li class="nav-item active">
                                @else
                            <li class="nav-item">
                                @endif<a class="nav-link" href="/login">Login</a>
                            </li>
                            @endif
                            @if(auth()->user())
                            <li class="nav-item submenu dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false"><span
                                        class="ti-user"></span>&nbsp;&nbsp;Hi,
                                    {{ auth()->user()->username }}</a>
                                <ul class="dropdown-menu">
                                    @if(auth()->user()->role!="produksi")
                                    <li class="nav-item">
                                        <a class="nav-link" href="/profile">
                                            <span class="ti-user"></span>
                                            &nbsp;&nbsp;Profile
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/history">
                                            <span class="ti-shopping-cart-full"></span>
                                            &nbsp;&nbsp;Histori
                                        </a>
                                    </li>
                                    @endif
                                    @if(auth()->user()->role=="super" || auth()->user()->role=="admin")
                                    <li class="nav-item">
                                        <a class="nav-link" href="/admin" target="_blank">
                                            <span class="ti-dashboard"></span>
                                            &nbsp;&nbsp;Dashboard
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/error">
                                            <span class="ti-na"></span>
                                            &nbsp;&nbsp;Error
                                        </a>
                                    </li>
                                    @endif
                                    @if(auth()->user()->role=="produksi")
                                    <li class="nav-item">
                                        <a class="nav-link" href="/produksi" target="_blank">
                                            <span class="ti-dashboard"></span>
                                            &nbsp;&nbsp;Produksi
                                        </a>
                                    </li>
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link" href="/logout">
                                            <span class="ti-shift-right"></span>
                                            &nbsp;&nbsp;Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            @if(auth()->user() && auth()->user()->role != "produksi")
                            <li class="nav-item active"><a href="/cart" class="cart">
                                    <span class="ti-bag">
                                        {{ App\Models\Carts::where('users_id','=',auth()->user()->id)
                                        ->count();
                                        }}
                                    </span>
                                </a>
                            </li>
                            @else
                            <li class="nav-item active"><a href="/login" class="cart">
                                    <span class="ti-bag">
                                        <sup>0</sup>
                                    </span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <!-- Header -->
    <div class="container" style="position: relative;top: 100px;margin-top: 50px;margin-bottom: 175px;">
        <div class="row">
            <!-- form -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Cek Ongkir
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" role="form" action="{{ route('ongkir.store') }}" method="post">
                            @csrf
                            <div class="form-group-sm">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Data UMKM</label>
                                        <select name="cbumkm" id="cbumkm" class="form-control" required>
                                            <option value="" selected disabled>
                                                --Pilih UMKM--
                                            </option>
                                            @forelse($list_umkm as $liumkm)
                                            <option value="{{ $liumkm->umkm_name }}"
                                                data-province="{{ $liumkm->province }}" data-city="{{ $liumkm->city }}">
                                                <span style="text-transform:uppercase;">
                                                    {{ $liumkm->umkm_name }}
                                                </span>
                                            </option>
                                            @empty
                                            <option value="">Kosong</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Provinsi Asal</label>
                                        <input type="text" class="form-control" name="provinsiasal" readonly required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Kota Asal</label>
                                        <input type="text" class="form-control" name="kotaasal" readonly required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Provinsi Tujuan</label>
                                        <select name="cbprovinsitujuan" id="cbprovinsitujuan" class="form-control"
                                            required>
                                            <option value="" selected disabled>--Provinsi--</option>
                                            @forelse($provinces as $province=> $value)
                                            <option value="{{ $province }}">{{ $value }}</option>
                                            @empty
                                            <option value="" selected disabled>Data Kosong</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Kota Tujuan</label>
                                        <select name="cbkotatujuan" id="cbkotatujuan" class="form-control" required>
                                            <option value="" selected disabled>--Kota--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Berat (g)</label>
                                        <input type="number" name="weight" id="" class="form-control" value="1000"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Kurir</label>
                                        <select name="cbkurir" id="" class="form-control" required>
                                            <option value="" selected disabled>--Kurir--</option>
                                            @forelse($couriers as $courier=> $value)
                                            <option value="{{ $courier }}">{{ $value }}</option>
                                            @empty
                                            <option value="" selected disabled>Data Kosong</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Cek Harga Ongkir</button>
                                <a href="javascript:history.back();" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- hasil -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        List Data Pengiriman
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Nama Jasa</td>
                                    <td>Estimasi Pengiriman (Day)</td>
                                    <td>Harga Jasa Pengiriman</td>
                                    <td>Catatan</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cost as $data_ongkir => $item)
                                <tr>
                                    <td>{{ $item['name'] }}&nbsp;
                                        "{{ $item['costs'][0]['service'] }}"
                                    </td>
                                    <td>
                                        {{ $item['costs'][0]['cost'][0]['etd'] }} Hari
                                    </td>
                                    <td>
                                        Rp. {{number_format($item['costs'][0]['cost'][0]['value'],2,',','.')}}
                                    </td>
                                    <td>
                                        {{ $item['costs'][0]['cost'][0]['note'] }}
                                    </td>
                                </tr>
                                @if(isset($item['costs'][1]))
                                <tr>
                                    <td>{{ $item['name'] }}&nbsp;
                                        "{{ $item['costs'][1]['service'] }}"
                                    </td>
                                    <td>
                                        {{ $item['costs'][1]['cost'][0]['etd'] }} Hari
                                    </td>
                                    <td>
                                        Rp. {{number_format($item['costs'][1]['cost'][0]['value'],2,',','.')}}
                                    </td>
                                    <td>
                                        {{ $item['costs'][1]['cost'][0]['note'] }}
                                    </td>
                                </tr>
                                @endif
                                @if(isset($item['costs'][2]))
                                <tr>
                                    <td>{{ $item['name'] }}&nbsp;
                                        "{{ $item['costs'][2]['service'] }}"
                                    </td>
                                    <td>
                                        {{ $item['costs'][2]['cost'][0]['etd'] }} Hari
                                    </td>
                                    <td>
                                        Rp. {{number_format($item['costs'][2]['cost'][0]['value'],2,',','.')}}
                                    </td>
                                    <td>
                                        {{ $item['costs'][2]['cost'][0]['note'] }}
                                    </td>
                                </tr>
                                @endif
                                @empty
                                <tr>
                                    <td colspan="4">Data Kosong</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- start footer Area -->
    <footer class="footer-area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-3  col-md-6 col-sm-6">
                    <div class="single-footer-widget">
                        <h6>About Us</h6>
                        @if(isset($info->description_umkm))
                        <p>
                            {{ $info->description_umkm }} <br>
                            {{ $info->description_lainnya }}
                        </p>
                        @else
                        <p>Kosong</p>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4  col-md-6 col-sm-6">
                    <div class="single-footer-widget">
                        <h6>Our Information</h6>
                        <p>Stay update with our latest</p>
                        <div class="" id="mc_embed_signup">
                            <ul>
                                <li>Nomor Admin (WA) :&nbsp;
                                    @if(isset($info->no_wa))
                                    <a href="https://wa.me/{{ $info->no_wa }}" target="_blank">
                                        {{ $info->no_wa }}
                                    </a>
                                    @else
                                    <a href="#" target="_blank">
                                        <p>Silahkan hubungi admin</p>
                                    </a>
                                    @endif
                                </li>
                                <li>Alamat Toko :&nbsp;
                                    @if(isset($info->alamat))
                                    <a href="https://google.com/maps/search/{{ $info->alamat }}" target="_blank">
                                        {{ $info->alamat }}
                                    </a>
                                    @else
                                    <a href="#" target="_blank">
                                        <p>Silahkan hubungi admin</p>
                                    </a>
                                    @endif
                                </li>
                                <li>Tokopedia Official Store :&nbsp;
                                    @if(isset($info->link_tokped))
                                    <a href="{{ $info->link_tokped }}" target="_blank">
                                        {{ $info->link_tokped }}
                                    </a>
                                    @else
                                    <a href="#" target="_blank">
                                        <p>Silahkan hubungi admin</p>
                                    </a>
                                    @endif
                                </li>
                                <li>Shopee Official Store :&nbsp;
                                    @if(isset($info->link_shopee))
                                    <a href="{{ $info->link_shopee }}" target="_blank">
                                        {{ $info->link_shopee }}
                                    </a>
                                    @else
                                    <a href="#" target="_blank">
                                        <p>Silahkan hubungi admin</p>
                                    </a>
                                    @endif
                                </li>
                                <li>Instagram Official Store :&nbsp;
                                    @if(isset($info->link_instagram))
                                    <a href="{{ $info->link_instagram }}" target="_blank">
                                        {{ $info->link_instagram }}
                                    </a>
                                    @else
                                    <a href="#" target="_blank">
                                        <p>Silahkan hubungi admin</p>
                                    </a>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3  col-md-6 col-sm-6">
                    <div class="single-footer-widget mail-chimp">
                        <h6 class="mb-20">Instragram Feed</h6>
                        <ul class="instafeed d-flex flex-wrap">
                            <li><img src="img/i1.jpg" alt=""></li>
                            <li><img src="img/i2.jpg" alt=""></li>
                            <li><img src="img/i3.jpg" alt=""></li>
                            <li><img src="img/i4.jpg" alt=""></li>
                            <li><img src="img/i5.jpg" alt=""></li>
                            <li><img src="img/i6.jpg" alt=""></li>
                            <li><img src="img/i7.jpg" alt=""></li>
                            <li><img src="img/i8.jpg" alt=""></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="single-footer-widget">
                        <h6>For more our product :</h6>
                        <p>Click our official market</p>
                        <div class="footer-social d-flex align-items-center">
                            @if(isset($info->link_instagram))
                            <a href="{{ $info->link_instagram }}" target="_blank"><i class="fa fa-instagram"></i></a>
                            @else
                            <a href="#" target="_blank"><i class="fa fa-instagram"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
                <p class="footer-text m-0">
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script> All rights reserved | This template is made with
                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                </p>
            </div>
        </div>
    </footer>
    <!-- End footer Area -->
    <script src="{{asset('customer/js/vendor/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('customer/js/vendor/copycode.js')}}"></script>
    <script src="{{asset('customer/js/vendor/raja_ongkir.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous">
    </script>
    <script src="{{asset('customer/js/vendor/bootstrap.min.js')}}"></script>
    <script src="{{asset('customer/js/jquery.ajaxchimp.min.js')}}"></script>
    <script src="{{asset('customer/js/jquery.sticky.js')}}"></script>
    <script src="{{asset('customer/js/nouislider.min.js')}}"></script>
    <script src="{{asset('customer/js/countdown.js')}}"></script>
    <script src="{{asset('customer/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('customer/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('customer/js/main.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        var loader = document.getElementById('preloader');

        window.addEventListener("load", function() {
            loader.style.display = "none";
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>