@extends('admin.layouts.app')
@section('title')
Data Supplier, Number ID :
{{ $supplier[0]->id }}
@endsection
@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <p>
                    <a href="/admin">Home</a>&nbsp;<small><i class="fa fa-long-arrow-right"></small></i>
                    <a href="/supplier">Supplier</a>&nbsp;<small><i class="fa fa-long-arrow-right"></small></i>
                    <a href="#">Supplier Profile, Number ID : {{ $supplier[0]->id }}</a>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Detail Supplier</small></h2>
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
                        <div class="col-md-3 col-sm-3  profile_left">
                            <div class="profile_img">
                                <div id="crop-avatar">
                                    <!-- Current avatar -->
                                    <img class="img-responsive avatar-view"
                                        src="{{asset('toko/production/images/user.png')}}" alt="Avatar"
                                        title="Change the avatar">
                                </div>
                            </div>
                            <h3>{{ $supplier[0]->name }}&nbsp;</h3>
                            <ul class="list-unstyled user_data">
                                <li>
                                    <i class="fa fa-map-marker user-profile-icon">&nbsp;</i>Alamat
                                    <br>
                                    <strong>
                                        "{{ $supplier[0]->address }}"
                                    </strong>
                                </li>
                                <li>
                                    <i class="fa fa-briefcase user-profile-icon">&nbsp; </i>Email
                                    <br>
                                    <Strong>
                                        "{{ $supplier[0]->email }}"
                                    </Strong>
                                </li>
                                <li class="m-top-xs">
                                    <i class="fa fa-phone user-profile-icon">&nbsp; </i>Phone Number
                                    <br>
                                    <a href="#" target="_blank">
                                        <Strong>
                                            "{{ $supplier[0]->phone }}"
                                        </Strong>
                                    </a>
                                </li>
                            </ul>
                            <a href="{{route('supplier.edit', [$supplier[0]->id])}}" class="btn btn-success"
                                style="color:white;"><i class="fa fa-edit m-right-xs"></i>&nbsp;Edit
                                Profile</a>
                            <br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection