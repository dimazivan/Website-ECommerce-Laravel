<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="{{asset('toko/production/images/favicon.ico')}}">
	<!-- Author Meta -->
	<meta name="dimaz" content="CodePixar">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>@yield('title')</title>
	<!-- preloader -->
	<style>
		#preloader {
			background: white url('toko/production/images/loading.gif') no-repeat center center;
			height: 100vh;
			width: 100%;
			position: fixed;
			z-index: 99999;
			opacity: 50%;
		}
	</style>
	<!--CSS============================================= -->
	<link rel="stylesheet" href="{{asset('customer/css/linearicons.css')}}">
	<link rel="stylesheet" href="{{asset('customer/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('customer/css/themify-icons.css')}}">
	<link rel="stylesheet" href="{{asset('customer/css/bootstrap.css')}}">
	<link rel="stylesheet" href="{{asset('customer/css/owl.carousel.css')}}">
	<link rel="stylesheet" href="{{asset('customer/css/nice-select.css')}}">
	<link rel="stylesheet" href="{{asset('customer/css/nouislider.min.css')}}">
	<link rel="stylesheet" href="{{asset('customer/css/ion.rangeSlider.css')}}" />
	<link rel="stylesheet" href="{{asset('customer/css/ion.rangeSlider.skinFlat.css')}}" />
	<link rel="stylesheet" href="{{asset('customer/css/magnific-popup.css')}}">
	<link rel="stylesheet" href="{{asset('customer/css/main.css')}}">
	@yield('style')
</head>

<body>
	<script src="{{asset('customer/js/vendor/jquery-2.2.4.min.js')}}"></script>
	@include('sweetalert::alert')
	<div id="preloader" class="preloader"></div>

	@include('customer.layouts.header')

	@yield('content')

	@include('customer.layouts.footer')

	<script src="{{asset('customer/js/vendor/copycode.js')}}"></script>
	<script src="{{asset('customer/js/vendor/raja_ongkir.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
		integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous">
	</script>
	<script src="{{asset('customer/js/vendor/bootstrap.min.js')}}"></script>
	<script src="{{asset('customer/js/jquery.ajaxchimp.min.js')}}"></script>
	<script src="{{asset('customer/js/jquery.nice-select.min.js')}}"></script>
	<script src="{{asset('customer/js/jquery.sticky.js')}}"></script>
	<script src="{{asset('customer/js/nouislider.min.js')}}"></script>
	<script src="{{asset('customer/js/countdown.js')}}"></script>
	<script src="{{asset('customer/js/jquery.magnific-popup.min.js')}}"></script>
	<script src="{{asset('customer/js/owl.carousel.min.js')}}"></script>
	<!--gmaps Js-->
	<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script> -->
	<!-- <script src="{{asset('customer/js/gmaps.min.js')}}"></script> -->
	<script src="{{asset('customer/js/main.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.3/clipboard.min.js"></script> -->
	<script>
		var loader = document.getElementById('preloader');

		window.addEventListener("load", function() {
			loader.style.display = "none";
		});
	</script>
</body>

</html>