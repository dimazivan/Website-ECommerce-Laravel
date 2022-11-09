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
                    <a href="#">Tambah Data Produk</a>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Form Tambah Produk</h2>
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
                        <form class="" action="{{ route('produk.store') }}" method="post" validate
                            enctype="multipart/form-data">
                            @csrf
                            <p>Masukkan data produk dengan benar digunakan sebagai informasi produk yang sedang dijual
                                pada halaman website</p>
                            <input type="text" value="{{ $idumkm }}" name="umkms_id" hidden>
                            <span class="section">Data Produk</span>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Produk<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-left" name="name" placeholder="Nama Produk"
                                        required oninvalid="this.setCustomValidity('Silahkan masukan nama produk')"
                                        oninput="this.setCustomValidity('')"
                                        onkeydown="return /[a-z,0-9, ,backspace,delete]/i.test(event.key)" />
                                    <span class="fa fa-shopping-cart form-control-feedback left"
                                        aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Kategori<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control" id="cbcategory" name="cbcategory" required
                                        oninvalid="this.setCustomValidity('Silahkan pilih salah satu kategori produk')"
                                        oninput="this.setCustomValidity('')">
                                        <option selected disabled>Pilih Kategori Produk</option>
                                        @foreach ($page as $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Deskripsi Produk<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <textarea id="message" required class="form-control" name="desc"
                                        data-parsley-trigger="keyup" data-parsley-minlength="20"
                                        data-parsley-maxlength="100"
                                        data-parsley-minlength-message="Masukkan deskripsi produk anda"
                                        data-parsley-validation-threshold="10"
                                        oninvalid="this.setCustomValidity('Silahkan masukan deskripsi produk')"
                                        oninput="this.setCustomValidity('')"></textarea>
                                    <small>Masukkan deskripsi produk yang anda pasarkan.</small>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Modal (Rp)<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control has-feedback-left" name="modal"
                                        placeholder="Modal Produk" required min="1"
                                        oninvalid="this.setCustomValidity('Silahkan masukan modal produk (Rp)')"
                                        oninput="this.setCustomValidity('')"
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)">
                                    <span class="fa fa-tag form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Harga Jual (Rp)<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control has-feedback-left" name="price"
                                        placeholder="Harga Produk" required min="1"
                                        oninvalid="this.setCustomValidity('Silahkan masukan harga jual produk (Rp)')"
                                        oninput="this.setCustomValidity('')"
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)">
                                    <span class="fa fa-tag form-control-feedback left" aria-hidden="true"></span>
                                    <small>Harga promo harus lebih kecil dari harga jual</small>
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
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)" required>
                                    <span class="fa fa-tag form-control-feedback left" aria-hidden="true"></span>
                                    <small>Harga promo harus lebih kecil dari harga jual</small>
                                </div>
                            </div>
                            <input type="number" class="form-control has-feedback-left" name="qty"
                                placeholder="Jumlah Stok Produk" min="1" hidden value="1"
                                onkeydown="return /[0-9,backspace,delete]/i.test(event.key)" required>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Ukuran Produk<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="checkbox" class="flat" name="cbsize[]" value="s">
                                    <strong>S</strong>&nbsp;
                                    <input type="checkbox" class="flat" name="cbsize[]" value="m">
                                    <strong>M</strong>&nbsp;
                                    <input type="checkbox" class="flat" name="cbsize[]" value="l">
                                    <strong>L</strong>&nbsp;
                                    <input type="checkbox" class="flat" name="cbsize[]" value="xl">
                                    <strong>XL</strong>&nbsp;
                                    <input type="checkbox" class="flat" name="cbsize[]" value="xxl">
                                    <strong>XXL</strong>&nbsp;
                                    <input type="checkbox" class="flat" name="cbsize[]" value="xxxl">
                                    <strong>XXXL</strong>&nbsp;
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Warna Produk<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 ">
                                    @foreach ($colors as $warna)
                                    <input type="checkbox" class="flat" name="cbcolor[]" value="{{ $warna->name }}">
                                    <strong>{{ $warna->name }}</strong>&nbsp;
                                    @endforeach
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">File Foto Produk 1<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="file" name="file_foto1" accept="image/*" required
                                        oninvalid="this.setCustomValidity('Silahkan masukan file foto produk')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">File Foto Produk 2<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="file" name="file_foto2" accept="image/*" required
                                        oninvalid="this.setCustomValidity('Silahkan masukan file foto produk')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">File Foto Produk 3<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="file" name="file_foto3" accept="image/*" required
                                        oninvalid="this.setCustomValidity('Silahkan masukan file foto produk')"
                                        oninput="this.setCustomValidity('')">
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