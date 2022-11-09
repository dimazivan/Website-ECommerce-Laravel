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
                                                <th width="50%">Deskripsi Order</th>
                                                <th width="50%">Detail Alamat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($page)
                                            <tr>
                                                <td>{{ $page[0]->keterangan }}</td>
                                                <td>{{ $page[0]->desc }}</td>
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
                                    <p class="lead">Form Pengiriman <span>:</span></p>
                                    <div class="text-muted well well-sm no-shadow">
                                        <form class="" action="{{ route('kirimpenjualan.store') }}" method="post"
                                            validate enctype="multipart/form-data">
                                            @csrf
                                            <div class="field item form-group col-md-12 col-sm-12 mb-0 float-left">
                                                <label class="col-form-label label-align">
                                                    Nomor Pengiriman
                                                    <span class="required">*</span>
                                                </label>
                                                <div class="col-md-10 col-sm-10">
                                                    <input type="text" name="id_orders"
                                                        value="{{ $page[0]->orders_id }}" hidden>
                                                    <input class="form-control has-feedback-left" name="noresi"
                                                        onkeydown="return /[a-z,0-9,-_, ,backspace,delete]/i.test(event.key)"
                                                        placeholder="Nomor Resi Pengiriman" required
                                                        oninvalid="this.setCustomValidity('Silahkan masukan nomor resi pengiriman')"
                                                        oninput="this.setCustomValidity('')" />
                                                    <span class="fa fa-paper-plane form-control-feedback left"
                                                        aria-hidden="true"></span>
                                                </div>
                                            </div>
                                            <div class="field item form-group col-md-12 col-sm-12 mb-0 float-left"
                                                style="margin-top:10px;margin-left:10px;">
                                                <label class="col-form-label label-align">
                                                    Jenis Pengiriman
                                                    <span class="required">*</span>
                                                </label>
                                                <div class="col-md-10 col-sm-10">
                                                    <input class="form-control has-feedback-left" name="shipping"
                                                        placeholder="Nama Jasa Ekspedisi" required
                                                        onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                                        value="{{ $page[0]->shipping }}" readonly />
                                                    <span class="fa fa-paper-plane form-control-feedback left"
                                                        aria-hidden="true"></span>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <p class="lead">Data Pembayaran</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
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
                                <div class=" ">
                                    @if($page[0]->status != "Menunggu Pengiriman")
                                    <button type="submit" class="btn btn-success pull-right"><i class="fa fa-truck"></i>
                                        Kirim
                                    </button>
                                    @endif
                                    @if($page[0]->status != "Pesanan Ditolak" &&
                                    $page[0]->status != "Selesai" &&
                                    $page[0]->status != "Pesanan Siap Dikirim" &&
                                    $page[0]->status != "Pesanan Sedang Dikirim")
                                    <a href="/transaksi_penjualan/tolak_pemesanan/{{ Crypt::encrypt($page[0]->orders_id) }}"
                                        class="btn btn-danger pull-right" style="margin-right: 5px;"><i
                                            class="fa fa-times"></i>
                                        Decline Order
                                    </a>
                                    @endif
                                    <a href="{{ route('transaksi_penjualan.show',[ Crypt::encrypt($page[0]->orders_id) ]) }}"
                                        class="btn btn-primary pull-right" style="margin-right: 5px;"><i
                                            class="fa fa-arrow-left"></i>
                                        Kembali
                                    </a>
                                </div>
                            </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection