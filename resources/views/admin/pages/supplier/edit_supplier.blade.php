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
                    <a href="/supplier">Data Supplier</a>&nbsp;<small><i class="fa fa-long-arrow-right"></small></i>
                    <a href="#">Edit Data Supplier, Number ID : {{ $page[0]->id }}</a>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Form Edit Data User, Number ID : {{ $page[0]->id }}</h2>
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
                        <form class="" action="{{ route('supplier.update', [$page[0]->id]) }}" method="post" validate
                            enctype="multipart/form-data">
                            @csrf
                            {{method_field("PUT")}}
                            <p>Masukkan data supplier dengan benar digunakan sebagai informasi supplier</p>
                            <span class="section">Supplier Info</span>
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
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Supplier<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-left" name="name"
                                        placeholder="Nama Supplier" required
                                        onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                        value="{{ $page[0]->name }}"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama supplier')"
                                        oninput="this.setCustomValidity('')" />
                                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Email<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-left" name="email" class='email'
                                        placeholder="Email Supplier / Perusahaan" required type="email"
                                        value="{{ $page[0]->email }}"
                                        oninvalid="this.setCustomValidity('Silahkan masukan email supplier')"
                                        oninput="this.setCustomValidity('')" />
                                    <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Nomor Telepon<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-left" type="number" class='tel' name="phone"
                                        required minlength="10" maxlength="13" placeholder="Nomor Telepon Supplier"
                                        value="{{ $page[0]->phone }}" min="1"
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nomor telepon supplier')"
                                        oninput="this.setCustomValidity('')" />
                                    <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Alamat<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-left" type="text" name="address" required
                                        placeholder="Alamat Supplier / Perusahaan" value="{{ $page[0]->address }}"
                                        oninvalid="this.setCustomValidity('Silahkan masukan alamat supplier')"
                                        oninput="this.setCustomValidity('')" />
                                    <span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="ln_solid">
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <br>
                                        <button type='submit' class="btn btn-primary">Update</button>
                                        <button type='reset' class="btn btn-success">Reset</button>
                                        <a href="/supplier" class="btn btn-danger">Batal</a>
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