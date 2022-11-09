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
                <h1>Product Details Page</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="/shop">Shop<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Product Id : {{ $products[0]->id }}</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Single Product Area =================-->
@forelse($products as $item)
<div class="product_image_area">
    <div class="container">
        <div class="row s_product_inner">
            <div class="col-lg-6">
                <div class="s_Product_carousel">
                    <div class="single-prd-item">
                        @if(isset($item->pict_1))
                        <a href="{{asset('/data_produk/'.$item->pict_1)}}" target="_blank">
                            <img class="img-fluid" src="{{ url('/data_produk/'.$item->pict_1) }}" alt="$item->pict_1"
                                style="width:590px;height:590px;object-fit:cover;object-position:center">
                        </a>
                        @else
                        <a href="#" target="_blank">
                            <img class="img-fluid" src="#" alt="Gambar 1"
                                style="width:590px;height:590px;object-fit:cover;object-position:center">
                        </a>
                        @endif
                    </div>
                    <div class="single-prd-item">
                        @if(isset($item->pict_2))
                        <a href="{{asset('/data_produk/'.$item->pict_2)}}" target="_blank">
                            <img class="img-fluid" src="{{ url('/data_produk/'.$item->pict_2) }}" alt="$item->pict_2"
                                style="width:590px;height:590px;object-fit:cover;object-position:center">
                        </a>
                        @else
                        <a href="#" target="_blank">
                            <img class="img-fluid" src="#" alt="Gambar 2"
                                style="width:590px;height:590px;object-fit:cover;object-position:center">
                        </a>
                        @endif
                    </div>
                    <div class="single-prd-item">
                        @if(isset($item->pict_3))
                        <a href="{{asset('/data_produk/'.$item->pict_3)}}" target="_blank">
                            <img class="img-fluid" src="{{ url('/data_produk/'.$item->pict_3) }}" alt="$item->pict_3"
                                style="width:590px;height:590px;object-fit:cover;object-position:center">
                        </a>
                        @else
                        <a href="#" target="_blank">
                            <img class="img-fluid" src="#" alt="Gambar 3"
                                style="width:590px;height:590px;object-fit:cover;object-position:center">
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="s_product_text">
                    <h3 style="text-transform:uppercase;">{{ $item->name }}&nbsp;"{{ $item->size }}"</h3>
                    <h3 style="text-transform:uppercase;">"{{ $item->color }} edition"</h3>
                    @if($item->promo > 0)
                    <h2>Rp. {{number_format($item->promo,2,',','.')}}</h2>
                    <h6 class="l-through"><strike> Rp. {{number_format($item->price,2,',','.')}}</strike></h6>
                    @else
                    <h2>Rp. {{number_format($item->price,2,',','.')}}</h2>
                    @endif
                    <ul class="list">
                        <li><a class="active" href="/shop?kategori={{ $item->category }}"
                                target="_blank"><span>Category</span>:&nbsp;{{ $item->category }}</a></li>
                        <li><a href="#"><span>Availibility</span>:&nbsp;Ready In Stock ({{ $item->qty }} pcs)</a></li>
                        <li><a href="/contact/{{ $item->umkms_id }}" style="color:green;"><span>Store</span>:&nbsp;
                                {{ $item->umkm_name }}
                            </a>
                        </li>
                        <small>More than ready stock (Pre Order) Available</small>
                    </ul>
                    <p style="margin-bottom:0px;">
                    <h5>DESKRIPSI PRODUK :</h5>{{ $item->desc }}
                    </p>
                    @if(auth()->user())
                    <form action="{{ route('add_cart') }}" method="post" id="cart{{$item->product_id}}" class="form"
                        novalidate="novalidate" enctype="multipart/form-data">
                        @csrf
                        <div class="product_count">
                            <label for="qty">Quantity:</label>
                            <input type="text" name="product_id" value="{{ $item->product_id }}" hidden>
                            <input type="text" name="product_name" value="{{ $item->name }}" hidden>
                            <input type="text" name="product_size" value="{{ $item->size }}" hidden>
                            <input type="text" name="product_category" value="{{ $item->category }}" hidden>
                            <input type="text" name="product_color" value="{{ $item->color }}" hidden>
                            <input type="text" name="product_promo" value="{{ $item->promo }}" hidden>
                            <input type="text" name="product_price" value="{{ $item->price }}" hidden>
                            <input type="text" name="product_qty" value="{{ $item->qty }}" hidden>
                            <input type="text" name="product_umkm_name" value="{{ $item->umkm_name }}" hidden>
                            <input type="number" name="jumlah_beli" id="sst" maxlength="12" value="1" min="1"
                                title="Quantity:" class="input-text qty"
                                onkeydown="return /[0-9,backspace,delete]/i.test(event.key)">
                            <button
                                onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                            <button
                                onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) ,sst > 1 ) result.value--;return false;"
                                class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                        </div>
                        <div class="card_area d-flex align-items-center">
                            <button type="submit" value="submit" class="btn primary-btn">Add to cart</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>
