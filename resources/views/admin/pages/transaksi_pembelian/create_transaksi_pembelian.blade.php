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
                    <a href="/transaksi_pembelian">Data Transaksi Pembelian</a>&nbsp;<small><i
                            class="fa fa-long-arrow-right"></small></i>
                    <a>Tambah Data Transaksi Pembelian</a>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Form Tambah Data Transaksi Pembelian</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a href="#" class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <p>
                            Data Transaksi Pembelian merupakan catatan transaksi pembelian untuk bahan baku
                            yang akan disimpan pada sistem
                        </p>
                        <span class="section">Data Transaksi Pembelian</span>
                        <!-- Tanggal -->
                        <form class="" action="{{ route('arr_pembelian.store') }}" method="post" validate
                            enctype="multipart/form-data">
                            @csrf
                            <div class="field item form-group">
                                <label class="col-form-label label-align">
                                    Tanggal Beli
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-2 col-sm-2" style="margin-left:13px;">
                                    <input type="date" class="form-control has-feedback-left" placeholder="Tanggal Beli"
                                        required="required" name="date">
                                    <span class="fa fa-cloud form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <label class="col-form-label label-align">
                                    Tanggal Pengiriman
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-2 col-sm-2">
                                    <input type="date" class="form-control has-feedback-left"
                                        placeholder="Tanggal Pengiriman" required="required" name="date_pengiriman">
                                    <span class="fa fa-cloud form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <label class="col-form-label label-align">
                                    Tanggal Penerimaan
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-2 col-sm-2">
                                    <input type="date" class="form-control has-feedback-left"
                                        placeholder="Tanggal Penerimaan" required="required" name="date_penerimaan">
                                    <span class="fa fa-cloud form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <label class="col-form-label label-align">
                                    Total (Rp)
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-2 col-sm-2">
                                    <input type="number" class="form-control has-feedback-left"
                                        placeholder="Total Keseluruhan" id="total" name="totalhidden"
                                        value="{{ $total }}" hidden>
                                    <input type="number" class="form-control has-feedback-left"
                                        placeholder="Rp. {{number_format($total,2,',','.')}}" id="total" name="total"
                                        readonly>
                                    <span class="fa fa-cloud form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <br>
                            <small>
                                Note: Jika Anda memilih nama barang yang sama maka data akan
                                diakumulasikan
                            </small>
                            <input type="text" value="{{ $idumkm }}" name="umkms_id" hidden>
                            <!-- Form -->
                            <div class="field item form-group">
                                <label class="col-form-label label-align">
                                    Nama Material
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-2 col-sm-2">
                                    <select class="select2_single form-control" id="cbname" name="cbname">
                                        <option selected disabled>Pilih Material</option>
                                        @forelse($material as $bahan)
                                        <option value="{{ $bahan->name }}" data-price="{{ $bahan->price }}">
                                            <span style="text-transform:uppercase;">
                                                {{ $bahan->name }}
                                            </span>
                                        </option>
                                        @empty
                                        <option value="">Kosong</option>
                                        @endforelse
                                    </select>
                                </div>
                                <label class="col-form-label label-align">
                                    Nama Supplier
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-2 col-sm-2">
                                    <select class="select2_single form-control" id="cbsup" name="cbsup">
                                        <option selected disabled>Pilih Supplier</option>
                                        @forelse($supplier as $sup)
                                        <option value="{{ $sup->id }}">
                                            <span style="text-transform:uppercase;">
                                                {{ $sup->name }}
                                            </span>
                                        </option>
                                        @empty
                                        <option value="">Kosong</option>
                                        @endforelse
                                    </select>
                                </div>
                                <label class="col-form-label label-align">
                                    Jumlah Beli (Pcs)
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-1 col-sm-1">
                                    <input type="number" class="form-control has-feedback-left"
                                        placeholder="Jumlah Beli (pcs)"
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)" id="qty"
                                        required="required" name="qty" min="1">
                                    <span class="fa fa-cloud form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <label class="col-form-label label-align">
                                    Harga (Rp)
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-2 col-sm-2">
                                    <input type="number" class="form-control has-feedback-left"
                                        placeholder="Harga Material (pcs)"
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)" id="price"
                                        required="required" name="price" min="1">
                                    <span class="fa fa-cloud form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <label class="col-form-label label-align">
                                    SubTotal (Rp)
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-2 col-sm-2">
                                    <input type="number" class="form-control has-feedback-left"
                                        placeholder="SubTotal Material (pcs)"
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)" id="sub"
                                        required="required" name="sub" readonly>
                                    <span class="fa fa-cloud form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="ln_solid">
                                <div class="form-group">
                                    <div class="col-md-3" style="margin-left:-10px;">
                                        <br>
                                        <button type='submit' class="btn btn-primary">Tambah</button>
                                        <a href="/arr_pembelian/simpan/{{ auth()->user()->id }}"
                                            class="btn btn-success">Selesai</a>
                                        <button type='reset' class="btn btn-warning">Reset</button>
                                        <a href="/transaksi_pembelian" class="btn btn-danger">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <h2>Item Data Transaksi Pembelian Anda</h2>
                        <table id="datatable-responsive"
                            class="table table-striped table-hover table-bordered dt-responsive nowrap" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>Nama Material</th>
                                    <th>Nama Supplier</th>
                                    <th>Jumlah Beli (pcs)</th>
                                    <th>Harga Beli (pcs)</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($arr_data as $data)
                                <tr>
                                    <td>{{ $data->name_material }}</td>
                                    <td>{{ $data->nama_sup }}</td>
                                    <td>{{ $data->qty }} pcs</td>
                                    <td>Rp. {{number_format($data->price,2,',','.')}}</td>
                                    <td>Rp. {{number_format($data->subtotal,2,',','.')}}</td>
                                    @if(auth()->user()->role == "admin")
                                    <td>
                                        <form action="{{route('arr_pembelian.destroy', $data->id_arr)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-xs"><i
                                                    class="fa fa-trash-o"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">Data Transaksi Pembelian Kosong</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>List Data Transaksi Pembelian</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a href="#" class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Nama Admin</th>
                                    <th>Tanggal Input</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($page as $item)
                                <tr>
                                    <td style="text-transform:uppercase;">
                                        {{ $item->nama_depan }}&nbsp;{{ $item->nama_belakang }}
                                    </td>
                                    <td>{{ $item->date }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">Data Transaksi Pembelian Kosong</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<script>
    // Repeater
    // jQuery(function() {
    //     $(".tambah").on("click", function() {
    //         alert('test');
    //         var tambah = $(".item-clone").clone();
    //         tambah.removeClass("item-clone");
    //         tambah.appendTo('#form-repeater');
    //     })

    //     $(".test").on("click", function() {
    //         alert('test');
    //         console.log('test');
    //     })
    // });
</script>
@endsection