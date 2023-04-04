<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('toko/production/images/favicon.ico')}}" type="image/ico" />

    <title>@yield('title')</title>
    <!-- preloader -->
    <style>
        #preloader {
            background: white url("<?php echo asset('toko/production/images/loading.gif') ?>") no-repeat center center;
            height: 100vh;
            width: 100%;
            position: fixed;
            z-index: 99999;
            opacity: 50%;
        }
    </style>

    <!-- Bootstrap -->
    <link href="{{asset('toko/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('toko/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('toko/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset('toko/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">

    <!-- bootstrap-wysiwyg -->
    <link href="{{asset('toko/vendors/google-code-prettify/bin/prettify.min.css')}}" rel=" stylesheet">
    <!-- Select2 -->
    <link href="{{asset('toko/vendors/select2/dist/css/select2.min.css')}}" rel=" stylesheet">
    <!-- Switchery -->
    <link href="{{asset('toko/vendors/switchery/dist/switchery.min.css')}}" rel=" stylesheet">
    <!-- starrr -->
    <link href="{{asset('toko/vendors/starrr/dist/starrr.css')}}" rel=" stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{asset('toko/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel=" stylesheet">
    <!-- Datatables -->

    <link href="{{asset('toko/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('toko/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('toko/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}"
        rel="stylesheet">
    <link href="{{asset('toko/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}"
        rel="stylesheet">
    <link href="{{asset('toko/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{asset('toko/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}"
        rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{asset('toko/vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="{{asset('toko/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{asset('toko/build/css/custom.min.css')}}" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->

</head>

<body class="nav-md">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    @include('sweetalert::alert')
    <!-- <div id="preloader" class="preloader">PLEASE WAIT...</div> -->
    <div id="preloader" class="preloader"></div>
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    @include('admin.layouts.sidebar')
                </div>
            </div>
            @include('admin.layouts.header')

            @yield('content')

            @include('admin.layouts.footer')
        </div>
    </div>

    <!-- jQuery -->
    <!-- <script src="{{asset('toko/vendors/jquery/dist/jquery.min.js')}}"></script> -->
    <!-- <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script> -->
    <!-- <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script> -->
    <script src="{{asset('toko/vendors/jquery/dist/repeater.js')}}"></script>
    <script src="{{asset('toko/vendors/jquery/dist/repeater_total.js')}}"></script>
    <!-- <script src="{{asset('customer/js/vendor/disable-dtb.js')}}"></script> -->
    <script src="{{asset('customer/js/vendor/raja_ongkir.js')}}"></script>
    <script src="{{asset('toko/vendors/jquery/dist/total.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('toko/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('toko/vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{asset('toko/vendors/nprogress/nprogress.js')}}"></script>
    <!-- morris.js -->
    <script src="{{asset('toko/vendors/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('toko/vendors/morris.js/morris.min.js')}}"></script>
    <!-- Chart.js -->
    <!-- <script src="{{asset('toko/vendors/Chart.js/dist/Chart.min.js')}}"></script> -->
    <!-- gauge.js -->
    <script src="{{asset('toko/vendors/gauge.js/dist/gauge.min.js')}}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{asset('toko/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
    <!-- iCheck -->
    <script src="{{asset('toko/vendors/iCheck/icheck.min.js')}}"></script>
    <!-- Skycons -->
    <script src="{{asset('toko/vendors/skycons/skycons.js')}}"></script>
    <!-- Flot -->
    <script src="{{asset('toko/vendors/Flot/jquery.flot.js')}}"></script>
    <script src="{{asset('toko/vendors/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('toko/vendors/Flot/jquery.flot.time.js')}}"></script>
    <script src="{{asset('toko/vendors/Flot/jquery.flot.stack.js')}}"></script>
    <script src="{{asset('toko/vendors/Flot/jquery.flot.resize.js')}}"></script>
    <!-- Flot plugins -->
    <script src="{{asset('toko/vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
    <script src="{{asset('toko/vendors/flot-spline/js/jquery.flot.spline.min.js')}}"></script>
    <script src="{{asset('toko/vendors/flot.curvedlines/curvedLines.js')}}"></script>
    <!-- DateJS -->
    <!-- Datatables -->
    <script src="{{asset('toko/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('toko/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('toko/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('toko/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('toko/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('toko/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('toko/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('toko/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('toko/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('toko/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('toko/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{asset('toko/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{asset('toko/vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{asset('toko/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('toko/vendors/pdfmake/build/vfs_fonts.js')}}"></script>

    <script src="{{asset('toko/vendors/DateJS/build/date.js')}}"></script>

    <!-- Validator Form -->
    <script src="{{asset('toko/vendors/validator/multifield.js')}}"></script>
    <script src="{{asset('toko/vendors/validator/validator.js')}}"></script>

    <!-- bootstrap-daterangepicker -->
    <script src="{{asset('toko/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('toko/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

    <!-- jQuery Sparklines -->
    <script src="{{asset('toko/vendors/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
    <!-- Flot -->
    <script src="{{asset('toko/vendors/Flot/jquery.flot.js')}}"></script>
    <script src="{{asset('toko/vendors/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('toko/vendors/Flot/jquery.flot.time.js')}}"></script>
    <script src="{{asset('toko/vendors/Flot/jquery.flot.stack.js')}}"></script>
    <script src="{{asset('toko/vendors/Flot/jquery.flot.resize.js')}}"></script>
    <!-- Flot plugins -->
    <!-- <script src="{{asset('toko/vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
    <script src="{{asset('toko/vendors/flot-spline/js/jquery.flot.spline.min.js')}}"></script>
    <script src="{{asset('toko/vendors/flot.curvedlines/curvedLines.js')}}"></script> -->
    <!-- DateJS -->
    <script src="{{asset('toko/vendors/DateJS/build/date.js')}}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{asset('toko/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('toko/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script> -->

    <!-- Custom Theme Scripts -->
    <script src="{{asset('toko/build/js/custom.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script> -->

    <!-- <script src="{{asset('customer/js/vendor/disable-dtb.js')}}"></script> -->

    <script>
        var loader = document.getElementById('preloader');

        window.addEventListener("load", function() {
            loader.style.display = "none";
        });
    </script>

</body>

</html>