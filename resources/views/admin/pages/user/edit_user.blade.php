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
                    <a href="/user">Data User</a>&nbsp;<small><i class="fa fa-long-arrow-right"></small></i>
                    <a href="#">Edit Data User, Number ID : {{ $page[0]->users_id }}</a>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Form Edit Data User, Number ID : {{ $page[0]->users_id }}</h2>
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
                        <form class="" action="{{ route('user.update', [$page[0]->users_id]) }}" method="post" validate
                            enctype="multipart/form-data">
                            @csrf
                            {{method_field("PUT")}}
                            <p>Masukkan data user dengan benar digunakan sebagai login sistem</p>
                            <input type="text" value="{{ auth()->user()->umkms_id }}" name="id_umkm" hidden>
                            <input type="text" name="id" value="{{ $page[0]->users_id }}" hidden>
                            <span class="section">Personal Info</span>
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
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Depan<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-left" name="first_name"
                                        placeholder="Nama Depan User" required
                                        onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                        value="{{ $page[0]->first_name }}"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama depan user')"
                                        oninput="this.setCustomValidity('')" />
                                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Belakang<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-right" name="last_name"
                                        placeholder="Nama Belakang User" required
                                        onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                        value="{{ $page[0]->last_name }}"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama belakang user')"
                                        oninput="this.setCustomValidity('')" />
                                    <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Username<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" name="username" required readonly
                                        value="{{ $page[0]->username }}"
                                        oninvalid="this.setCustomValidity('Silahkan masukan username user')"
                                        oninput="this.setCustomValidity('')" />
                                    <small>Username tidak dapat dirubah</small>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Email<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-left" name="email" class='email' required
                                        type="email" placeholder="Email User" value="{{ $page[0]->email }}"
                                        oninvalid="this.setCustomValidity('Silahkan masukan alamat email user')"
                                        oninput="this.setCustomValidity('')" />
                                    <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Password<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="password" id="password1" name="password"
                                        title="Minimum 8 Characters Including An Upper And Lower Case Letter, A Number And A Unique Character"
                                        required placeholder="Password User" value="{{ $page[0]->password }}" />
                                    <small>Password sudah terenkripsi silahkan masukkan password kembali</small>
                                    <span style="position: absolute;right:15px;top:7px;" onclick="hideshow()">
                                        <i id="slash" class="fa fa-eye-slash"></i>
                                        <i id="eye" class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                            @if(auth()->user()->role == "admin")
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Role User<span
                                        class="required">*</span><br>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control" id="cbrole" name="cbrole">
                                        <option value="" selected disabled>Pilih Role User</option>
                                        @if(auth()->user()->role == "super")
                                        <option value="super">Super Admin</option>
                                        <option value="user">User</option>
                                        @endif
                                        @if(auth()->user()->role == "admin")
                                        <option value="admin">Admin</option>
                                        <option value="produksi">Produksi</option>
                                        @endif
                                    </select>
                                    <small>silahkan pilih role user kembali</small>
                                </div>
                            </div>
                            @endif
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Nomor Telepon<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-left" type="number" class='tel' name="phone"
                                        required minlength="10" maxlength="13" placeholder="Nomor Telepon User"
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)"
                                        value="{{ $page[0]->phone }}"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nomor telepon user')"
                                        oninput="this.setCustomValidity('')" />
                                    <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Alamat<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-left" type="text" name="address" required
                                        onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                        placeholder="Alamat User" value="{{ $page[0]->address }}"
                                        oninvalid="this.setCustomValidity('Silahkan masukan alamat user')"
                                        oninput="this.setCustomValidity('')" />
                                    <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Kecamatan<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-left" type="text" name="districts" required
                                        onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                        placeholder="Kecamatan User" value="{{ $page[0]->districts }}"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama kecamatan user')"
                                        oninput="this.setCustomValidity('')" />
                                    <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Kelurahan<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-left" type="text" name="ward" required
                                        onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                        placeholder="Kelurahan User" value="{{ $page[0]->ward }}"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama kelurahan user')"
                                        oninput="this.setCustomValidity('')" />
                                    <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Kota<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-left" type="text" name="city" required
                                        onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                        placeholder="Kota User" value="{{ $page[0]->city }}"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama kota user')"
                                        oninput="this.setCustomValidity('')" />
                                    <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Provinsi<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control has-feedback-left" type="text" name="province" required
                                        onkeydown="return /[a-z, ,backspace,delete]/i.test(event.key)"
                                        placeholder="Provinsi User" value="{{ $page[0]->province }}"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama provinsi user')"
                                        oninput="this.setCustomValidity('')" />
                                    <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Kode Pos<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="number" maxlength="6" name="postal_code" required
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)"
                                        placeholder="Kode Post User" value="{{ $page[0]->postal_code }}"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nomor kode pos user')"
                                        oninput="this.setCustomValidity('')" />
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Deskripsi Alamat<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <textarea id="message" required class="form-control" name="desc"
                                        data-parsley-trigger="keyup" data-parsley-minlength="20"
                                        data-parsley-maxlength="100"
                                        data-parsley-minlength-message="Masukkan deskripsi alamat anda"
                                        data-parsley-validation-threshold="10"
                                        oninvalid="this.setCustomValidity('Silahkan masukan deskripsi alamat user')"
                                        oninput="this.setCustomValidity('')">{{ $page[0]->desc }}</textarea>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">File Foto (Optional)<span
                                        class="required">*</span><br>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="file" name="file_foto" accept="image/*"><br>
                                    <small>Besar file: maksimum 10.000.000 bytes (10 Megabytes). Ekstensi file yang
                                        diperbolehkan: .JPG .JPEG .PNG</small>
                                    <small>Silahkan upload file foto kembali</small>
                                </div>
                            </div>
                            <div class="ln_solid">
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <br>
                                        <button type='submit' class="btn btn-primary">Update</button>
                                        <button type='reset' class="btn btn-success">Reset</button>
                                        <a href="/user" class="btn btn-danger">Batal</a>
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
    }, document.forms);
    // on form "submit" event
    document.forms.onsubmit = function(e) {
        var submit = true,
            validatorResult = validator.checkAll(this);
        console.log(validatorResult);
        return !!validatorResult.valid;
    };
    // on form "reset" event
    document.forms.onreset = function(e) {
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