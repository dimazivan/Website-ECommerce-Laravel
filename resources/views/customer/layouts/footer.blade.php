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