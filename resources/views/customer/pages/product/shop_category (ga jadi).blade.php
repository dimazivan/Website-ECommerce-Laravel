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
                <h1>Category Product Page</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Shop</a>
                    <!-- <a href="category.html">Fashon Category</a> -->
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<div class="container">
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-5">
            <!-- Filter -->
            <!-- <div class="sidebar-filter mt-50"> -->
            <div class="sidebar-categories">
                <!-- <div class="top-filter-head">Product Filters</div> -->
                <form action="{{ route('shop.store') }}" method="post">
                    @csrf
                    <div class="common-filter">
                        <div class="head">Kategori</div>
                        <ul>
                            @forelse($category as $kategori)
                            @if($kategori->name == $nilaikategori)
                            <li class="filter-list"><input class="pixel-radio" type="radio" id="{{ $kategori->name }}"
                                    name="rbkategori" value="{{ $kategori->name }}" checked>
                                <label for="{{ $kategori->name }}">
                                    {{ $kategori->name }}<span>&nbsp;({{ $kategori->count }})</span>
                                </label>
                            </li>
                            @else
                            <li class="filter-list"><input class="pixel-radio" type="radio" id="{{ $kategori->name }}"
                                    name="rbkategori" value="{{ $kategori->name }}">
                                <label for="{{ $kategori->name }}">
                                    {{ $kategori->name }}<span>&nbsp;({{ $kategori->count }})</span>
                                </label>
                            </li>
                            @endif
                            @empty
                            <small>Data Kategori Kosong</small>
                            @endforelse
                        </ul>
                    </div>
                    <br>
                    <!-- end filter -->
                    <!-- color -->
                    <div class="common-filter">
                        <div class="head">Warna</div>
                        <ul>
                            @forelse($color as $warna)
                            @if($warna->name == $nilaiwarna)
                            <li class="filter-list"><input class="pixel-radio" type="radio" id="{{ $warna->name }}"
                                    name="rbwarna" value="{{ $warna->name }}" checked>
                                <label for="{{ $warna->name }}">
                                    {{ $warna->name }}
                                </label>
                            </li>
                            @else
                            <li class="filter-list"><input class="pixel-radio" type="radio" id="{{ $warna->name }}"
                                    name="rbwarna" value="{{ $warna->name }}">
                                <label for="{{ $warna->name }}">
                                    {{ $warna->name }}
                                </label>
                            </li>
                            @endif
                            @empty
                            <small>Data Warna Kosong</small>
                            @endforelse
                        </ul>
                    </div>
                    <!-- end color -->
                    <!-- {{ $nilaikategori }}
                    <br>
                    {{ $nilaiwarna }} -->
                    <br><br>
                    <button class="primary-btn" type="submit">Refresh Page</button>
                </form>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-7">
            <!-- Start Filter Bar -->
            <div class="filter-bar d-flex flex-wrap align-items-center">
                <div class="sorting"> </div>
                <div class="sorting mr-auto"> </div>
                <div class="pagination">
                    {{ $products->appends('category', $nilaikategori)->onEachSide(1)->links() }}
                </div>
            </div>
            <!-- End Filter Bar -->

            <!-- Start Best Seller -->
            <section class="lattest-product-area pb-40 category-list">
                <div class="row">
                    @forelse($products as $item)
                    <!-- single product -->
                    <div class="col-lg-4 col-md-6">
                        <div class="single-product">
                            <a href="{{asset('/data_produk/'.$item->pict_3)}}" target="_blank">
                                <img class="img-fluid" src="{{ url('/data_produk/'.$item->pict_3) }}"
                                    alt="$item->pict_1" width="200px" height="200px">
                            </a>
                            <div class="product-details">
                                <h6>
                                    {{ $item->name }}
                                </h6>
                                <div class="price">
                                    <h6>
                                        Rp. {{number_format($item->price,2,',','.')}}
                                    </h6>
                                    <h6 class="l-through">Rp. {{number_format($item->price,2,',','.')}}</h6>
                                </div>
                                <div class="prd-bottom">
                                    <a href="" class="social-info">
                                        <span class="ti-bag"></span>
                                        <p class="hover-text">add to bag</p>
                                    </a>
                                    <!-- <a href="" class="social-info">
                                        <span class="lnr lnr-heart"></span>
                                        <p class="hover-text">Wishlist</p>
                                    </a>
                                    <a href="" class="social-info">
                                        <span class="lnr lnr-sync"></span>
                                        <p class="hover-text">compare</p>
                                    </a> -->
                                    <a href="" class="social-info">
                                        <span class="lnr lnr-sync"></span>
                                        <p class="hover-text">view detail</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-lg-4 col-md-6">
                        <div class="single-product">
                            <p>Produk Tidak Tersedia</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</div>
<br>
@endsection