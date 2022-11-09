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
                    <a href="/transaksi_custom">Data Transaksi Custom</a>&nbsp;
                    <small>
                        <i class="fa fa-long-arrow-right">
                    </small></i>
                    <a href="#">Detail Transaksi Custom</a>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Detail Transaksi Custom <small>ID : {{ $page[0]->id }}</small></h2>
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
                                    <b>Transaction Id:&nbsp;</b>{{ $page[0]->id }}
                                    <br>
                                    <b>Trasaction Due:&nbsp;</b>{{ $page[0]->date }}
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
                                <div class="  table">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Jumlah Pesan</th>
                                                <th>File Desain</th>
                                                <th style="width: 50%">Deskripsi Order</th>
                                                <th style="width: 30%">Deskripsi Alamat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $page[0]->qty }} Pcs</td>
                                                <td><a href="{{asset('/data_file/custom/'.$page[0]->pict_desain_depan)}}"
                                                        target="_blank">
                                                        {{$page[0]->pict_desain_depan =
                                                        Str::limit($page[0]->pict_desain_depan, 15)}}
                                                    </a><br>
                                                    <a href="{{asset('/data_file/custom/'.$page[0]->pict_desain_belakang)}}"
                                                        target="_blank">
                                                        {{$page[0]->pict_desain_belakang =
                                                        Str::limit($page[0]->pict_desain_belakang, 15)}}
                                                    </a>
                                                </td>
                                                <td>{{ $page[0]->keterangan }}</td>
                                                <td>{{ $page[0]->desc }}</td>
                                            </tr>
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
                                        <div class="  table">
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
                                                    @elseif($page[0]->status == "Ditolak")
                                                    <tr>
                                                        <td colspan="4">Pesanan Ditolak</td>
                                                    </tr>
                                                    @else
                                                    <tr>
                                                        <td colspan="4">Pesanan Siap</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <form action="{{ route('transaksi_custom.store') }}" method="post" validate
                                        enctype="multipart/form-data">
                                        @csrf
                                        <p class="lead">Data Pembayaran</p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th style="width:50%">Subtotal (Rp)</th>
                                                        <input type="text" name="id" value="{{ $page[0]->id }}" hidden>
                                                        <td><input type="number" name="sub" id="sub" value="0"
                                                                min="1000" placeholder="Rp." onkeyup="total();" required
                                                                oninvalid="this.setCustomValidity('Silahkan masukan total harga transaksi min Rp.1000')"
                                                                oninput="this.setCustomValidity('')"></td>
                                                    </tr>
                                                    <tr hidden>
                                                        <th>Pajak (Rp)</th>
                                                        <td><input type="number" name="pajak" id="pajak" value="0"
                                                                placeholder="Rp." onkeyup="total();" min="0"
                                                                max="999999" hidden></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Ongkir (Rp)</th>
                                                        <td><input type="number" name="ongkir" id="ongkir" value="0"
                                                                placeholder="Rp." onkeyup="total();" min="0"
                                                                max="999999" required
                                                                oninvalid="this.setCustomValidity('Silahkan masukan jumlah ongkir transaksi')"
                                                                oninput="this.setCustomValidity('')"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total:</th>
                                                        <td><input type="number" name="total" id="total"
                                                                placeholder="Rp." onkeyup="total();" readonly>&nbsp;
                                                            @if($page[0]->status_payment == "Lunas")
                                                            <span class="badge badge-success">Lunas</span>
                                                            @elseif($page[0]->status_payment == "Menunggu
                                                            Pembayaran")
                                                            <span class="badge badge-warning">Belum dibayar</span>
                                                            @elseif($page[0]->status_payment ==
                                                            "Menunggu Konfirmasi Pembayaran")
                                                            <span class="badge badge-warning">Menunggu Konfirmasi
                                                                Pembayaran</span>
                                                            @elseif($page[0]->status_payment == "Menunggu
                                                            Konfirmasi")
                                                            <span class="badge badge-warning">Belum
                                                                ditentukan</span>
                                                            @elseif($page[0]->status_payment == "Ditangguhkan")
                                                            <span class="badge badge-warning">Ditangguhkan</span>
                                                            @elseif($page[0]->status_payment == "Ditolak")
                                                            <span class="badge badge-warning">Ditolak</span>
                                                            @else
                                                            <span class="badge badge-warning">Belum
                                                                dikonfirmasi</span>
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
                            <!-- <div class="col-md-6"></div> -->
                            <!-- <div class="row no-print col-md-6" style="float:left;"> -->
                            <div class="row no-print">
                                <div class=" ">
                                    <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i>
                                        Simpan
                                    </button>
                                    <a href="/transaksi_custom/tolak_pemesanan/{{ Crypt::encrypt($page[0]->id) }}"
                                        class="btn btn-danger pull-right" style="margin-right: 5px;"><i
                                            class="fa fa-times"></i>
                                        Decline Order
                                    </a>
                                    <a href="{{ route('transaksi_custom.show',[ Crypt::encrypt($page[0]->id) ]) }}"
                                        class="btn btn-primary pull-right" style="margin-right: 5px;"><i
                                            class="fa fa-arrow-left"></i>
                                        Kembali
                                    </a>
                                </div>
                                <!-- <div class=" ">
                                    <a href="{{ route('transaksi_custom.show',[ $page[0]->id ]) }}"
                                        class="btn btn-primary pull-right" style="margin-right: 5px;"><i
                                            class="fa fa-arrow-left"></i> Kembali</a>
                                    <a href="#" class="btn btn-danger pull-right" style="margin-right: 5px;"><i
                                            class="fa fa-times"></i> Decline</a>
                                    <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i>
                                        Simpan</button>
                                </div> -->
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