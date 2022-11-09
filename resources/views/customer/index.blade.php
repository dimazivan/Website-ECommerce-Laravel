@extends('customer.layouts.app')
@section('title')
{{ $title }}
@endsection
@section('content')
<!-- start banner Area -->
<section class="banner-area">
	<div class="container">
		<div class="row fullscreen align-items-center justify-content-start">
			<div class="col-lg-12">
				<div class="active-banner-slider owl-carousel">
					<!-- single-slide -->
					@forelse($banner as $itb)
					<form action="{{ route('add_cart') }}" method="post" id="cart{{$itb->product_id}}" class="form"
						novalidate="novalidate" enctype="multipart/form-data">
						@csrf
						<div class="row single-slide align-items-center d-flex">
							<div class="col-lg-5 col-md-6">
								<div class="banner-content">
									<span style="text-transform:uppercase;">
										<h1>{{ Str::limit($itb->name, 15); }}<br>
											Size : {{ $itb->size }}
										</h1>
									</span>
									<p>{{ $itb->desc }}</p>
									<div class="add-bag d-flex align-items-center">
										<input type="text" name="product_id" value="{{ $itb->product_id }}" hidden>
										<input type="text" name="product_name" value="{{ $itb->name }}" hidden>
										<input type="text" name="product_size" value="{{ $itb->size }}" hidden>
										<input type="text" name="product_category" value="{{ $itb->category }}" hidden>
										<input type="text" name="product_color" value="{{ $itb->color }}" hidden>
										<input type="text" name="product_promo" value="{{ $itb->promo }}" hidden>
										<input type="text" name="product_price" value="{{ $itb->price }}" hidden>
										<input type="text" name="product_qty" value="{{ $itb->qty }}" hidden>
										<input type="text" name="jumlah_beli" value="1" hidden>
										<input type="text" name="product_umkm_name" value="{{ $itb->umkm_name }}"
											hidden>
										@if(auth()->user())
										<a href="javascript:{}"
											onclick="document.getElementById('cart{{ $itb->product_id }}').submit(); return false;"
											class="add-btn">
											<span class="lnr lnr-cross"></span>
										</a>
										<span class="add-text text-uppercase">Add to Bag</span>
										@endif
									</div>
								</div>
							</div>
							<div class="col-lg-7">
								<div class="banner-img">
									<img class="img-fluid" src="{{ url('/data_produk/'.$itb->pict_1) }}"
										alt="{{ $itb->pict_1 }}"
										style="width:500px;height:500px;object-fit:cover;object-position:center;float:right;">
								</div>
							</div>
						</div>
					</form>
					@empty
					<!-- single-slide -->
					<div class="row single-slide">
						<div class="col-lg-5">
							<div class="banner-content">
								<h1>BRAND 2 <br>NAMA JENIS</h1>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
									incididunt ut labore et
									dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
								<div class="add-bag d-flex align-items-center">
									<a class="add-btn" href=""><span class="lnr lnr-cross"></span></a>
									<span class="add-text text-uppercase">Add to Bag</span>
								</div>
							</div>
						</div>
						<div class="col-lg-7">
							<div class="banner-img">
								<img class="img-fluid" src="{{asset('customer/img/banner/banner-img.png')}}" alt="">
							</div>
						</div>
					</div>
					@endforelse
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End banner Area -->