<br><br>
<!-- <hr> -->
<br><br>
<section class="related-product-area section_gap_bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h1>Produk lainnya</h1>
                    @if(isset($info->description_detail))
                    <p>{{ $info->description_detail }}</p>
                    @else
                    <p>Silahkan hubungi admin</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    @forelse($all as $prod)
                    <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                        <div class="single-related-product d-flex">
                            <a href="{{ route('shop.show', [$prod->id]) }}" target="_blank"><img
                                    src="{{ url('/data_produk/'.$prod->pict_1) }}"
                                    alt="{{ url('/data_produk/'.$prod->pict_1) }}"
                                    style="width:100px;height:100px;object-fit:cover;object-position:center"></a>
                            <div class="desc">
                                <a href="{{ route('shop.show', [$prod->id]) }}" target="_blank" class="title">
                                    {{ $prod->name }}&nbsp;"{{ $prod->size }}"<br>
                                    ({{ $prod->category }})
                                </a>
                                <div class="price">
                                    @if($prod->promo > 0)
                                    <h6>
                                        Rp. {{number_format($prod->promo,2,',','.')}}
                                    </h6>
                                    <h6 class="l-through">Rp. {{number_format($prod->price,2,',','.')}}</h6>
                                    @else
                                    <h6>
                                        Rp. {{number_format($prod->price,2,',','.')}}
                                    </h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p>Tidak ada tawaran produk saat ini</p>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ctg-right">
                    <a href="#" target="_blank">
                        <img class="img-fluid d-block mx-auto" src="{{ url('img/category/c5.jpg') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Single Product Area =================-->
@empty
<!-- Kosong -->
<div class="product_image_area">
    <div class="container">
        <div class="row s_product_inner">
            <div class="col-lg-6">
                <div class="s_Product_carousel">
                    <div class="single-prd-item">
                        <a href="{{asset('/data_produk/'.$item->pict_1)}}" target="_blank">
                            <img class="img-fluid" src="{{ url('/data_produk/'.$item->pict_1) }}" alt="$item->pict_1"
                                style="max-height:800px;max-width:600px">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="s_product_text">
                    <h3 style="text-transform:uppercase;">Produk Tidak Ditemukan</h3>
                    <h3 style="text-transform:uppercase;">Size : ""</h3>
                    <h2>Rp. 000</h2>
                    <h6 class="l-through"><strike> Rp. 000</strike></h6>
                    <ul class="list">
                        <li><a class="active" href="" target="_blank"><span>Category</span> : </a></li>
                        <li><a href="#"><span>Availibility</span> : 0</a></li>
                        <small>More than ready stock (Pre Order) Available</small>
                    </ul>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iusto beatae magni voluptas recusandae
                        quaerat atque reiciendis sapiente corrupti neque minus.</p>
                    <form action="">
                        <div class="product_count">
                            <label for="qty">Quantity:</label>
                            <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:"
                                class="input-text qty">
                            <button
                                onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                            <button
                                onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) ,sst > 0 ) result.value--;return false;"
                                class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                        </div>
                        <div class="card_area d-flex align-items-center">
                            <button type="submit" value="submit" class="primary-btn">Add to cart</button>
                            <!-- <a class="primary-btn" href="#">Add to Cart</a> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>
<br><br>
<br><br>
<section class="related-product-area section_gap_bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h1>Produk lainnya</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore
                        magna aliqua.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    <p>Tidak ada tawaran produk saat ini</p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ctg-right">
                    <a href="#" target="_blank">
                        <img class="img-fluid d-block mx-auto" src="{{ url('img/category/c5.jpg') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endforelse

@endsection