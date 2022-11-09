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
                    <a href="#">Data Info Website</a>&nbsp;
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Data Informasi Website</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="/info/create">Tambah Data Info</a>
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
                                        Data informasi website berisikan tentang informasi mengenai data UMKM Anda,
                                        mulai dari nama toko sampai dengan informasi kontak yang dapat dihubungi
                                        sehingga memudahkan pelanggan dalam mendapatkan informasi dan dalam melakukan
                                        transaksi.
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
                                                <th>Nama Halaman Website</th>
                                                <th>No Whatsapp Admin</th>
                                                <th>Alamat Toko</th>
                                                <th>Email Toko</th>
                                                <!-- <th>Link Shopee</th>
                                                <th>Link Tokped</th> -->
                                                <th>Link Instagram</th>
                                                <th>Date</th>
                                                <th>Aksi</th>
                                                @if(auth()->user()->role == "admin")
                                                <th></th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($page as $item)
                                            <tr>
                                                <td>{{ $item->title }}</td>
                                                <td>
                                                    <a href="https://wa.me/{{ $item->no_wa }}" target="_blank">
                                                        {{ $item->no_wa = Str::limit($item->no_wa, 15) }}
                                                    </a>
                                                </td>
                                                <td>{{ $item->alamat }}</td>
                                                <td>
                                                    <a href="" target="_blank">
                                                        {{ $item->link_email = Str::limit($item->link_email, 15) }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="" target="_blank">
                                                        {{ $item->link_instagram = Str::limit($item->link_instagram,
                                                        15) }}
                                                    </a>
                                                </td>
                                                <td>{{ $item->date }} </td>
                                                <td>
                                                    Note : Untuk lihat detail silahkan cek pada tombol edit.
                                                    <a href="{{ route('info.edit', [Crypt::encrypt($item->id)]) }}"
                                                        class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                                                        Edit </a>
                                                </td>
                                                @if(auth()->user()->role == "admin")
                                                <td>
                                                    <form
                                                        action="{{ route('info.destroy', Crypt::encrypt($item->id)) }}"
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
                                                <td colspan="10">Data Informasi Website Kosong</td>
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