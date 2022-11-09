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
                    <a href="/info">Data Info</a>&nbsp;<small><i class="fa fa-long-arrow-right"></small></i>
                    <a href="#">Edit Data Informasi UMKM, Number ID : {{ $page[0]->id }}</a>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Form Edit Data Informasi UMKM, Number ID : {{ $page[0]->id }}</h2>
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
                        <form class="" action="{{ route('info.update', [$page[0]->id]) }}" method="post" validate
                            enctype="multipart/form-data">
                            @csrf
                            {{method_field("PUT")}}
                            <p>Masukkan data informasi website dengan benar digunakan sebagai informasi website bagi
                                pelanggan</p>
                            <span class="section">Data Informasi Website</span>
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
                            <input type="text" name="id" value="{{ $page[0]->id }}" hidden>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Halaman<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" class="form-control has-feedback-left" name="title"
                                        placeholder="Nama Halaman Toko" required value="{{ $page[0]->title }}"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama halaman UMKM')"
                                        oninput="this.setCustomValidity('')">
                                    <span class="fa fa-book form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Email Admin<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="email" class="form-control has-feedback-left" name="email"
                                        class="email" placeholder="Email Admin/Toko" required
                                        oninvalid="this.setCustomValidity('Silahkan masukan alamat email admin/UMKM')"
                                        oninput="this.setCustomValidity('')" value="{{ $page[0]->link_email }}">
                                    <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Phone Number (Wa)<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control has-feedback-left" name="phone" class='tel'
                                        placeholder="Nomor Telepon Admin/Toko" min-length="10" max-length="13" required
                                        value="{{ $page[0]->no_wa }}" min="1"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nomor telepon')"
                                        oninput="this.setCustomValidity('')">
                                    <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Alamat<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" class="form-control has-feedback-left" name="address"
                                        placeholder="Alamat Toko" required value="{{ $page[0]->alamat }}"
                                        oninvalid="this.setCustomValidity('Silahkan masukan alamat')"
                                        oninput="this.setCustomValidity('')">
                                    <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Kecamatan<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" class="form-control has-feedback-left" name="districts"
                                        placeholder="Nama Kecamatan" required value="{{ $umkm[0]->districts }}"
                                        onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama kecamatan')"
                                        oninput="this.setCustomValidity('')">
                                    <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Kelurahan<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" class="form-control has-feedback-left" name="ward"
                                        placeholder="Nama Kelurahan" required value="{{ $umkm[0]->ward }}"
                                        onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama kelurahan')"
                                        oninput="this.setCustomValidity('')">
                                    <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Kota<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" class="form-control has-feedback-left" name="city"
                                        placeholder="Nama Kota" required value="{{ $umkm[0]->city }}"
                                        onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama kota')"
                                        oninput="this.setCustomValidity('')">
                                    <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Provinsi<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" class="form-control has-feedback-left" name="province"
                                        placeholder="Nama Provinsi" required value="{{ $umkm[0]->province }}"
                                        onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama provinsi')"
                                        oninput="this.setCustomValidity('')">
                                    <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Kode Pos<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control has-feedback-left" name="postal_code"
                                        placeholder="Kode Pos" required value="{{ $umkm[0]->postal_code }}"
                                        onkeydown="return /[0-9, ,backspace,delete]/i.test(event.key)" min="1"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nomor kode pos')"
                                        oninput="this.setCustomValidity('')">
                                    <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            @if(auth()->user()->role == "super")
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Deskripsi halaman
                                    login<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <textarea id="message" required="required" class="form-control" name="desc_login"
                                        data-parsley-trigger="keyup" data-parsley-minlength="20"
                                        data-parsley-maxlength="100"
                                        data-parsley-minlength-message="Masukkan deskripsi pada halaman bagian login"
                                        data-parsley-validation-threshold="10">{{ $page[0]->description_login }}</textarea>
                                    <small>Masukkan deskripsi pada halaman bagian login</small>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Deskripsi halaman
                                    register<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <textarea id="message" required="required" class="form-control" name="desc_register"
                                        data-parsley-trigger="keyup" data-parsley-minlength="20"
                                        data-parsley-maxlength="100"
                                        data-parsley-minlength-message="Masukkan deskripsi pada halaman bagian register"
                                        data-parsley-validation-threshold="10">{{ $page[0]->description_register }}</textarea>
                                    <small>Masukkan deskripsi pada halaman bagian register</small>
                                </div>
                            </div>
                            @endif
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Deskripsi tentang
                                    umkm<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <textarea id="message" required="required" class="form-control" name="desc_umkm"
                                        data-parsley-trigger="keyup" data-parsley-minlength="20"
                                        data-parsley-maxlength="100"
                                        data-parsley-minlength-message="Masukkan deskripsi tentang detail umkm anda"
                                        data-parsley-validation-threshold="10">{{ $page[0]->description_umkm }}</textarea>
                                    <small>Masukkan deskripsi tentang detail umkm anda</small>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Deskripsi tentang
                                    produk<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <textarea id="message" required="required" class="form-control" name="desc_product"
                                        data-parsley-trigger="keyup" data-parsley-minlength="20"
                                        data-parsley-maxlength="100"
                                        data-parsley-minlength-message="Masukkan deskripsi tentang jenis produk yang dijual"
                                        data-parsley-validation-threshold="10">{{ $page[0]->description_product }}</textarea>
                                    <small>Masukkan deskripsi tentang jenis produk yang dijual</small>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Deskripsi tentang
                                    detail produk<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <textarea id="message" required="required" class="form-control" name="desc_detail"
                                        data-parsley-trigger="keyup" data-parsley-minlength="20"
                                        data-parsley-maxlength="100"
                                        data-parsley-minlength-message="Masukkan deskripsi tentang detail produk yang dijual"
                                        data-parsley-validation-threshold="10">{{ $page[0]->description_detail }}</textarea>
                                    <small>Masukkan deskripsi tentang detail produk yang dijual</small>
                                </div>
                            </div>
                            @if(auth()->user()->role == "super")
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Deskripsi tentang
                                    tambahan informasi pada website<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <textarea id="message" required="required" class="form-control" name="desc_lainnya"
                                        data-parsley-trigger="keyup" data-parsley-minlength="20"
                                        data-parsley-maxlength="100"
                                        data-parsley-minlength-message="Masukkan deskripsi tentang tambahan informasi pada website"
                                        data-parsley-validation-threshold="10">{{ $page[0]->description_lainnya }}</textarea>
                                    <small>Masukkan deskripsi tentang tambahan informasi pada website</small>
                                </div>
                            </div>
                            @endif
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Link Shopee<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" class="form-control has-feedback-left" name="shopee"
                                        placeholder="Link Shopee" required value="{{ $page[0]->link_shopee }}">
                                    <span class="fa fa-link form-control-feedback left" aria-hidden="true"></span>
                                    <small>Inputan berupa link salinan dari halaman website</small>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Link Tokopedia<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" class="form-control has-feedback-left" name="tokped"
                                        placeholder="Link Tokopedia" required value="{{ $page[0]->link_tokped }}">
                                    <span class="fa fa-link form-control-feedback left" aria-hidden="true"></span>
                                    <small>Inputan berupa link salinan dari halaman website</small>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Link Instagram<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" class="form-control has-feedback-left" name="instagram"
                                        placeholder="Link Instagram" required value="{{ $page[0]->link_instagram }}">
                                    <span class="fa fa-instagram form-control-feedback left" aria-hidden="true"></span>
                                    <small>Inputan berupa link salinan dari halaman website</small>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Jam Buka<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="time" class="form-control has-feedback-left" name="open_time" required>
                                    <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Jam Tutup<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="time" class="form-control has-feedback-left" name="close_time"
                                        required>
                                    <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <input type="date" name="date" value="{{ $tgl=date('Y-m-d'); }}" hidden>
                            <div class="ln_solid">
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <br>
                                        <button type='submit' class="btn btn-primary">Update</button>
                                        <button type='reset' class="btn btn-success">Reset</button>
                                        <a href="/info" class="btn btn-danger">Batal</a>
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
    function hideshow() {
        var password = document.getElementById("password1");
        var slash = document.getElementById("slash");
        var eye = document.getElementById("eye");

        if (password.type === 'password') {
            password.type = "text";
            slash.style.display = "block";
            eye.style.display = "none";
        } else {
            password.type = "password";
            slash.style.display = "none";
            eye.style.display = "block";
        }

    }
</script>
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