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
                    <a href="/estimasi">Data Estimasi Produksi</a>&nbsp;<small><i
                            class="fa fa-long-arrow-right"></small></i>
                    <a href="#">Tambah Data Estimasi Produksi</a>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Form Tambah Data Estimasi Produksi</h2>
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
                    <span hidden>
                        <div class="item-clone master-clone">
                            <div class="field item form-group">
                                <label class="col-form-label label-align">Nama
                                    Proses<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3">
                                    <input type="text" class="form-control has-feedback-left" placeholder="Nama Proses"
                                        onkeydown="return /[a-z,0-9, ,backspace,delete]/i.test(event.key)" required
                                        name="name_process[]"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama proses produksi')"
                                        oninput="this.setCustomValidity('')">
                                    <span class="fa fa-cloud form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <label class="col-form-label label-align">Durasi
                                    Proses (Jam)<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3">
                                    <input type="number" class="form-control has-feedback-left"
                                        placeholder="Durasi Proses" min="1"
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)" required
                                        name="durasi[]"
                                        oninvalid="this.setCustomValidity('Silahkan masukan durasi proses produksi (jam)')"
                                        oninput="this.setCustomValidity('')">
                                    <span class="fa fa-cloud form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <a href="#" class="btn btn-danger remove-repeater">Hapus</a>
                            </div>
                        </div>
                    </span>
                    <div class="x_content">
                        <form class="" action="{{ route('estimasi.store') }}" method="post" validate
                            enctype="multipart/form-data">
                            @csrf
                            <p>
                                Data estimasi produksi digunakan sebagai data estimasi produksi yang tersedia pada
                                setiap UMKM
                            </p>
                            <input type="text" value="{{ $idumkm }}" name="umkms_id" hidden>
                            <span class="section">Data Estimasi produksi</span>
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
                            <a href="#" class="btn btn-primary tambah">Tambah</a>
                            <div class="field item form-group">
                                <label class="col-form-label label-align">Nama
                                    Proses<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3">
                                    <input type="text" class="form-control has-feedback-left" placeholder="Nama Proses"
                                        onkeydown="return /[a-z,0-9, ,backspace,delete]/i.test(event.key)" required
                                        name="name_process[]"
                                        oninvalid="this.setCustomValidity('Silahkan masukan nama proses produksi')"
                                        oninput="this.setCustomValidity('')">
                                    <span class="fa fa-cloud form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <label class="col-form-label label-align">Durasi
                                    Proses (Jam)<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3">
                                    <input type="number" class="form-control has-feedback-left"
                                        placeholder="Durasi Proses" min="1"
                                        onkeydown="return /[0-9,backspace,delete]/i.test(event.key)" required
                                        name="durasi[]"
                                        oninvalid="this.setCustomValidity('Silahkan masukan durasi proses produksi (jam)')"
                                        oninput="this.setCustomValidity('')">
                                    <span class="fa fa-cloud form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="repeater" id="form-repeater">
                                <div class="master-clone">
                                    <div class="field item form-group">
                                        <label class="col-form-label label-align">Nama
                                            Proses<span class="required">*</span></label>
                                        <div class="col-md-3 col-sm-3">
                                            <input type="text" class="form-control has-feedback-left"
                                                placeholder="Nama Proses"
                                                onkeydown="return /[a-z,0-9, ,backspace,delete]/i.test(event.key)"
                                                required name="name_process[]"
                                                oninvalid="this.setCustomValidity('Silahkan masukan nama proses produksi')"
                                                oninput="this.setCustomValidity('')">
                                            <span class="fa fa-cloud form-control-feedback left"
                                                aria-hidden="true"></span>
                                        </div>
                                        <label class="col-form-label label-align">Durasi
                                            Proses (Jam)<span class="required">*</span></label>
                                        <div class="col-md-3 col-sm-3">
                                            <input type="number" class="form-control has-feedback-left"
                                                placeholder="Durasi Proses" min="1"
                                                onkeydown="return /[0-9,backspace,delete]/i.test(event.key)" required
                                                name="durasi[]"
                                                oninvalid="this.setCustomValidity('Silahkan masukan durasi proses produksi (jam)')"
                                                oninput="this.setCustomValidity('')">
                                            <span class="fa fa-cloud form-control-feedback left"
                                                aria-hidden="true"></span>
                                        </div>
                                        <a href="#" class="btn btn-danger remove-repeater">Hapus</a>
                                    </div>
                                </div>
                            </div>
                            <div class="ln_solid">
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <br>
                                        <button type='submit' class="btn btn-primary">Simpan</button>
                                        <button type='reset' class="btn btn-success">Reset</button>
                                        <a href="/estimasi" class="btn btn-danger">Batal</a>
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
                        <h2>List Data Estimasi Produksi</h2>
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
                            cellspacing="0" width="100%" data-order='[[ 1, "asc" ]]'>
                            <thead>
                                <tr>
                                    <th>Data Proses Produksi</th>
                                    <th>Urutan Proses</th>
                                    <th>Durasi Proses (Jam)</th>
                                    <th>Durasi Proses (Hari)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($page as $item)
                                <tr>
                                    <td style="text-transform:uppercase;">{{ $item->name_process }}</td>
                                    <td>{{ $item->urutan }}</td>
                                    <td>{{ $item->durasi }}&nbsp;Jam</td>
                                    <td>{{ $bulat = round(($item->durasi/24),2) }}&nbsp;Hari</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">Data Estimasi Produksi Kosong</td>
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