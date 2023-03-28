<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <base href="{{ asset('/') }}">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title> Tickd | Admin </title>
    <link rel="shortcut icon" href="{{ asset('/images/favicon.ico') }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

    <!-- Popping Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" href="{{ asset('/admin') }}/app-assets/css/vendors.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN STACK CSS-->
    <link rel="stylesheet" href="{{ asset('/admin') }}/app-assets/css/app.css">
    <!-- END STACK CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" href="{{ asset('/admin') }}/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <!-- END Page Level CSS-->
    <link rel="stylesheet" href="{{ asset('/admin') }}/app-assets/css/plugins/calendars/fullcalendar.css">
    <link rel="stylesheet" href="{{ asset('/admin') }}/app-assets/vendors/css/calendars/fullcalendar.min.css">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('admin/assets/css/intlTelInput.css')}}">
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" href="{{ asset('/admin') }}/assets/css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" href="{{ asset('/admin') }}/assets/css/CustomScrollbar.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- <link rel="stylesheet" href="{{ asset('/admin') }}/app-assets/vendors/css/tables/datatable/datatables.min.css"> -->

    <link rel="stylesheet" href="{{ asset('/admin') }}/assets/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('/admin') }}/assets/css/datatables.min.css">
    <link rel="stylesheet" href="{{ asset('/admin') }}/assets/css/style.css">
    <link rel="stylesheet" href="{{ asset('/admin/assets/css/new.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/assets/css/responsive.css') }}">
  
  <!-- END Custom CSS-->

  <!-- Owl Carousel -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css"/>

  <!-- Slick Slider -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
        @if (Auth::guard('admin')->check())
            <script>
               window.Laravel = {!!json_encode([
                   'isLoggedin' => true,
                   'user' => Auth::guard('admin')->user(),
                   'as' => 'admin',
               ])!!}
            </script>
        @else
            <script>
                window.Laravel = {!!json_encode([
                    'isLoggedin' => false,
                    'user' => null,
                    'as' => 'user',
                ])!!}
            </script>
        @endif

</head>
<?php
    $title = 'Login';
?>
<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">

        <div id="app"></div>

 <script src="{{asset('js/app.js')}}"></script>

@routes
<!-- BEGIN VENDOR JS--> 
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="{{ asset('admin/') }}/app-assets/vendors/js/vendors.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> 


<!-- Slick Slider -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="{{ asset('admin/') }}/assets/js/function.js" ></script> 


<script src="{{ asset('admin/') }}/app-assets/js/core/app-menu.js" ></script> 
<script src="{{ asset('admin/') }}/app-assets/js/core/app.js" ></script> 
<script src="{{ asset('admin/') }}/app-assets/js/scripts/customizer.js" ></script> 
<script src="{{ asset('admin/') }}/assets/js/jquery.repeater.min.js" ></script> 
<script src="{{ asset('admin/') }}/assets/js/form-repeater.js" ></script> 
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js"></script>
<script src="{{ asset('admin/') }}/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="{{ asset('admin/') }}/app-assets/vendors/js/extensions/moment.min.js" ></script> 
<script src="{{ asset('admin/') }}/app-assets/js/scripts/modal/components-modal.js" ></script> 
<script src="{{ asset('admin/assets/js/intlTelInput.js') }}"></script> 
</body>
</html>