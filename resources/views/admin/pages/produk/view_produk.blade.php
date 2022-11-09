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
                    <a href="/produk">Produk</a>&nbsp;<small><i class="fa fa-long-arrow-right"></small></i>
                    <a href="#">Produk, Number ID : {{ $page[0]->products_id }}</a>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Detail Produk, Number ID : {{ $page[0]->products_id }} </h2>
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
                        <div class="col-md-12 col-sm-12">
                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#tab_detail" id="home-tab"
                                            role="tab" data-toggle="tab" aria-expanded="true">
                                            Detail Produk
                                        </a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_deskripsi" role="tab"
                                            id="profile-tab" data-toggle="tab" aria-expanded="false">
                                            Deskripsi Produk
                                        </a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_varian" role="tab" id="contact-tab"
                                            data-toggle="tab" aria-expanded="false">
                                            Varian Produk
                                        </a>
                                    </li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane active " id="tab_detail"
                                        aria-labelledby="home-tab">
                                        <div class="col-md-3 col-sm-3 profile_left" style="margin-top:20px;">
                                            <ul class="list-unstyled user_data">
                                                <li>
                                                    <i class="fa fa-dropbox user-profile-icon">&nbsp;</i>Nama Produk
                                                    <br>
                                                    <strong>
                                                        "{{ $page[0]->name }}"
                                                    </strong>
                                                </li>
                                                <li>
                                                    <i class="fa fa-list user-profile-icon">&nbsp; </i>Kategori Produk
                                                    <br>
                                                    <Strong>
                                                        "{{ $page[0]->category }}"
                                                    </Strong>
                                                </li>
                                                <li>
                                                    <i class="fa fa-list user-profile-icon">&nbsp; </i>Jumlah Stok
                                                    Keseluruhan
                                                    <br>
                                                    <Strong>
                                                        <!--  -->
                                                        {{ $jml_page }} Pcs
                                                    </Strong>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3 col-sm-3 ">
                                            <div class="profile_img">
                                                <div id="crop-avatar">
                                                    <a href="{{asset('/data_produk/'.$page[0]->pict_1)}}"
                                                        target="_blank">
                                                        <img class="img-responsive avatar-view"
                                                            src="{{ url('/data_produk/'.$page[0]->pict_1) }}"
                                                            alt="$page[0]->pict_1"
                                                            style="width:300px;height:300px;object-fit:cover;object-position:center"
                                                            title="Gambar Produk">
                                                    </a>
                                                </div>
                                            </div>
                                            <strong>
                                                <p>Gambar 1 Produk</p>
                                            </strong>
                                        </div>
                                        <div class="col-md-3 col-sm-3 ">
                                            <div class="profile_img">
                                                <div id="crop-avatar">
                                                    <a href="{{asset('/data_produk/'.$page[0]->pict_2)}}"
                                                        target="_blank">
                                                        <img class="img-responsive avatar-view"
                                                            src="{{ url('/data_produk/'.$page[0]->pict_2) }}"
                                                            alt="$page[0]->pict_1"
                                                            style="width:300px;height:300px;object-fit:cover;object-position:center"
                                                            title="Gambar Produk">
                                                    </a>
                                                </div>
                                            </div>
                                            <strong>
                                                <p>Gambar 2 Produk</p>
                                            </strong>
                                        </div>
                                        <div class="col-md-3 col-sm-3 ">
                                            <div class="profile_img">
                                                <div id="crop-avatar">
                                                    <a href="{{asset('/data_produk/'.$page[0]->pict_3)}}"
                                                        target="_blank">
                                                        <img class="img-responsive avatar-view"
                                                            src="{{ url('/data_produk/'.$page[0]->pict_3) }}"
                                                            alt="$page[0]->pict_1"
                                                            style="width:300px;height:300px;object-fit:cover;object-position:center"
                                                            title="Gambar Produk">
                                                    </a>
                                                </div>
                                            </div>
                                            <strong>
                                                <p>Gambar 3 Produk</p>
                                            </strong>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_deskripsi"
                                        aria-labelledby="profile-tab">
                                        <!-- start recent activity -->
                                        <p style="margin-left:15px;">{{ $page[0]->desc }}</p>
                                        <!-- end recent activity -->
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_varian"
                                        aria-labelledby="contact-tab">
                                        <a style="margin-left:15px;"
                                            href="{{route('detail_produk.show', [$page[0]->products_id])}}"
                                            class="btn btn-success">
                                            <i class="fa fa-plus m-right-xs"></i>
                                            Tambah Data Varian Produk
                                        </a>
                                        <!-- start user projects -->
                                        <table id="datatable-responsive"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Ukuran Produk</th>
                                                    <th>Warna Produk</th>
                                                    <th>Stok Produk</th>
                                                    <th>Modal</th>
                                                    <th>Harga Produk</th>
                                                    <th>Harga Promo</th>
                                                    <th>Aksi</th>
                                                    @if(auth()->user()->role == "admin")
                                                    <th></th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($detail as $item)
                                                <tr>
                                                    <td style="text-transform:uppercase;">{{ $item->size }}</td>
                                                    <td style="text-transform:uppercase;">{{ $item->color }}</td>
                                                    <td>{{ $item->qty }}</td>
                                                    <td>Rp. {{number_format($item->modal,2,',','.')}}</td>
                                                    <td>Rp. {{number_format($item->price,2,',','.')}}</td>
                                                    <td>Rp. {{number_format($item->promo,2,',','.')}}</td>
                                                    <td>
                                                        <a href="{{route('detail_produk.edit', [$item->id])}}"
                                                            class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                                                            Edit </a>
                                                    </td>
                                                    @if(auth()->user()->role == "admin")
                                                    <td>
                                                        <form action="{{route('detail_produk.destroy', $item->id)}}"
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
                                                    <td colspan="6">Data Produk Kosong</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        <!-- end user projects -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-success" style="color:white;margin-left:10px;"
                        href="{{route('produk.edit', [$page[0]->products_id])}}">
                        <i class="fa fa-edit m-right-xs"></i>
                        &nbsp;Edit Produk</a>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection