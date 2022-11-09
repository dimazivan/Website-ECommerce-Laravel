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
                    <a href="#">Data Customer</a>&nbsp;
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Data Customer</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
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
                                        Data customer merupakan rincian informasi detail dari user yang terdaftar pada
                                        sistem.
                                    </p>
                                    <table id="datatable-responsive"
                                        class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th style="text-transform:uppercase;">Alamat</th>
                                                <th style="text-transform:uppercase;">Kelurahan</th>
                                                <th style="text-transform:uppercase;">Kecamatan</th>
                                                <th style="text-transform:uppercase;">Kota</th>
                                                <th style="text-transform:uppercase;">Provinsi</th>
                                                <th style="text-transform:uppercase;">Postal Code</th>
                                                <th>Nomor Telepon</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($page as $item)
                                            <tr>
                                                <td>{{ $item->first_name }}&nbsp;{{ $item->last_name }}</td>
                                                <td>{{ $item->address }}, {{ $item->districts }}, {{ $item->ward }}</td>
                                                <td>{{ $item->districts }}</td>
                                                <td>{{ $item->ward }}</td>
                                                <td>{{ $item->city }}</td>
                                                <td>{{ $item->province }}</td>
                                                <td>{{ $item->postal_code }}</td>
                                                <td>{{ $item->phone }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5">Data Customer Kosong</td>
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