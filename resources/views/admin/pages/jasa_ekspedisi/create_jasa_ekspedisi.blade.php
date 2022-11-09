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
                    <a href="/jasa_ekspedisi">Data Jasa Ekspedisi</a>&nbsp;<small><i
                            class="fa fa-long-arrow-right"></small></i>
                    <a href="#">Tambah Data Jasa Ekspedisi</a>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Form Tambah Data Jasa Ekspedisi</h2>
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
                        <form class="" action="{{ route('jasa_ekspedisi.store') }}" method="post" validate
                            enctype="multipart/form-data">
                            @csrf
                            <p>Masukkan data jasa ekspedisi dengan benar digunakan sebagai data jasa pengiriman pada
                                sistem</p>
                            <span class="section">Ekspedisi Info</span>
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
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Ekspedisi<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" class="form-control has-feedback-left" name="name"
                                        placeholder="Nama Ekspedisi"
                                        onkeydown="return /[a-z,0-9, ,backspace,delete]/i.test(event.key)" required
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama jasa ekspedisi')"
                                        oninput="this.setCustomValidity('')">
                                    <span class="fa fa-truck form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Jenis Pengiriman<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control" id="cbjenis" name="cbjenis" required
                                        oninvalid="this.setCustomValidity('Silahkan pilih salah satu jenis pengiriman')"
                                        oninput="this.setCustomValidity('')">
                                        <option value="" selected disabled>-- Pilih Jenis Pengiriman --</option>
                                        <option value="reguler">Reguler</option>
                                        <option value="one day">One Day/Less One Day</option>
                                        <option value="reguler express">Reguler Express</option>
                                        <option value="express">Express</option>
                                    </select>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Harga Jasa/Kg<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control has-feedback-left" name="price" class='tel'
                                        placeholder="Harga Jasa Pengiriman" minlength="4" maxlength="10" required
                                        min="1" onkeydown="return /[0-9,backspace,delete]/i.test(event.key)"
                                        oninvalid="this.setCustomValidity('Silahkan masukan harga jasa/kg')"
                                        oninput="this.setCustomValidity('')">
                                    <span class="fa fa-list-ol form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Nomor Admin/Cs<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control has-feedback-left" name="phone" class='tel'
                                        placeholder="Nomor Admin/Cs" minlength="10" maxlength="13" required
                                        oninvalid="this.setCustomValidity('Silahkan masukan nomor telepon admin/cs')"
                                        oninput="this.setCustomValidity('')"
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)" min="1">
                                    <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="ln_solid">
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <br>
                                        <button type='submit' class="btn btn-primary">Simpan</button>
                                        <button type='reset' class="btn btn-success">Reset</button>
                                        <a href="/jasa_ekspedisi" class="btn btn-danger">Batal</a>
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
                        <h2>List Data Jasa Ekspedisi</h2>
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
                                    <th>Nama Jasa Ekpedisi</th>
                                    <th>Jenis Pengiriman</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($page as $item)
                                <tr>
                                    <td style="text-transform:uppercase;">{{ $item->name }}</td>
                                    <td style="text-transform:uppercase;">{{ $item->type }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3">Data Jasa Ekpedisi Kosong</td>
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