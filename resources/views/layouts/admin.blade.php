<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>iMeds</title>
    <base href="{{ asset('/') }}">
    <meta name="csrf_token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">	
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/vendors.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/app.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/jquery.mCustomScrollbar.css')}}" type="text/css">
	<link rel="stylesheet" href="{{asset('assets/css/CustomScrollbar.css')}}" type="text/css">
	<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}"/>
    @if (Auth::guard('admin')->check())
            <script>
               window.Laravel = {!!json_encode([
                   'base_url' => url(''),
                   'isLoggedin' => true,
                   'user' => Auth::guard('admin')->user(),
                   'as' => 'admin',
               ])!!}
            </script>
        @else
            <script>
                window.Laravel = {!!json_encode([
                    'base_url' => url(''),
                    'isLoggedin' => false,
                    'user' => null,
                    'as' => 'user',
                ])!!}
            </script>
        @endif
</head>
<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">
<div id="app"></div>
@routes
<script src="{{asset('app-assets/vendors/js/vendors.min.js')}}"></script>
<script src="{{asset('app-assets/js/core/app-menu.js')}}"></script>
<script src="{{asset('app-assets/js/core/app.js')}}"></script>
<script src="{{asset('assets/js/function.js')}}"></script>

<script src="{{asset('js/app.js')}}"></script>
</body>

</html>


