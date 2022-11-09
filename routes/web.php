<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Produksi\ProductionController;
use App\Http\Controllers\Produksi\Production_customController;
use App\Http\Controllers\Customer\CustomController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\HistoryController;
use App\Http\Controllers\Raja_Ongkir\Raja_ongkirController;
use App\Http\Controllers\Transaction\Custom_orderController;
use App\Http\Controllers\Transaction\Arr_pembelianController;
use App\Http\Controllers\Transaction\PembelianController;
use App\Http\Controllers\Customer\Customer_orderController;
use App\Http\Controllers\Customer\TrackingController;
use App\Http\Controllers\Transaction\OrderController;
use App\Http\Controllers\HomeController;
use RealRashid\SweetAlert\Facades\Alert;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::resource('/', 'HomeController');

// Error
Route::group([
    'namespace' => 'Admin',
    'middleware' => ['auth','CekRole:admin,super,produksi']
], function () {
    // Error
    Route::get('/error/page_404', function () {
        return view('admin.pages.error.page_404');
    });
});

// LOGIN
Route::get('/login', [LoginController::class,'index'])->name('index.login');
Route::any('/login/cek', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// SUPER
Route::group([
    'namespace' => 'Admin',
    'middleware' => ['auth','CekRole:super,admin']
], function () {
    // User
    Route::resource('user', 'UserController');
});

// ADMIN
Route::group([
    'namespace' => 'Admin',
    'middleware' => ['auth','CekRole:admin,super']
], function () {
    // ADMIN
    Route::resource('admin', 'DashboardController');
    Route::post('/admin/cetak/', [DashboardController::class, 'pdflaporan'])->name('pdflaporan.dashboard');

    // Bahan Baku
    Route::resource('bahan_baku', 'MaterialController');

    // Banner
    // Route::resource('banner', 'BannerController');

    // Customer
    Route::resource('pelanggan', 'CustomerController');

    // Deadline
    Route::resource('deadline', 'DeadlineController');

    // Info
    Route::resource('info', 'InfoController');

    // Jasa Ekspedisi
    Route::resource('jasa_ekspedisi', 'ExpeditionController');

    // Pembayaran
    Route::resource('pembayaran', 'PaymentController');

    // Estimasi
    Route::resource('estimasi', 'EstimationController');

    // Produk
    Route::resource('produk', 'ProductController');
    Route::resource('detail_produk', 'Detail_productController');

    Route::resource('kategori', 'CategoryController');
    Route::resource('warna', 'ColorController');

    // Promo
    Route::resource('promo', 'PromoController');
    Route::get('/promo/activated/{id}', [PromoController::class, 'activated'])->name('activated');
    Route::get('/promo/deactivated/{id}', [PromoController::class, 'deactivated'])->name('deactivated');

    // Supplier
    Route::resource('supplier', 'SupplierController');

    // Error
    // Route::get('/error/page_404', function () {
    //     return view('admin.pages.error.page_404');
    // });
});

// PRODUKSI
Route::group([
    'namespace' => 'Produksi',
    'middleware' => ['auth','CekRole:admin,super,produksi']
], function () {
    // Produksi
    Route::resource('produksi', 'ProductionController');
    Route::get('/produksi/start/{id_order}', [ProductionController::class, 'mulaiproduksi'])->name('produksi.start');
    Route::get('/produksi/proses/start/{id_produksi}', [ProductionController::class, 'mulaiproses'])->name('produksi.mulai');
    Route::get('/produksi/repeat/{id_order}', [ProductionController::class, 'ulangproduksi'])->name('produksi.repeat');
    Route::get('/produksi/done/{id_order}', [ProductionController::class, 'selesaiproduksi'])->name('produksi.done');
    Route::get('/produksi/proses/done/{id_produksi}', [ProductionController::class, 'selesaiproses'])->name('produksi.proses');
    Route::get('/produksi/proses/pause/{id_order}', [ProductionController::class, 'berhentiproduksi'])->name('produksi.pause');
    Route::get('/produksi/status/pause/{id_produksi}', [ProductionController::class, 'berhentiproses'])->name('proses.pause');

    Route::resource('produksi_custom', 'Production_customController');
    Route::get('/produksi_custom/start/{id_customs}', [Production_customController::class, 'mulaiproduksi'])->name('custom.start');
    Route::get('/produksi_custom/proses/start/{id_produksi}', [Production_customController::class, 'mulaiproses'])->name('custom.mulai');
    Route::get('/produksi_custom/done/{id_customs}', [Production_customController::class, 'selesaiproduksi'])->name('custom.done');
    Route::get('/produksi_custom/proses/done/{id_produksi}', [Production_customController::class, 'selesaiproses'])->name('custom.proses');
    Route::get('/produksi_custom/proses/pause/{id_customs}', [Production_customController::class, 'berhentiproduksi'])->name('custom.pause');
    Route::get('/produksi_custom/status/pause/{id_produksi}', [Production_customController::class, 'berhentiproses'])->name('pause.cutom');
});

// ADMIN TRANSACTION
Route::group([
    'namespace' => 'Transaction',
    'middleware' => ['auth','CekRole:admin,super,produksi']
], function () {
    // Transaksi Pembelian
    Route::resource('transaksi_pembelian', 'PembelianController');
    Route::resource('arr_pembelian', 'Arr_pembelianController');
    Route::get('/arr_pembelian/simpan/{id_user}', [Arr_pembelianController::class, 'simpantransaksi'])->name('simpantransaksi');
    Route::post('/transaksi_pembelian/cetak/', [PembelianController::class, 'pdflaporan'])->name('pdflaporan.pembelian');

    // Transaksi Penjualan
    Route::resource('transaksi_penjualan', 'OrderController');
    Route::get('/transaksi_penjualan/acc/{id_penjualan}', [OrderController::class, 'acc_penjualan'])->name('acc_penjualan');
    Route::get('/transaksi_penjualan/acc_pembayaran/{id_penjualan}', [OrderController::class, 'accpembayaranpenjualan'])->name('accpembayaranpenjualan');
    Route::get('/transaksi_penjualan/tolak_pembayaran/{id_penjualan}', [OrderController::class, 'tolakpembayaranpenjualan'])->name('tolakpembayaranpenjualan');
    Route::get('/transaksi_penjualan/tolak_pemesanan/{id_penjualan}', [OrderController::class, 'tolakpesananpenjualan'])->name('tolakpesananpenjualan');
    Route::get('/transaksi_penjualan/done/{id_penjualan}', [OrderController::class, 'selesaipesanan'])->name('selesaipesanan');
    Route::get('/transaksi_penjualan/pengiriman/{id_penjualan}', [OrderController::class, 'formpengiriman'])->name('pengiriman.penjualan');
    Route::post('/transaksi_penjualan/kirim/', [OrderController::class, 'kirimpenjualan'])->name('kirimpenjualan.store');
    Route::post('/transaksi_penjualan/cetak/', [OrderController::class, 'pdflaporan'])->name('pdflaporan.order');

    // Transaksi Penjualan Custom
    Route::resource('transaksi_custom', 'Custom_orderController');
    Route::get('/transaksi_custom/acc/{id_custom}', [Custom_orderController::class, 'acc_custom'])->name('acc_custom');
    Route::get('/transaksi_custom/acc_pembayaran/{id_custom}', [Custom_orderController::class, 'accpembayaran'])->name('accpembayaran');
    Route::get('/transaksi_custom/tolak_pembayaran/{id_custom}', [Custom_orderController::class, 'tolakpembayaran'])->name('tolakpembayaran');
    Route::get('/transaksi_custom/tolak_pemesanan/{id_custom}', [Custom_orderController::class, 'tolakpesanan'])->name('tolakpesanan');
    Route::get('/transaksi_custom/done/{id_custom}', [Custom_orderController::class, 'selesaipesanan'])->name('selesaipesanancustom');
    Route::get('/transaksi_custom/pengiriman/{id_custom}', [Custom_orderController::class, 'formpengiriman'])->name('pengiriman.custom');
    Route::post('/transaksi_custom/kirim/', [Custom_orderController::class, 'kirimcustom'])->name('kirimcustom.store');
    Route::post('/transaksi_custom/cetak/', [Custom_orderController::class, 'pdflaporan'])->name('pdflaporan.custom');
});

// CUSTOMER LOGIN
Route::group([
    'namespace' => 'Customer',
    'middleware' => ['auth','CekRole:admin,user,super']
], function () {
    // Custom
    Route::resource('custom', 'CustomController');
    Route::get('/custom/order/{umkm_name}', [CustomController::class, 'getumkm'])->name('precustom.store');
    Route::get('/custom/bayar/{id_transaksi}', [CustomController::class, 'bayarcustom'])->name('bayarcustom.create');
    Route::post('/custom/feedback', [CustomController::class, 'feedbackcustom'])->name('custom.feedback');

    // History
    Route::resource('history', 'HistoryController');
    Route::get('/custom/invoice/{id_custom}', [HistoryController::class, 'invoicecustom'])->name('invoicecustom.show');
    Route::get('/custom/invoice/cetak/{id_custom}', [HistoryController::class, 'cetakinvoicecustom'])->name('invoicecustom.print');
    Route::get('/order/invoice/{id_orders}', [HistoryController::class, 'invoicepenjualan'])->name('invoicepenjualan.show');
    Route::get('/order/invoice/cetak/{id_orders}', [HistoryController::class, 'cetakinvoicepenjualan'])->name('invoicepenjualan.print');

    // Penjualan
    Route::resource('order', 'Customer_orderController');
    Route::get('/order/list/{id_transaksi}', [Customer_orderController::class, 'listitem'])->name('listitem.show');
    Route::get('/order/bayar/{id_transaksi}', [Customer_orderController::class, 'bayarpenjualan'])->name('bayarpenjualan.create');
    Route::post('/order/feedback', [Customer_orderController::class, 'feedbackorder'])->name('order.feedback');

    // Cart
    Route::resource('cart', 'CartController');
    Route::post('/cart/add', [CartController::class, 'add_cart'])->name('add_cart');
    Route::post('/cart/upd', [CartController::class, 'updatecart'])->name('upd.cart');
    Route::get('/cart/del/{id}', [CartController::class, 'delcart'])->name('del.cart');

    // Profile
    Route::resource('profile', 'ProfileController');
});

// TANPA LOGIN
Route::group([
    'namespace' => 'Customer',
], function () {
    // Kontak
    Route::resource('contact', 'ContactController');

    // Produk
    Route::resource('shop', 'View_productController');

    // Tracking
    Route::resource('tracking', 'TrackingController');
    Route::any('/trackingcustom', [TrackingController::class, 'indexcustom'])->name('customs.tracking');
    Route::any('/tracking/order', [TrackingController::class, 'trackingorders'])->name('track.orders');
    Route::any('/tracking/custom', [TrackingController::class, 'trackingcustoms'])->name('track.customs');

    // Promo
    Route::resource('coupon', 'CouponController');

    // Pembayaran
    Route::resource('portal', 'PembayaranController');

    // List UMKM
    Route::get('/list', [CustomController::class, 'listumkm'])->name('listumkm');
});

Route::resource('register', 'RegisterController');
Route::resource('umkm', 'RegisterumkmController');
Route::resource('reset', 'ResetController');
Route::resource('error', 'ErrorController');

// RAJA ONGKIR LOGIN
Route::group([
    'namespace' => 'Raja_ongkir',
    'middleware' => ['auth','CekRole:admin,user,super,produksi']
], function () {
    // Raja Ongkir
    Route::resource('ongkir', 'Raja_ongkirController');

    // Route::get('/ongkir/provinsi/{$id}', [Raja_ongkirController::class, 'ambilKota'])->name('kota.ambil');
    // Route::get('/cek/ongkir', [Raja_ongkirController::class, 'ongkir']);
    // Route::get('/cek/ongkir/province/{$id}', [Raja_ongkirController::class, 'ambilKota']);
});

// Tester
// Route::get('/shop/produk01', function () {
//     return view('customer.pages.detail_product');
// });

Route::fallback(function () {
    Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
    return redirect('/error');
});

// Route::fallback(function () {
//     Alert::info('Proses Gagal', 'Halaman tidak ditemukan');
//     return view('admin.pages.error.page_404');
// });
