<div class="navbar nav_title" style="border: 0;">
    @if(auth()->user()->role == "admin" || auth()->user()->role == "super")
    <a href="/admin" class="site_title">
        <!-- <img src="{{asset('toko/production/images/logo_elite.png')}}" alt=""> -->
        <!-- <i class="fa fa-etsy" aria-hidden="true"></i> -->
        <span>SISTEM INFORMASI</span>
    </a>
    @else
    <a href="#" class="site_title">
        <span>SISTEM INFORMASI</span>
    </a>
    @endif
</div>

<div class="clearfix"></div>

<!-- menu profile quick info -->
<div class="profile clearfix">
    <div class="profile_pic">
        @if(auth()->user()->role == "admin" || auth()->user()->role == "super")
        @if(auth()->user()->pict == null)
        <img src="{{asset('toko/production/images/user.png')}}" alt="..." class="img-circle profile_img">
        @else
        <img src="{{ url('/data_file/'.auth()->user()->pict) }}" alt="{{ auth()->user()->pict }}" width="20%"
            height="40%" class="img-circle profile_img">
        @endif
        @endif
    </div>
    <div class="profile_info">
        <span>Welcome back,</span>
        @if(auth()->user()->role == "admin" || auth()->user()->role == "super")
        <h2><a href="/user/{{ auth()->user()->id }}" style="color:white;">{{ auth()->user()->username }}</a></h2>
        @else
        <h2><a href="#" style="color:white;">{{ auth()->user()->username }}</a></h2>
        @endif
    </div>
