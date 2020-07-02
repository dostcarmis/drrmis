<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Disaster Risk Reduction Management Information System (DRRMIS)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />  

    <link rel="icon" href="{{ URL::asset('assets/images/favicon.png') }}" type="image/x-icon" />
    <link  href="{{ URL::asset('css/sb-admin.css') }}" rel="stylesheet">   
    <link  href="{{ URL::asset('css/plugins/morris.css') }}" rel="stylesheet">      
    <link href="{{ URL::asset('assets/css/skin.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/jquery.mmenu.all.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('assets/fonts/allfonts/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/jquery.fancybox.min.css') }}">
</head>
<?php
if (Auth::check()) : ?>
<body class="innerbody">   
<?php else: ?>      
<body>
<?php endif;?>
    <div id="wrap-main">
        <aside class="top-wrap ">
            @include('layouts.partials.loginform')
            @include('layouts.partials.banner')
            @include('layouts.partials.homenavigation')
        </aside>
        <aside class="map">
            @yield('left-section')  
            @yield('page-content')
        </aside>
    </div>
        

        <script src="{!! url('js/jquery1-11-3.min.js')!!}"></script> 
        <script type="text/javascript" src="{{ URL::asset('js/jquery-2.2.0.js') }}"></script>
        


        <script src="{!! url('js/corejs.min.js')!!}"></script>
        <script src="{!! url('js/jqueryui.min.js')!!}"></script>
  

        <script src="{!! url('js/jquery.js')!!}"></script>
        <script src="{!! url('js/bootstrap.min.js') !!}"></script>
        <script src="http://maps.google.com/maps/api/js?key=AIzaSyC058wNQG2iAeF7z0ysRHQw_0Gsqd6Xp5s"></script>
        <script src="{!! url('js/jquery.fancybox.pack.js')!!}"></script>
        <script src="{!! url('assets/js/notification.js')!!}"></script>
        <script src="{!! url('assets/js/responsive.js')!!}"></script>
        <script src="{!! url('js/jquery.mmenu.all.min.js')!!}"></script>
        <script src="{!! url('assets/js/responsive.js')!!}"></script>
        @yield('page-js-files')

</body>
</html>