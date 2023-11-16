<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="robots" content="nofollow, noindex">
	<title>Admin Panel</title>
	<link rel="shortcut icon" href="assets/dist/img/favicon.png">
	<link href="{{asset('b/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link href="{{asset('b/plugins/metisMenu/metisMenu.min.css')}}" rel="stylesheet">
	<link href="{{asset('b/plugins/lightbox/css/lightbox.css')}}" rel="stylesheet">
	{{-- <link type="text/css" href="{{asset('b/plugins/fontawesome/css/all.min.css')}}" rel="stylesheet"> --}}
	{{-- <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"> --}}
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" 
integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" 
crossorigin="anonymous">
	<link href="{{asset('b/plugins/typicons/src/typicons.min.css')}}" rel="stylesheet">
	<link href="{{asset('b/plugins/themify-icons/themify-icons.min.css')}}" rel="stylesheet">
	<link href="{{asset('b/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
	<link href="{{asset('b/dist/css/style.css')}}" rel="stylesheet">
	<link href="{{ asset('b/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('b/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('b/plugins/flatpicker/flatpickr.min.css') }}" rel="stylesheet">
	<link href="{{asset('b/plugins/summernote/summernote.css')}}" rel="stylesheet">
        <link href="{{asset('b/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
		<link href="{{asset('b/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">
	{{-- <link rel="stylesheet" type="text/css" href="{{ asset('b/plugins/select2/dist/css/dataTables.bootstrap4.min.css') }}"> --}}
	<link rel="stylesheet" href="{{ asset('b/datatables.net-bs/css/fixedColumns.dataTables.min.css') }}">
	<link rel="stylesheet" href="{{ asset('b/datatables.net-bs/css/buttons.dataTables.min.css') }}">
	<link href="{{ asset('b/plugins/fullcalendar/packages/core/main.min.css') }}" rel="stylesheet">
	<link href="{{ asset('b/plugins/fullcalendar/packages/daygrid/main.min.css') }}" rel="stylesheet">
	<link href="{{ asset('b/plugins/fullcalendar/packages/timegrid/main.min.css') }}" rel="stylesheet">
	<link href="{{ asset('b/plugins/fullcalendar/packages/list/main.min.css') }}" rel="stylesheet">
	<style>
		.sidebar-bunker {
			background-color: #6aa4e6 !important;
		}
		.sidebar-bunker .profile-element .profile-text span {
			color: #fff;
		}
		.sidebar-nav ul li a {
			color: #fff;
		}
		.sidebar-nav ul li .nav-second-level li a {
			color: #fff;
		}
		.sidebar-nav ul li.mm-active a {
			color: #fff;
			background-color: #041e42;
			box-shadow: 0 0 10px 1px rgb(255 255 255 / 70%);
		}
		.btn-success {
			color: #fff;
			background-color: #041e42;
			border-color: #041e42;
		}
		.sidebar-toggle-icon span {
			background: #041e42;
		}
		.btn-success {
			box-shadow: 0 2px 6px 0 rgb(255 255 255 / 50%);
		}
		a {
			color: #041e42;
			text-decoration: none;
		}
		.breadcrumb-item.active {
			color: #041e42;
		}
		.dataTables_wrapper .pagination .page-item.active>.page-link {
			background: #041e42;
			color: #fff;
		}
		.sidebar-toggle-icon span:after, .sidebar-toggle-icon span:before {
			background: #041e42;
		}
		.spinner-layer.pl-green {
			border-color: #041e42;
		}
		.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
			background-color: #041e42;
			box-shadow: 0 2px 6px 0 rgb(255 255 255 / 50%);
		}
	</style>