</div>
<!-- /menu profile quick info -->
<br />
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>Menu Navigasi Website</h3>
        <ul class="nav side-menu">
            <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    @if(auth()->user()->role == "super" || auth()->user()->role == "admin")
                    <li><a href="/admin">Dashboard</a></li>
                    @endif
                    <li><a href="/" target="_blank">Store Page</a></li>
                </ul>
            </li>
            <!-- Data Info -->
            @if(auth()->user()->role == "super" || auth()->user()->role == "admin")
            <li><a><i class="fa fa-info"></i>Data Info Website<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/info">Tabel Info Website</a></li>
                    <li><a href="/info/create">Tambah Info Website</a></li>
                </ul>
            </li>
            @endif
            <!-- End Data Info -->
            <hr>
        </ul>
    </div>
    @if(auth()->user()->role == "super")
    <div class="menu_section">
        <h3>Menu Data User</h3>
        <ul class="nav side-menu">
            <!-- Data Customer -->
            <li><a><i class="fa fa-users"></i>Data Customer<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/pelanggan">Tabel Customer</a></li>
                </ul>
            </li>
            <!-- End Data Customer -->
            <!-- Data User -->
            <li><a><i class="fa fa-user"></i>Data User<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/user">Tabel User</a></li>
                    <li><a href="/user/create">Tambah Data User</a></li>
                </ul>
            </li>
            <!-- End Data User -->
            <hr>
        </ul>
    </div>
    @endif
    <div class="menu_section">
        <h3>Menu Transaksi</h3>
        <ul class="nav side-menu">
            @if(auth()->user()->role == "super" || auth()->user()->role == "admin")
            <li><a><i class="fa fa-inbox"></i>Cek Ongkir<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/ongkir" target="_blank">Cek Ongkir</a></li>
                </ul>
            </li>
            <!-- Data Transaksi Pembelian -->
            <li><a><i class="fa fa-inbox"></i>Transaksi Pembelian<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/transaksi_pembelian">Tabel Transaksi Pembelian</a></li>
                    <li><a href="/transaksi_pembelian/create">Tambah Transaksi Pembelian</a></li>
                </ul>
            </li>
            <!-- End Data Transaksi Pembelian -->
            <!-- Data Transaksi Penjualan -->
            <li><a><i class="fa fa-shopping-cart"></i>Transaksi Penjualan<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/transaksi_penjualan">Tabel Transaksi Penjualan</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-filter"></i>Transaksi Customize<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/transaksi_custom">Tabel Transaksi Custom</a></li>
                </ul>
            </li>
            <!-- End Data Transaksi Penjualan -->
            @endif
            <!-- Data Produksi -->
            <li><a><i class="fa fa-tasks"></i>Produksi<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/produksi">Tabel Produksi</a></li>
                    <li><a href="/produksi_custom">Tabel Produksi Custom</a></li>
                </ul>
            </li>
            <!-- End Data Produksi -->
            @if(auth()->user()->role == "super" || auth()->user()->role == "admin")
            <!-- Data EDD -->
            <li><a><i class="fa fa-clock-o"></i>Batas Pengerjaan<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/deadline">Tabel Batas Pengerjaan</a></li>
                    <li><a href="/deadline/create">Tambah Batas Pengerjaan</a></li>
                </ul>
            </li>
            <!-- End Data EDD -->
            <!-- Data Estimasi -->
            <li><a><i class="fa fa-clock-o"></i>Estimasi Produksi<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/estimasi">Tabel Estimasi Produksi</a></li>
                    <li><a href="/estimasi/create">Tambah Estimasi Produksi</a></li>
                </ul>
            </li>
            <!-- End Data Estimasi -->
            @endif
            <hr>
        </ul>
    </div>
    @if(auth()->user()->role == "super" || auth()->user()->role == "admin")
    <div class="menu_section">
        <h3>INFORMATIONS SYSTEM MENU</h3>
        <ul class="nav side-menu">
            <!-- Data Bahan Baku -->
            <li><a><i class="fa fa-dropbox"></i>Data Bahan Baku<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/bahan_baku">Tabel Bahan Baku</a></li>
                    <li><a href="/bahan_baku/create">Tambah Bahan Baku</a></li>
                </ul>
            </li>
            <!-- End Data Bahan Baku -->
            <!-- Data Jasa Ekspedisi -->
            <li><a><i class="fa fa-truck"></i>Data Jasa Ekspedisi<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/jasa_ekspedisi">Tabel Jasa Ekspedisi</a></li>
                    <li><a href="/jasa_ekspedisi/create">Tambah Data Jasa Ekspedisi</a></li>
                </ul>
            </li>
            <!-- End Data Ekspedisi -->
            <!-- Data Pembayaran -->
            <li><a><i class="fa fa-dollar"></i>Data Pembayaran<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/pembayaran">Tabel Pembayaran</a></li>
                    <li><a href="/pembayaran/create">Tambah Data Pembayaran</a></li>
                </ul>
            </li>
            <!-- End Data Pembayaran -->
            <!-- Data Produk -->
            <li><a><i class="fa fa-tag"></i>Data Produk<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/produk">Tabel Produk</a></li>
                    <li><a href="/produk/create">Tambah Data Produk</a></li>
                </ul>
            </li>
            <!-- End Data Produk -->
            <!-- Data Kategori -->
            <li><a><i class="fa fa-tag"></i>Data Kategori<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/kategori">Kategori Produk</a></li>
                    <li><a href="/kategori/create">Tambah Data Kategori Produk</a></li>
                </ul>
            </li>
            <!-- Edn Data Kategori -->
            <!-- Data Warna -->
            <li><a><i class="fa fa-tag"></i>Data Warna<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/warna">Warna Produk</a></li>
                    <li><a href="/warna/create">Tambah Data Warna Produk</a></li>
                </ul>
            </li>
            <!-- End Data Warna -->
            <!-- Data Promo -->
            <li><a><i class="fa fa-percent"></i>Data Voucher Promo<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/promo">Tabel Voucher Promo</a></li>
                    <li><a href="/promo/create">Tambah Data Voucher Promo</a></li>
                </ul>
            </li>
            <!-- End Data Promo -->
            <!-- Data Supplier -->
            <li><a><i class="fa fa-truck"></i>Data Supplier<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/supplier">Tabel Supplier</a></li>
                    <li><a href="/supplier/create">Tambah Data Supplier</a></li>
                </ul>
            </li>
            <!-- End Data Supplier -->
            <hr>
        </ul>
    </div>
    @endif
    @if(auth()->user()->role == "super")
    <div class="menu_section">
        <h3>Error Page (Testing)</h3>
        <ul class="nav side-menu">
            <li><a><i class="fa fa-check-square"></i>Testing Error<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/error/page_404">Page 404</a></li>
                </ul>
            </li>
            <hr>
        </ul>
    </div>
    @endif
</div>
<!-- /sidebar menu -->