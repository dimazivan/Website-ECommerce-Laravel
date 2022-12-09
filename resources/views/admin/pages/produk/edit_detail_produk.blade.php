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
                    <a href="/produk">Data Produk</a>&nbsp;<small><i class="fa fa-long-arrow-right"></small></i>
                    <a href="#">Edit Varian Produk, Number ID : {{ $page[0]->idvarian }}</a>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Form Edit Varian Produk, Number ID : {{ $page[0]->idvarian }}</h2>
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
                        <form class="" action="{{ route('detail_produk.update', [$page[0]->idvarian]) }}" method="post"
                            validate enctype="multipart/form-data">
                            @csrf
                            {{method_field("PUT")}}
                            @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <p>Masukkan data produk dengan benar digunakan sebagai informasi produk yang sedang dijual
                                pada halaman website</p>
                            <span class="section">Data Produk</span>
                            <input type="text" name="id" value="{{ $page[0]->idvarian }}" hidden>
                            <input type="text" name="idproduk" value="{{ $page[0]->id }}" hidden>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Produk<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-left" name="name" placeholder="Nama Produk"
                                        required oninvalid="this.setCustomValidity('Silahkan masukan nama produk')"
                                        oninput="this.setCustomValidity('')"
                                        onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                        value="{{ $page[0]->name }}" readonly />
                                    <span class="fa fa-shopping-cart form-control-feedback left"
                                        aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Modal (Rp)<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control has-feedback-left" name="modal"
                                        placeholder="Modal Produk" min="1000"
                                        oninvalid="this.setCustomValidity('Silahkan masukan modal produk (Rp) min Rp. 1000')"
                                        oninput="this.setCustomValidity('')"
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)" required
                                        value="{{ $page[0]->modal }}">
                                    <span class="fa fa-tag form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Harga Jual (Rp)<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control has-feedback-left" name="price"
                                        placeholder="Harga Produk" min="1000"
                                        oninvalid="this.setCustomValidity('Silahkan masukan harga jual produk (Rp) min Rp. 1000')"
                                        oninput="this.setCustomValidity('')"
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)" required
                                        value="{{ $page[0]->price }}">
                                    <span class="fa fa-tag form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Harga Promo (Rp)<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control has-feedback-left" name="promo"
                                        placeholder="Harga Promo Produk" min="0"
                                        oninvalid="this.setCustomValidity('Silahkan masukan harga promo produk (Rp)')"
                                        oninput="this.setCustomValidity('')"
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)" required
                                        value="{{ $page[0]->promo }}">
                                    <span class="fa fa-tag form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Jumlah Stok Produk
                                    (Pcs)<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control has-feedback-left" name="qty"
                                        placeholder="Jumlah Stok Produk" min="1"
                                        oninvalid="this.setCustomValidity('Silahkan masukan jumlah stok produk (pcs)')"
                                        oninput="this.setCustomValidity('')"
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)" required
                                        value="{{ $page[0]->qty }}">
                                    <span class="fa fa-dropbox form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Ukuran Produk<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control" id="cbsize" name="cbsize">
                                        <option selected disabled>Pilih Ukuran Produk</option>
                                        <option value="s">S</option>
                                        <option value="m">M</option>
                                        <option value="l">L</option>
                                        <option value="XL">XL</option>
                                        <option value="xxl">XXL</option>
                                        <option value="xxxl">XXL</option>
                                    </select>
                                    <small>Ukuran produk sekarang :
                                        <span style="text-transform:uppercase;">
                                            <strong>{{ $page[0]->size }}</strong>
                                        </span>
                                    </small><br>
                                    <small>Masukkan ukuran produk kembali, jika tidak ada perubahan sialhkan masukan
                                        ukuran produkyang lama</small>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Warna Produk<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control" id="cbcolors" name="cbcolors">
                                        <option selected disabled>Pilih Warna Produk</option>
                                        @forelse ($colors as $warna)
                                        <option value="{{ $warna->name }}">{{ $warna->name }}</option>
                                        @empty
                                        <option value="#">Data Warna tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                    <small>Warna produk sekarang :
                                        <span style="text-transform:uppercase;">
                                            <strong>{{ $page[0]->color }}</strong>
                                        </span>
                                    </small><br>
                                    <small>Masukkan warna produk produk kembali, jika tidak ada perubahan silahkan
                                        masukan warna produk yang lama</small>
                                </div>
                            </div>
                            <div class="ln_solid">
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <br>
                                        <button type='submit' class="btn btn-primary">Simpan</button>
                                        <button type='reset' class="btn btn-success">Reset</button>
                                        <a href="/produk" class="btn btn-danger">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
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
@endsection