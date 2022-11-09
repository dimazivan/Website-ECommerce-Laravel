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
                    <a href="/transaksi_pembelian">Data Transaksi Pembelian</a>&nbsp;
                    <small>
                        <i class="fa fa-long-arrow-right">
                    </small></i>
                    <a href="#">Detail Transaksi Pembelian</a>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Detail Transaksi Pembelian <small>ID : {{ $page[0]->id_pembelian }}</small></h2>
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
                                    Data User
                                    <address>
                                        <strong>{{ $page[0]->nama_depan }}&nbsp;{{ $page[0]->nama_belakang }}</strong>
                                        <br>"{{ $page[0]->alamat }},
                                        {{ $page[0]->kecamatan }},
                                        {{ $page[0]->kelurahan }},
                                        {{ $page[0]->kota }},
                                        {{ $page[0]->provinsi }}"
                                        <br>Kode Pos :&nbsp;{{ $page[0]->kode_pos }}
                                        <br>Phone :<a href="https://wa.me/aaaa" target="_blank">
                                            {{ $page[0]->no_telp }}
                                        </a>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Transaction Id:&nbsp;</b>{{ $page[0]->id_pembelian }}
                                    <br>
                                    <b>Trasaction Order:&nbsp;</b>{{ $page[0]->date }}
                                    <br>
                                    <b>User Id:&nbsp;</b> {{ $page[0]->id_user }}
                                    @if($page[0]->updated_at)
                                    <br>
                                    <b>Last Updated:&nbsp;</b> {{ $page[0]->updated_at }}
                                    @endif
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
                                                <th>Nama Material</th>
                                                <th>Nama Supplier</th>
                                                <th>Jumlah Beli (Pcs)</th>
                                                <th>Harga Material (Pcs)</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($detail as $material)
                                            <tr>
                                                <td>{{ $material->name_material }}</td>
                                                <td>{{ $material->nama_suppliers }}</td>
                                                <td>{{ $material->qty }} Pcs</td>
                                                <td>Rp. {{number_format($material->price,2,',','.')}}</td>
                                                <td>Rp. {{number_format($material->subtotal,2,',','.')}}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4">Data Kosong....</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
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
                                                    <tr>
                                                        <td colspan="4">Pesanan Siap</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6" style="margin-top:30px;">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th style="width:50%;">Promo:</th>
                                                    <td>Rp. 0</td>
                                                </tr>
                                                <tr>
                                                    <th style="width:50%;">Pajak:</th>
                                                    <td>Rp. 0</td>
                                                </tr>
                                                <tr>
                                                    <th>Ongkir:</th>
                                                    <td>Rp. 0</td>
                                                </tr>
                                                <tr>
                                                    <th>Total:</th>
                                                    <td>Rp. {{number_format($page[0]->total,2,',','.')}}&nbsp;
                                                        <span class="badge badge-success">Lunas</span>
                                                    </td>
                                                </tr>
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
                                    <a href="/transaksi_pembelian" class="btn btn-primary pull-right"
                                        style="margin-right: 5px;"><i class="fa fa-arrow-left"></i> Kembali</a>
                                </div>
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