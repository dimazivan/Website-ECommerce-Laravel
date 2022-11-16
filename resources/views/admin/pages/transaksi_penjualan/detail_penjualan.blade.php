@extends('admin.layouts.app')
@section('title')
{{ $title }}
@endsection
@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <p>
                    <a href="/admin">Home</a>&nbsp;<small><i class="fa fa-long-arrow-right"></small></i>
                    <a href="/transaksi_penjualan">Data Transaksi Penjualan</a>&nbsp;
                    <small>
                        <i class="fa fa-long-arrow-right">
                    </small></i>
                    <a href="#">Detail Transaksi Penjualan</a>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Detail Transaksi Penjualan <small>ID : {{ $page[0]->orders_id }}</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <section class="content invoice">
                            <div class="row invoice-info">
                                <div class="col-sm-8 invoice-col">
                                    Data Customer
                                    <address>
                                        <strong>{{ $page[0]->first_name }}&nbsp;{{ $page[0]->last_name }}</strong>
                                        <br>"{{ $page[0]->address }},
                                        {{ $page[0]->districts }},
                                        {{ $page[0]->ward }},
                                        {{ $page[0]->city }},
                                        {{ $page[0]->province }}"
                                        <br>Kode Pos&nbsp;{{ $page[0]->postal_code }}
                                        <br>Phone :<a href="https://wa.me/{{ $page[0]->phone }}" target="_blank">
                                            {{ $page[0]->phone }}
                                        </a>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Transaction Id:&nbsp;</b>{{ $page[0]->orders_id }}
                                    <br>
                                    <b>Trasaction Order:&nbsp;</b>{{ $page[0]->date }}
                                    @if($page[0]->updated_at)
                                    <br>
                                    <b>Last Updated:&nbsp;</b> {{ $page[0]->updated_at }}
                                    @endif
                                    <br>
                                    <b>Status Transaksi:&nbsp;</b> {{ $page[0]->status }}
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            <!-- Table row -->
                            <div class="row">
                                <div class="table">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Produk</th>
                                                <th>Kategori Produk (Warna)</th>
                                                <th>Ukuran Produk</th>
                                                <th>Jumlah Beli (Pcs)</th>
                                                <th>Stok sekarang (Pcs)</th>
                                                <th>Harga Produk (Pcs)</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($cart as $produk)
                                            <tr>
                                                @if($produk->pict_1 != null)
                                                <td>
                                                    <a href="{{asset('/data_produk/'.$produk->pict_1)}}"
                                                        target="_blank">
                                                        {{$produk->pict_1 = Str::limit($produk->pict_1, 15)}}
                                                    </a>
                                                </td>
                                                @else
                                                <td>Belum ada foto</td>
                                                @endif
                                                <td>{{ $produk->products_name }}</td>
                                                <td>{{ $produk->category }}&nbsp;({{ $produk->color }})</td>
                                                <td style="text-transform:uppercase;">{{ $produk->products_size }}</td>
                                                <td>{{ $produk->products_qty }} Pcs</td>
                                                <td>{{ $produk->stok_sekarang }} Pcs</td>
                                                <td>Rp. {{number_format($produk->products_price,2,',','.')}}</td>
                                                <td>Rp. {{number_format($produk->products_subtotal,2,',','.')}}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6">Data Kosong....</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <small>Jika stok produk tidak mencukupi maka otomatis pesanan akan dilanjutkan ke proses
                                    produksi.</small>
                                <div class="table">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Deskripsi Order</th>
                                                <th>Detail Alamat</th>
                                                <th>Feedback</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($page)
                                            <tr>
                                                <td>{{ $page[0]->keterangan }}</td>
                                                <td>{{ $page[0]->desc }}</td>
                                                <td>{{ $page[0]->feedback_orders }}</td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td colspan="2">Data Kosong....</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-md-6">
                                    <p class="lead">Status Produksi <span>:</span></p>
                                    <div class="text-muted well well-sm no-shadow">
                                        <div class="table">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Nama Proses</th>
                                                        <th>Status</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($page[0]->status == "Menunggu Konfirmasi")
                                                    <tr>
                                                        <td colspan="4">Pesanan belum dikonfirmasi</td>
                                                    </tr>
                                                    @elseif($page[0]->status == "Menunggu Pembayaran")
                                                    <tr>
                                                        <td colspan="4">Pesanan belum dibayar</td>
                                                    </tr>
                                                    @elseif($page[0]->status == "Menunggu Konfirmasi Pembayaran")
                                                    <tr>
                                                        <td colspan="4">Menunggu Konfirmasi Pembayaran</td>
                                                    </tr>
                                                    @elseif($page[0]->status == "Menunggu Proses Produksi")
                                                    <tr>
                                                        <td colspan="4">Menunggu Proses Produksi</td>
                                                    </tr>
                                                    @elseif($page[0]->status == "Diproses")
                                                    <tr>
                                                        <td colspan="4">Pesanan sedang diproses</td>
                                                    </tr>
                                                    @elseif($page[0]->status == "Proses Produksi")
                                                    <tr>
                                                        <td colspan="4">
                                                            <form action="{{ route('track.orders') }}" method="post"
                                                                id="track{{ $page[0]->orders_id }}" class="form"
                                                                target="_blank" novalidate="novalidate"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="text" name="id"
                                                                    value="{{ $page[0]->date }}/{{ $page[0]->orders_id }}"
                                                                    hidden>
                                                                <a href="javascript:{}"
                                                                    onclick="document.getElementById('track{{ $page[0]->orders_id }}').submit(); return false;">
                                                                    Klik Disini...
                                                                </a>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @elseif($page[0]->status == "Ditolak")
                                                    <tr>
                                                        <td colspan="4">
                                                            <a href="">Pesanan Ditolak</a>
                                                        </td>
                                                    </tr>
                                                    @else
                                                    <tr>
                                                        <td colspan="4">{{ $page[0]->status }}</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <p class="lead">Data Pembayaran</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th style="width:50%;">Promo:</th>
                                                    <td>Rp. {{number_format($page[0]->potongan,2,',','.')}}</td>
                                                </tr>
                                                <tr hidden>
                                                    <th style="width:50%;">Pajak:</th>
                                                    <input type="number" name="pajak" id="pajak" value="0" hidden>
                                                    <td>Rp. 0</td>
                                                </tr>
                                                <tr>
                                                    <th>Ongkir:</th>
                                                    <input type="number" name="ongkir" id="ongkir"
                                                        value="{{ $page[0]->ongkir }}" hidden>
                                                    <td>Rp. {{number_format($page[0]->ongkir,2,',','.')}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Total:</th>
                                                    <input type="number" name="total" id="total" value="" hidden>
                                                    <td>Rp. {{number_format($page[0]->total,2,',','.')}}&nbsp;
                                                        @if($page[0]->status_payment == "Lunas")
                                                        <span class="badge badge-success">Lunas</span>
                                                        @elseif($page[0]->status_payment == "Menunggu Pembayaran")
                                                        <span class="badge badge-warning">Belum dibayar</span>
                                                        @elseif($page[0]->status_payment ==
                                                        "Menunggu Konfirmasi Pembayaran")
                                                        <span class="badge badge-warning">Menunggu Konfirmasi
                                                            Pembayaran</span>
                                                        @elseif($page[0]->status_payment == "Menunggu Konfirmasi")
                                                        <span class="badge badge-warning">Belum dikonfirmasi</span>
                                                        @elseif($page[0]->status_payment == "Ditangguhkan")
                                                        <span class="badge badge-warning">Ditangguhkan</span>
                                                        @elseif($page[0]->status_payment == "Ditolak")
                                                        <span class="badge badge-warning">Ditolak</span>
                                                        @else
                                                        <span class="badge badge-warning">Belum dikonfirmasi</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if($page[0]->pict_payment)
                                                <tr>
                                                    <th>Bukti Pembayaran:</th>
                                                    <td>
                                                        <a href="{{asset('/data_file/pembayaran/'.$page[0]->pict_payment)}}"
                                                            target="_blank">
                                                            {{$page[0]->pict_payment =
                                                            Str::limit($page[0]->pict_payment, 15)}}
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <span hidden>
                                    {{ $waktusekarang = Carbon\Carbon::now(); }}
                                </span>
                                <div class=" ">
                                    @if($batas < $waktusekarang && $page[0]->status == "Menunggu Konfirmasi")
                                        <span>
                                            <!-- Kosong -->
                                        </span>
                                        @else
                                        <span>
                                            @if($page[0]->status == "Menunggu Konfirmasi")
                                            <a href="/transaksi_penjualan/acc/{{ Crypt::encrypt($page[0]->orders_id) }}"
                                                class="btn btn-success pull-right"><i class="fa fa-check"></i>
                                                Accept Order
                                            </a>
                                            @elseif($page[0]->status == "Menunggu Konfirmasi Pembayaran")
                                            <a href="/transaksi_penjualan/acc_pembayaran/{{ Crypt::encrypt($page[0]->orders_id) }}"
                                                class="btn btn-success pull-right"><i class="fa fa-check"></i>
                                                Accept Payment
                                            </a>
                                            <a href="/transaksi_penjualan/tolak_pembayaran/{{ Crypt::encrypt($page[0]->orders_id) }}"
                                                class="btn btn-warning pull-right"><i
                                                    class="fa fa-exclamation-circle"></i>
                                                Decline Payment
                                            </a>
                                            @elseif($page[0]->status == "Pesanan Sedang Dikirim")
                                            <a href="/transaksi_penjualan/done/{{ Crypt::encrypt($page[0]->orders_id) }}"
                                                class="btn btn-success pull-right"><i class="fa fa-check"></i>
                                                Selesai
                                            </a>
                                            @endif
                                            @if($page[0]->status == "Pesanan Siap Dikirim")
                                            <a href="/transaksi_penjualan/pengiriman/{{ Crypt::encrypt($page[0]->orders_id) }}"
                                                class="btn btn-success pull-right"><i class="fa fa-truck"></i>
                                                Pengiriman
                                            </a>
                                            @endif
                                            @if($page[0]->status == "Menunggu Konfirmasi")
                                            <a href="/transaksi_penjualan/tolak_pemesanan/{{ Crypt::encrypt($page[0]->orders_id) }}"
                                                class="btn btn-danger pull-right" style="margin-right: 5px;"><i
                                                    class="fa fa-times"></i>
                                                Decline Order
                                            </a>
                                            @endif
                                            @if($page[0]->status_payment == "Lunas")
                                            <a href="/order/invoice/{{ Crypt::encrypt($page[0]->orders_id) }}"
                                                target="_blank" class="btn btn-success pull-right"
                                                style="margin-right: 5px;"><i class="fa fa-file"></i>
                                                Cek Invoice
                                            </a>
                                            @endif
                                        </span>
                                        @endif
                                        @if(auth()->user()->role == "admin" || auth()->user()->role == "super")
                                        <a href="/transaksi_penjualan" class="btn btn-primary pull-right"
                                            style="margin-right: 5px;"><i class="fa fa-arrow-left"></i> Kembali</a>
                                        @else
                                        <a href="/produksi" class="btn btn-primary pull-right"
                                            style="margin-right: 5px;"><i class="fa fa-arrow-left"></i> Kembali</a>
                                        @endif
                                </div>
                                <span hidden>
                                    {{ $waktusekarang = 0; }}
                                </span>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection