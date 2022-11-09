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
                    <a href="#">Data Estimasi Produksi Pesanan</a>&nbsp;
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Data Estimasi Produksi Pesanan</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="/estimasi/create">Tambah Data Info</a>
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
                                        Data estimasi pengerjaan pesanan merupakan informasi estimasi pengerjaan pesanan
                                        yang dibutuhkan dalam satu transaksi pada UMKM Anda.
                                    </p>
                                    @if(\Session::has('info'))
                                    <div class="alert alert-info alert-dismissible" role="alert" data-timeout="2000">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">x</span>
                                        </button>
                                        <strong>{{ \Session::get('info') }}</strong>
                                    </div>
                                    @endif
                                    @if($total < 24) <strong>Total Estimasi Pengerjaan : {{ round(($total/24),2)
                                        }}&nbsp;Hari</strong>
                                        <br>
                                        Atau
                                        <br>
                                        <strong>Total Estimasi Pengerjaan : {{ $total }}&nbsp;Jam</strong>
                                        @else
                                        <strong>Total Estimasi Pengerjaan : {{ $bulat }}&nbsp;Hari</strong>
                                        <br>
                                        Atau
                                        <br>
                                        <strong>Total Estimasi Pengerjaan : {{ $total }}&nbsp;Jam</strong>
                                        @endif
                                        <br><br>
                                        <table id="datatable-responsive"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            cellspacing="0" width="100%" data-order='[[ 1, "asc" ]]'>
                                            <thead>
                                                <tr>
                                                    <th>Nama Proses</th>
                                                    <th>Urutan Proses</th>
                                                    <th>Bobot Proses</th>
                                                    <th>Durasi Proses (Jam)</th>
                                                    <th>Durasi Proses (Hari)</th>
                                                    @if(auth()->user()->role == "admin")
                                                    <th>Aksi</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($page as $item)
                                                <tr>
                                                    <td style="text-transform:uppercase;">{{ $item->name_process }}</td>
                                                    <td>{{ $item->urutan }}</td>
                                                    <td>{{ number_format(($item->durasi/$total)*100,2,'.','') }}%</td>
                                                    <td>{{ $item->durasi }}&nbsp;Jam</td>
                                                    <td>{{ round(($item->durasi/24),2) }}&nbsp;Hari</td>
                                                    @if(auth()->user()->role == "admin")
                                                    <td>
                                                        <form action="{{route('estimasi.destroy', $item->id)}}"
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
                                                    <td colspan="6">Data Estimasi Produksi Kosong</td>
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