@extends('admin.layouts.app')
@section('title')
{{ $title }}
@endsection
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <p>
                    <a href="/admin">Home</a>&nbsp;<small><i class="fa fa-long-arrow-right"></small></i>
                    <a href="#">Data Bahan Baku</a>&nbsp;
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Data Bahan Baku</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="/bahan_baku/create">Tambah Data</a>
                                </div>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <p class="text-muted font-13 m-b-30">
                                        Data bahan baku merupakan data bahan baku atau materials yang tersimpan pada
                                        sistem, digunakan sebagai pencatatan data bahan baku yang ada pada UMKM Anda.
                                    </p>
                                    @if(\Session::has('info'))
                                    <div class="alert alert-info alert-dismissible" role="alert" data-timeout="2000">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">x</span>
                                        </button>
                                        <strong>{{ \Session::get('info') }}</strong>
                                    </div>
                                    @endif
                                    <table id="datatable-responsive"
                                        class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>Nama Bahan</th>
                                                <th>Nama Supplier</th>
                                                <th>Harga Bahan</th>
                                                <th>Jumlah Stok</th>
                                                <th>Aksi</th>
                                                @if(auth()->user()->role == "admin")
                                                <th></th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($page as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->suppliers_name }}</td>
                                                <td>Rp. {{number_format($item->price,2,',','.')}}</td>
                                                <td>{{ $item->qty }} pcs</td>
                                                <td>
                                                    <a href="{{ route('bahan_baku.edit', [Crypt::encrypt($item->id)]) }}"
                                                        class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                                                        Edit </a>
                                                </td>
                                                @if(auth()->user()->role == "admin")
                                                <td>
                                                    <form
                                                        action="{{ route('bahan_baku.destroy', Crypt::encrypt($item->id)) }}"
                                                        method="post">
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
                                                <td colspan="6">Data Bahan Baku Kosong</td>
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
        </div>
    </div>
</div>
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