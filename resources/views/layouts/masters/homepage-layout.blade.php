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
    <link rel="stylesheet" href="{{ URL::asset('css/daterangepicker.css') }}">
</head>
<body class="innerbody">   

    <div id="wrap-main">
        <aside class="top-wrap">
            @include('layouts.partials.loginform')
            @include('layouts.partials.banner')
            @include('layouts.partials.homenavigation')
        </aside>

        <aside class="map">
            @yield('left-section')  
            @yield('legend-section')  
            @yield('page-content')
            <div id="calendarDiv">
                <div id="calendarDivHeader"><span class="glyphicon glyphicon-calendar"></span>Pick a date</div>
                        <div class="well" style="background-color: #262626; color: #FFFFFF; margin-bottom: -20px;">
                            <div id="reportrange" style="background: #fff;cursor: pointer; padding: 5px 10px; border: 2px solid #fff; width: 100%; color: black;">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                        <div>
                            <br>
                            <a href="#" id="all-viewmap" class="mapviewbtn4" style="vertical-align:middle" onclick="$(this).toggleIconWithDateFilter()"><span>Proceed </span></a>
                        </div>
                </div>
        </aside>
        

        
    </div>
     
        <script src="{!! url('js/jquery1-11-3.min.js')!!}"></script>   
        <script type="text/javascript" src="{!! url('js/jquery-2.2.0.js') !!}"></script>
        <script src="{!! url('js/corejs.min.js')!!}"></script>
        <script src="{!! url('js/jqueryui.min.js')!!}"></script>
        <script src="{!! url('js/jquery.js')!!}"></script>
        <script src="{!! url('js/bootstrap.min.js') !!}"></script>
        <script src="http://maps.google.com/maps/api/js?key=AIzaSyC058wNQG2iAeF7z0ysRHQw_0Gsqd6Xp5s"></script>
        <script src="{!! url('assets/js/notification.js')!!}"></script>
        <script src="{!! url('js/jquery.mmenu.all.min.js')!!}"></script>
        <script src="{!! url('js/jquery.fancybox.pack.js')!!}"></script>
        <script src="{!! url('assets/js/responsive.js')!!}"></script>
        <script type="text/javascript" src="{!! url('js/moment.js') !!}"></script>
        <script type="text/javascript" src="{!! url('js/daterangepicker.js') !!}"></script>
        @yield('page-js-files')
        
        <script type="text/javasript">
            
         
          $('#modalLoginForm').modal();
         
    </script>
    
</body>
</html>