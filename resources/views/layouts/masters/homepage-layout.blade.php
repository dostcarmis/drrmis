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
    <script>
        const baseURL = "{{ url('/') }}/";
    </script>
    <script src="{!! url('js/jquery1-11-3.min.js')!!}"></script>   
    <script type="text/javascript" src="{!! url('js/jquery-2.2.0.js') !!}"></script>
    <script src="{!! url('js/corejs.min.js')!!}"></script>
    <script src="{!! url('js/jqueryui.min.js')!!}"></script>
    <script src="{!! url('js/jquery.js')!!}"></script>
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
        
        @if (Auth::check())
            <div id="footer-icons" class="row bg-white md-d-none">
                <div class="col-xs-3 col-sm-3 footer-icon pos-rel">
                    <a href="{{ action("HydrometController@dashboard") }}" class="small-caps nav-link clearformat w-100 h-100" >
                        <div class="w-100 h-100">
                            <div class="pos-rel y-centered">
                                <span class="pos-rel">
                                    <i class="fa fa-tachometer" aria-hidden="true"></i><br>
                                    dashboard
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xs-3 col-sm-3 footer-icon pos-rel">
                    <a data-toggle="modal" data-target="#selectfilemodal" class="small-caps nav-link clearformat">
                        <div class="w-100 h-100">
                            <div class="pos-rel y-centered">
                                <span class="pos-rel">
                                    <i class="fa fa-download"></i><br>
                                    km resources
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xs-3 col-sm-3 footer-icon pos-rel">
                    <a data-toggle="modal" data-target="#selectsitreplevelmodal" class="small-caps nav-link clearformat">
                        <div class="w-100 h-100">
                            <div class="pos-rel y-centered">
                                <span class="pos-rel">
                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i><br>
                                    sitreps
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xs-3 col-sm-3 footer-icon pos-rel" id="footer-profile">
                    <div class="w-100 h-100">
                        <div class="pos-rel y-centered">
                            <span class="pos-rel small-caps">
                                <i class="fa fa-user" aria-hidden="true"></i><br>
                                user
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="footer-cabinet" class="pos-f w-100 b0 bg-white">
                <div class="container d-flex pt-3">
                    <img class="smimg me-3" src="{{ Auth::user()->profile_img }}" style="height: 50px !important; width: 50px !important;">
                    <div>
                        {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} 
                        <p>
                            <a href="{{ action("UserController@profile") }}">Profile</a><br>
                            {!! link_to_route('get_logout', 'Log out') !!}
                        </p>

                    </div>
                </div>
            </div>
        @endif
        
    </div>
        
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