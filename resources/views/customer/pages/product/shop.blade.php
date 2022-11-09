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
            <div class="sidebar-categories">
                <div class="common-filter">
                    <div class="head">Kategori</div>
                    <ul class="main-categories">
                        <li class="main-nav-list" style="text-transform: capitalize;">
                            <a href="/shop">
                                All
                            </a>
                        </li>
                        @forelse($category as $kategori)
                        <li class="main-nav-list" style="text-transform: capitalize;">
                            <a href="/shop?kategori={{ $kategori->name }}">
                                {{ $kategori->name }}
                                <span class="number">
                                    ({{ $kategori->count }})
                                </span>
                            </a>
                        </li>
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
                    <ul class="main-categories">
                        @forelse($color as $warna)
                        <li class="main-nav-list" style="text-transform: capitalize;">
                            <a
                                href="{{ route('shop.index', ['kategori' => request('kategori'), 'warna' => $warna->name]) }}">
                                {{ $warna->name }}
                                <span class="number">
                                    ({{ $warna->count }})
                                </span>
                            </a>
                        </li>
                        @empty
                        <small>Data Warna Kosong</small>
                        @endforelse
                    </ul>
                </div>
                <br>
                <div class="common-filter">
                    <div class="head">Ukuran</div>
                    <ul class="main-categories">
                        <li class="main-nav-list">
                            <a
                                href="{{ route('shop.index', ['kategori' => request('kategori'), 'warna' => request('warna'), 'ukuran' => 's']) }}">S
                            </a>
                            <a
                                href="{{ route('shop.index', ['kategori' => request('kategori'), 'warna' => request('warna'), 'ukuran' => 'm']) }}">M
                            </a>
                            <a
                                href="{{ route('shop.index', ['kategori' => request('kategori'), 'warna' => request('warna'), 'ukuran' => 'l']) }}">L
                            </a>
                            <a
                                href="{{ route('shop.index', ['kategori' => request('kategori'), 'warna' => request('warna'), 'ukuran' => 'xl']) }}">XL
                            </a>
                            <a
                                href="{{ route('shop.index', ['kategori' => request('kategori'), 'warna' => request('warna'), 'ukuran' => 'xxl']) }}">XXL
                            </a>
                            <a
                                href="{{ route('shop.index', ['kategori' => request('kategori'), 'warna' => request('warna'), 'ukuran' => 'xxxl']) }}">XXXL
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- end color -->
            </div>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-7">
            <!-- Start Filter Bar -->
            <div class="filter-bar d-flex flex-wrap align-items-center">
                <div class="sorting"> </div>
                <div class="sorting mr-auto"> </div>
                <div class="pagination">
                    @if($products->total() >= 9)
                    <!-- Mantab -->
                    {{ $products->onEachSide(1)->links() }}
                    @else
                    <a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
                    <a href="#" class="active">1</a>
                    <a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                    @endif
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
                            <a href="{{ route('shop.show', [$item->id]) }}" target="_blank">
                                <img class="img-fluid" src="{{ url('/data_produk/'.$item->pict_3) }}"
                                    alt="$item->pict_1"
                                    style="width:300px;height:300px;object-fit:cover;object-position:center">
                            </a>
                            <div class="product-details">
                                <form action="{{ route('add_cart') }}" method="post" id="cart{{$item->product_id}}"
                                    class="form" novalidate="novalidate" enctype="multipart/form-data">
                                    @csrf
                                    <a href="{{ route('shop.show', [$item->id]) }}" target="_blank">
                                        <h6>
                                            {{ $item->name }}&nbsp;"{{ $item->size }}"<br> ({{ $item->category }})
                                        </h6>
                                        <h6>
                                            "{{ $item->color }}&nbsp; EDITION"
                                        </h6>
                                        <small>
                                            Stok : {{ $item->qty }} Pcs
                                            <div class="umkm" style="float:right; color:green;">
                                                <strong>{{ $item->umkm_name }}</strong>
                                            </div>
                                        </small>
                                        <div class="price">
                                            @if($item->promo > 0)
                                            <h6>
                                                Rp. {{number_format($item->promo,2,',','.')}}
                                            </h6>
                                            <h6 class="l-through">Rp. {{number_format($item->price,2,',','.')}}</h6>
                                            @else
                                            <h6>
                                                Rp. {{number_format($item->price,2,',','.')}}
                                            </h6>
                                            @endif
                                        </div>
                                    </a>
                                    <div class="prd-bottom">
                                        <input type="text" name="product_id" value="{{ $item->product_id }}" hidden>
                                        <input type="text" name="product_name" value="{{ $item->name }}" hidden>
                                        <input type="text" name="product_size" value="{{ $item->size }}" hidden>
                                        <input type="text" name="product_category" value="{{ $item->category }}" hidden>
                                        <input type="text" name="product_color" value="{{ $item->color }}" hidden>
                                        <input type="text" name="product_promo" value="{{ $item->promo }}" hidden>
                                        <input type="text" name="product_price" value="{{ $item->price }}" hidden>
                                        <input type="text" name="product_qty" value="{{ $item->qty }}" hidden>
                                        <input type="text" name="jumlah_beli" value="1" hidden>
                                        <input type="text" name="product_umkm_name" value="{{ $item->umkm_name }}"
                                            hidden>
                                        @if(auth()->user())
                                        <a href="javascript:{}"
                                            onclick="document.getElementById('cart{{ $item->product_id }}').submit(); return false;"
                                            class="social-info">
                                            <span class="ti-bag"></span>
                                            <p class="hover-text">add to bag</p>
                                        </a>
                                        <!-- <button type="submit">Add</button> -->
                                        @endif
                                        <a href="{{ route('shop.show', [$item->id]) }}" target="_blank"
                                            class="social-info">
                                            <span class="lnr lnr-eye"></span>
                                            <p class="hover-text">view detail</p>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- </form> -->
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
<!-- <script language=javascript>
    function addcart() {
        document.form.submit();
    }
</script> -->
<br>
@endsection