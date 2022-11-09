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
                    <a href="/pembayaran">Data Pembayaran</a>&nbsp;<small><i class="fa fa-long-arrow-right"></small></i>
                    <a href="#">Edit Data Pembayaran, Nama Bank : {{ $page[0]->name }}</a>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Form Edit Data Pembayaran, Nama Bank : {{ $page[0]->name }}</h2>
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
                        <form class="" action="{{ route('pembayaran.update', [$page[0]->id]) }}" method="post" validate
                            enctype="multipart/form-data">
                            @csrf
                            {{method_field("PUT")}}
                            <p>Masukkan data portal pembayaran dengan benar digunakan sebagai login sistem</p>
                            <span class="section">Data Pembayaran</span>
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
                                <input type="text" name="id" value="{{ $page[0]->id }}" hidden>
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Bank<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-left" name="name"
                                        placeholder="Nama Bank / Rekening" required
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama bank')"
                                        oninput="this.setCustomValidity('')"
                                        onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                        value="{{ $page[0]->name }}" />
                                    <span class="fa fa-university form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Pemilik Rekening<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-left" name="name_account"
                                        placeholder="Nama Pemilik Rekening" required
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama pemilik rekening')"
                                        oninput="this.setCustomValidity('')"
                                        onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                        value="{{ $page[0]->name_account }}" />
                                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Tipe Pembayaran<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control" id="cbtipe" name="cbtipe" required
                                        oninvalid="this.setCustomValidity('Silahkan pilih salah satu tipe pembayaran')"
                                        oninput="this.setCustomValidity('')">
                                        <option selected disabled>Pilih Tipe Pembayaran</option>
                                        <option value="BANK TRANSFER">Bank Transfer</option>
                                        <option value="DIGITAL WALLET">Digital Wallet</option>
                                        <option value="VIRTUAL ACCOUNT">Virtual Account</option>
                                    </select>
                                    <small>Silahkan pilih tipe pembayaran kembali</small>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Nomor Rekening / Kode
                                    Virtual<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-left" type="number" name="number" required
                                        maxlength="30" placeholder="Nomor Rekening" value="{{ $page[0]->number }}"
                                        min="1" onkeydown="return /[0-9,backspace,delete]/i.test(event.key)"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nomor rekening / kode virtual')"
                                        oninput="this.setCustomValidity('')" />
                                    <span class="fa fa-credit-card form-control-feedback left"
                                        aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="ln_solid">
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <br>
                                        <button type='submit' class="btn btn-primary">Update</button>
                                        <button type='reset' class="btn btn-success">Reset</button>
                                        <a href="/pembayaran" class="btn btn-danger">Batal</a>
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