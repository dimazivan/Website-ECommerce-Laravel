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
                    <a href="/bahan_baku">Data Bahan Baku</a>&nbsp;<small><i class="fa fa-long-arrow-right"></small></i>
                    <a href="#">Tambah Data Bahan Baku</a>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Form Tambah Data Bahan Baku</h2>
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
                        <form class="" action="{{ route('bahan_baku.store') }}" method="post" validate
                            enctype="multipart/form-data">
                            @csrf
                            <p>Masukkan data bahan baku dengan benar digunakan sebagai informasi mengenai bahan baku</p>
                            <input type="text" value="{{ $idumkm }}" name="umkms_id" hidden>
                            <span class="section">Data Bahan Baku</span>
                            @if(($errors->any()) != null)
                            @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible " role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">x</span>
                                </button>
                                {{ $error }}
                            </div>
                            @endforeach
                            @endif
                            @if(\Session::has('info'))
                            <div class="alert alert-info alert-dismissible" role="alert" data-timeout="2000">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">x</span>
                                </button>
                                <strong>{{ \Session::get('info') }}</strong>
                            </div>
                            @endif
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Bahan<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" name="name" placeholder="Nama Bahan" required
                                        onkeydown="return /[a-z, ,0-9,backspace,delete]/i.test(event.key)"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama bahan baku')"
                                        oninput="this.setCustomValidity('')" />
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Supplier<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control" id="cbsup" name="cbsup" required
                                        oninvalid="this.setCustomValidity('Silahkan pilih salah satu nama supplier')"
                                        oninput="this.setCustomValidity('')">
                                        <option selected disabled>Pilih Supplier</option>
                                        @forelse ($page as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @empty
                                        <option value="#">Data Supplier tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Harga Bahan (Rp)<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="number" name="price" required max-length="13"
                                        placeholder="Harga Bahan Baku" min="100"
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)"
                                        oninvalid="this.setCustomValidity('Silahkan masukan harga bahan baku (Rp) Min Rp. 100')"
                                        oninput="this.setCustomValidity('')" />
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Jumlah Stok (Pcs)<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="number" name="qty" required
                                        placeholder="Jumlah Stok" min="1"
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)"
                                        oninvalid="this.setCustomValidity('Silahkan masukan jumlah stok bahan baku (pcs)')"
                                        oninput="this.setCustomValidity('')" />
                                </div>
                            </div>
                            <div class="ln_solid">
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <br>
                                        <button type='submit' class="btn btn-primary">Simpan</button>
                                        <button type='reset' class="btn btn-success">Reset</button>
                                        <a href="/bahan_baku" class="btn btn-danger">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>List Data Bahan Baku</h2>
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
                                    <th>Nama Bahan</th>
                                    <th>Nama Supplier</th>
                                    <th>Harga Bahan</th>
                                    <th>Jumlah Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($material as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->suppliers_name }}</td>
                                    <td>Rp. {{number_format($item->price,2,',','.')}}</td>
                                    <td>{{ $item->qty }} pcs</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">Data Bahan Baku Kosong</td>
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

<!-- Javascript functions	-->

<script>
    // initialize a validator instance from the "FormValidator" constructor.
    // A "<form>" element is optionally passed as an argument, but is not a must
    var validator = new FormValidator({
        "events": ['blur', 'input', 'change']
    }, document.forms[0]);
    // on form "submit" event
    document.forms[0].onsubmit = function(e) {
        var submit = true,
            validatorResult = validator.checkAll(this);
        console.log(validatorResult);
        return !!validatorResult.valid;
    };
    // on form "reset" event
    document.forms[0].onreset = function(e) {
        validator.reset();
    };
    // stuff related ONLY for this demo page:
    $('.toggleValidationTooltips').change(function() {
        validator.settings.alerts = !this.checked;
        if (this.checked)
            $('form .alert').remove();
    }).prop('checked', false);
</script>
<script type="text/javascript">
    $(document).ready(function() {
        window.setTimeout(function() {
            $(".alert").fadeTo(1000, 0).slideUp(1000, function() {
                $(this).remove();
            });
        }, 5000);

    });
</script>
@endsection