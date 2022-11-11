<header class="header_area sticky-header">
	<div class="main_menu">
		<nav class="navbar navbar-expand-lg navbar-light main_box">
			<div class="container">
				<!-- Logo Brand Dinamis -->
				<a class="navbar-brand logo_h" href="/"><img src="{{asset('toko/production/images/favicon.ico')}}"
						alt="" width="40%" height="40%"></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse"
					data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
					aria-label="Toggle navigation">
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
								@if($pageactive == "cekongkir")
								<li class="nav-item active">
									@else
								<li class="nav-item">
									@endif
									<a class="nav-link" href="/ongkir">Cek Ongkir</a>
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
								aria-haspopup="true" aria-expanded="false"><span class="ti-user"></span>&nbsp;&nbsp;Hi,
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
								@endif
								@if(auth()->user()->role=="super")
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
						<li class="nav-item">
							<button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</div>
	@if(auth()->user() && auth()->user()->role != "produksi"|| auth()->user() == null)
	<div class="search_input" id="search_input_box">
		<div class="container">
			<form class="d-flex justify-content-between"
				action="{{ route('shop.index', ['kategori' => request('kategori'), 'warna' => request('warna'), 'ukuran' => request('ukuran'), 'nama' => request('nama')]) }}"
				method="get" validate enctype="multipart/form-data">
				<input type="text" class="form-control" id="search_input" placeholder="Search Here" name="nama">
				<button type="submit" class="btn"></button>
				<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
			</form>
		</div>
	</div>
	@endif
</header>