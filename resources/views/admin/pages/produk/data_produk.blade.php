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
                    <a href="#">Data Produk</a>&nbsp;
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Data Produk</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="/produk/create">Tambah Data</a>
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
                                        Data produk merupakan data informasi produk yang tersimpan pada sistem,
                                        digunakan sebagai informasi mengenai produk yang UMKM Anda jual.
                                    </p>
                                    <table id="datatable-responsive"
                                        class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>Nama Produk</th>
                                                <th>Kategori</th>
                                                <!-- <th>Harga Produk</th> -->
                                                <th>Deksripsi Produk</th>
                                                <th>Foto</th>
                                                <th>Foto</th>
                                                <th>Foto</th>
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
                                                <td>{{ $item->category }}</td>
                                                <td>
                                                    {{$item->desc = Str::limit($item->desc, 20)}}
                                                </td>
                                                @if($item->pict_1 != null)
                                                <td>
                                                    <a href="{{asset('/data_produk/'.$item->pict_1)}}" target="_blank">
                                                        {{$item->pict_1 = Str::limit($item->pict_1, 15)}}
                                                    </a>
                                                </td>
                                                @else
                                                <td>Belum ada foto</td>
                                                @endif
                                                @if($item->pict_2 != null)
                                                <td>
                                                    <a href="{{asset('/data_produk/'.$item->pict_2)}}" target="_blank">
                                                        {{$item->pict_2 = Str::limit($item->pict_2, 15)}}
                                                    </a>
                                                </td>
                                                @else
                                                <td>Belum ada foto</td>
                                                @endif
                                                @if($item->pict_3 != null)
                                                <td>
                                                    <a href="{{asset('/data_produk/'.$item->pict_3)}}" target="_blank">
                                                        {{$item->pict_3 = Str::limit($item->pict_3, 15)}}
                                                    </a>
                                                </td>
                                                @else
                                                <td>Belum ada foto</td>
                                                @endif
                                                <td>
                                                    <a href="{{route('produk.show', [$item->id])}}"
                                                        class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View
                                                    </a>
                                                    <a href="{{route('produk.edit', [$item->id])}}"
                                                        class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                                                        Edit </a>
                                                    <a href="{{route('detail_produk.show', [$item->id])}}"
                                                        class="btn btn-info btn-xs"><i class="fa fa-plus"></i>
                                                        Tambah Varian </a>
                                                </td>
                                                @if(auth()->user()->role == "admin")
                                                <td>
                                                    <form action="{{route('produk.destroy', $item->id)}}" method="post">
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
                                                <td colspan="8">Data Produk Kosong</td>
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
@endsection