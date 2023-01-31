@extends('admin.layouts.app')
@section('title')
Data User, Number ID : {{ $user[0]->id }}
@endsection
@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <p>
                    <a href="/admin">Home</a>&nbsp;<small><i class="fa fa-long-arrow-right"></small></i>
                    <a href="/user">User</a>&nbsp;<small><i class="fa fa-long-arrow-right"></small></i>
                    <a href="#">User Profile, Number ID : {{ $user[0]->id }}</a>
                </p>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Detail User</small></h2>
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
                                    @if($user[0]->pict == null)
                                    <img class="img-responsive avatar-view"
                                        src="{{asset('toko/production/images/user.png')}}" alt="Avatar"
                                        title="Change the avatar">
                                    @else
                                    <img class="img-responsive avatar-view"
                                        src="{{ url('/data_file/'.$user[0]->pict) }}" alt="{{ $user[0]->pict }}"
                                        width="40%" height="60%" title="Change the avatar">
                                    @endif
                                </div>
                            </div>
                            <h3>{{ $user[0]->first_name }}&nbsp;{{ $user[0]->last_name }}</h3>
                            <h3>Role:&nbsp;{{ $user[0]->role }}</h3>
                            <ul class="list-unstyled user_data">
                                <li>
                                    <i class="fa fa-map-marker user-profile-icon">&nbsp;</i>Alamat
                                    <br>
                                    <strong>
                                        "{{ $user[0]->address }},
                                        {{ $user[0]->districts }},
                                        {{ $user[0]->ward }},
                                        {{ $user[0]->city }},
                                        {{ $user[0]->province }}"
                                    </strong>
                                </li>
                                <li>
                                    <i class="fa fa-briefcase user-profile-icon">&nbsp; </i>Postal Code
                                    <br>
                                    <Strong>
                                        "{{ $user[0]->postal_code }}"
                                    </Strong>
                                </li>
                                <li class="m-top-xs">
                                    <i class="fa fa-phone user-profile-icon">&nbsp; </i>Phone Number
                                    <br>
                                    <a href="#" target="_blank">
                                        <Strong>
                                            "{{ $user[0]->phone }}"
                                        </Strong>
                                    </a>
                                </li>
                            </ul>
                            <a href="{{route('user.edit', [Crypt::encrypt($user[0]->id)])}}" class="btn btn-success"
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
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    Highcharts.chart('charttransaction', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Diagram Transaksi Penjualan'
        },
        subtitle: {
            text: 'I Love U'
        },
        xAxis: {
            categories: [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Transaksi Penjualan'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} Pcs</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Produk 01',
            data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

        }, {
            name: 'Produk 02',
            data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

        }, {
            name: 'Produk 03',
            data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

        }, {
            name: 'Produk 04',
            data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

        }]
    });
</script>
@endsection