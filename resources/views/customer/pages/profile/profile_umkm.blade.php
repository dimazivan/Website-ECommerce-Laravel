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
                <h1>Contact Us</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Contact</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Contact Area =================-->
<section class="contact_area section_gap_bottom">
    <div class="container">
        <br><br><br>
        <div class="row">
            <div class="col-lg-3">
                <div class="contact_info">
                    <div class="info_item">
                        <i class="lnr lnr-home"></i>
                        <h6>Alamat Toko</h6>
                        @if(isset($info->alamat))
                        <a href="https://google.com/maps/search/{{ $info->alamat }}" target="_blank">
                            <p>{{ $info->alamat }}</p>
                        </a>
                        @else
                        <a href="#" target="_blank">
                            <p>Silahkan hubungi admin</p>
                        </a>
                        @endif
                    </div>
                    <div class="info_item">
                        <i class="lnr lnr-phone-handset"></i>
                        <h6>
                            Nomor WhatsApp Admin
                        </h6>
                        <p>
                            @if(isset($info->no_wa))
                            <a href="https://wa.me/{{ $info->no_wa }}" target="_blank">
                                {{ $info->no_wa }}
                            </a><br>
                            ( {{ \Carbon\Carbon::createFromFormat('H:i:s',$info->jam_buka)->format('h:i A') }} -
                            {{ \Carbon\Carbon::createFromFormat('H:i:s',$info->jam_tutup)->format('h:i A') }} )
                            @else
                            <a href="#" target="_blank">
                                <p>Silahkan hubungi admin</p>
                            </a>
                            @endif
                        </p>
                    </div>
                    <div class="info_item">
                        <i class="lnr lnr-envelope"></i>
                        <h6>Email</h6>
                        <p>
                            @if(isset($info->link_email))
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&to={{ $info->link_email }}"
                                target="_blank">
                                {{ $info->link_email }}
                            </a>
                            @else
                            <a href="#" target="_blank">
                                <p>Silahkan hubungi admin</p>
                            </a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <strong>
                    <h3>
                        INFORMATIONS
                    </h3>
                </strong>
                <!-- Kasih Informations Tabel ? -->
                @if(isset($info->description_umkm))
                <p>{{ $info->description_umkm }}</p>
                @else
                <p>Silahkan hubungi admin</p>
                @endif
                @if(isset($info->description_product) && isset($info->description_detail))
                <p>{{ $info->description_product }}</p>
                <p>{{ $info->description_detail }}</p>
                @else
                <p>Silahkan hubungi admin</p>
                @endif
                @if(isset($info->description_lainnya))
                <p>{{ $info->description_lainnya }}</p>
                @else
                <p>Silahkan hubungi admin</p>
                @endif
            </div>
            <div class="col-lg-3">
                <div class="contact_info">
                    <div class="info_item">
                        <i class="lnr lnr-paperclip"></i>
                        <h6>Social Media</h6>
                        @if(isset($info->link_instagram))
                        <a href="https://www.instagram.com/{{ $info->link_instagram }}/" target="_blank">
                            <p>{{ $info->link_instagram }}</p>
                        </a>
                        @else
                        <a href="#" target="_blank">
                            <p>Silahkan hubungi admin</p>
                        </a>
                        @endif
                    </div>
                    <div class="info_item">
                        <i class="lnr lnr-store"></i>
                        <h6>
                            Tokopedia
                        </h6>
                        <p>
                            @if(isset($info->link_tokped))
                            <a href="https://www.tokopedia.com/{{ $info->link_tokped }}" target="_blank">
                                {{ $info->link_tokped }}
                            </a>
                            @else
                            <a href="#" target="_blank">
                                <p>Silahkan hubungi admin</p>
                            </a>
                            @endif
                        </p>
                    </div>
                    <div class="info_item">
                        <i class="lnr lnr-store"></i>
                        <h6>Shopee</h6>
                        <p>
                            @if(isset($info->link_shopee))
                            <a href="https://shopee.co.id/search?keyword={{ $info->link_shopee }}" target="_blank">
                                {{ $info->link_shopee }}
                            </a>
                            @else
                            <a href="#" target="_blank">
                                <p>Silahkan hubungi admin</p>
                            </a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================Contact Area =================-->
@endsection