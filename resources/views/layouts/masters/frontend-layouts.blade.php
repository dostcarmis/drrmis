<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Monitoring & Early Warning Systems for Landslides & Other Hazards</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />  
    <link rel="icon" href="{{ URL::asset('assets/images/favicon.png') }}" type="image/x-icon" />
    <link  href="{{ URL::asset('css/sb-admin.css') }}" rel="stylesheet">   
    <link href="{{ URL::asset('css/jquery.mmenu.all.css') }}" rel="stylesheet">
    <link  href="{{ URL::asset('css/plugins/morris.css') }}" rel="stylesheet">      
    <link href="{{ URL::asset('assets/css/skin.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('assets/fonts/allfonts/stylesheet.css') }}">
     <link rel="stylesheet" href="{!! url('css/buttons.dataTables.css') !!}">
     <link rel="stylesheet" href="{{ URL::asset('css/jquery.fancybox.min.css') }}">

</head>
<?php
if (Auth::check()) : ?>
<body class="innerbody">   
<?php else: ?>      
<body class="innerbody">
<?php endif;?>
    
    <div id="main" class="content-page">
        <aside class="top-wrap ">
            @include('layouts.partials.loginform')
            @include('layouts.partials.banner')
            @include('layouts.partials.homenavigation')
        </aside>
        <aside class="fpages">
            <div class="container">
                @yield('page-content')
            </div>
        </aside>
    </div>
        
        <script src="{!! url('js/jquery1-11-3.min.js')!!}"></script> 
        <script>window.jQuery || document.write('<script src="{!!url('../../js/jquery.min.js') !!}"><\/script>')</script>
        <script src="{!! url('js/code-jquery-1.12.3.min.js')!!}"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="{!! url('js/jquery.js')!!}"></script>
        <script src="{!! url('js/bootstrap.min.js') !!}"></script>
        <script src="{!! url('assets/js/notification.js')!!}"></script>
        <script src="{!! url('assets/js/search.js')!!}"></script>
        <script src="{!! url('assets/js/jquery.tablesorter.js')!!}"></script>
        <script type="text/javascript" src="{!! url('js/jquery.dataTables.js') !!}"></script>
        <script type="text/javascript" src="{!! url('js/dataTables.bootstrap.js') !!}"></script>
        <script type="text/javascript" src="{!! url('js/dataTables.buttons.js') !!}"></script>
        <script src="{!! url('js/jquery.fancybox.pack.js')!!}"></script>
        <script src="{!! url('js/jquery.mmenu.all.min.js')!!}"></script>
        <script src="{!! url('assets/js/responsive.js')!!}"></script>
        @yield('page-js-files')
</body>
</html>