<!-- start features Area -->
<section class="features-area section_gap">
	<div class="container">
		<div class="row features-inner">
			<!-- single features -->
			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="single-features">
					<div class="f-icon">
						<img src="{{asset('customer/img/features/f-icon1.png')}}" alt="">
					</div>
					<h6>Support Many Delivery Couriers</h6>
					<p>Menjangkau seluruh wilayah lokasi pengiriman</p>
				</div>
			</div>
			<!-- single features -->
			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="single-features">
					<div class="f-icon">
						<img src="{{asset('customer/img/features/f-icon2.png')}}" alt="">
					</div>
					<h6>Return Policy</h6>
					<p>Tidak menerima pengembalian barang</p>
				</div>
			</div>
			<!-- single features -->
			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="single-features">
					<div class="f-icon">
						<img src="{{asset('customer/img/features/f-icon3.png')}}" alt="">
					</div>
					<h6>Customer Service</h6>
					<p>Terdapat informasi kontak yang dapat dihubungi</p>
				</div>
			</div>
			<!-- single features -->
			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="single-features">
					<div class="f-icon">
						<img src="{{asset('customer/img/features/f-icon4.png')}}" alt="">
					</div>
					<h6>Payment System</h6>
					<p>Pengecekan validasi pembayaran secara manual</p>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end features Area -->

<!-- start product Area -->
<section class="owl-carousel active-product-area section_gap">
	<!-- single product slide -->
	<div class="single-product-slider">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6 text-center">
					<div class="section-title">
						<h1>Latest Products</h1>
						@if(isset($info->description_product))
						<p>{{ $info->description_product }}</p><br>
						@else
						<p>Silahkan hubungi admin</p>
						@endif
					</div>
				</div>
			</div>
			<div class="row">
				<!-- single product -->
				@forelse($products as $item)
				<div class="col-lg-3 col-md-6">
					<div class="single-product">
						<a href="{{ route('shop.show', [$item->id]) }}" target="_blank">
							<img class="img-fluid" src="{{ url('/data_produk/'.$item->pict_3) }}" alt="$item->pict_1"
								style="width:220px;height:220px;object-fit:cover;object-position:center">
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
									<input type="text" name="product_umkm_name" value="{{ $item->umkm_name }}" hidden>
									@if(auth()->user())
									<a href="javascript:{}"
										onclick="document.getElementById('cart{{ $item->product_id }}').submit(); return false;"
										class="social-info">
										<span class="ti-bag"></span>
										<p class="hover-text">add to bag</p>
									</a>
									<!-- <button type="submit">Add</button> -->
									@endif
									<a href="{{ route('shop.show', [$item->id]) }}" target="_blank" class="social-info">
										<span class="lnr lnr-eye"></span>
										<p class="hover-text">view detail</p>
									</a>
								</div>
							</form>
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
		</div>
	</div>
	<!-- single product slide -->
	<div class="single-product-slider">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6 text-center">
					<div class="section-title">
						<h1>Popular Products</h1>
						@if(isset($info->description_product))
						<p>{{ $info->description_product }}</p><br>
						@else
						<p>Silahkan hubungi admin</p>
						@endif
					</div>
				</div>
			</div>
			<div class="row">
				<!-- Ini belom dibenerin -->
				@forelse($popular as $item)
				<div class="col-lg-3 col-md-6">
					<div class="single-product">
						<a href="{{ route('shop.show', [$item->id]) }}" target="_blank">
							<img class="img-fluid" src="{{ url('/data_produk/'.$item->pict_3) }}" alt="$item->pict_1"
								style="width:220px;height:220px;object-fit:cover;object-position:center">
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
									<input type="text" name="product_umkm_name" value="{{ $item->umkm_name }}" hidden>
									@if(auth()->user())
									<a href="javascript:{}"
										onclick="document.getElementById('cart{{ $item->product_id }}').submit(); return false;"
										class="social-info">
										<span class="ti-bag"></span>
										<p class="hover-text">add to bag</p>
									</a>
									<!-- <button type="submit">Add</button> -->
									@endif
									<a href="{{ route('shop.show', [$item->id]) }}" target="_blank" class="social-info">
										<span class="lnr lnr-eye"></span>
										<p class="hover-text">view detail</p>
									</a>
								</div>
							</form>
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
		</div>
	</div>
</section>
<!-- end product Area -->

<!-- Start Produk Obral-->
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
								<a href="#" class="title">
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
<!-- End Produk Obral-->
@endsection