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
    <link href="{{ URL::asset('css/jquery.mmenu.all.css') }}" rel="stylesheet">
    <link  href="{{ URL::asset('css/sb-admin.css') }}" rel="stylesheet">   
    <link href="{{ URL::asset('assets/css/skin.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/responsive.css') }}" rel="stylesheet">
    <link  href="{{ URL::asset('css/plugins/morris.css') }}" rel="stylesheet">  

    <link rel="stylesheet" href="{{ URL::asset('css/plugins/fontawesome/css/all.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('assets/fonts/allfonts/stylesheet.css') }}">

	
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
	<link rel="stylesheet" href="{{ asset('css/buttons.dataTables.css') }}">
	<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker3.css') }}">
	<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">

	
</head>
<body class="web-view">

    @include('layouts.partials.nav')
 
    <div id="main">
        <aside  id="wrapper">
        @yield('mobilemenus')
            <div id="page-wrapper">
                <div class="container-fluid">
                    @yield('page-content')
                </div>
            </div>
        </aside>
    </div>
    <script>
        const baseURL = "{{ url('/') }}/";
    </script>
    <script src="{!! url('js/jquery1-11-3.min.js')!!}"></script>  
    <script>window.jQuery || document.write('<script src="../js/jquery.js"><\/script>')</script>
    <script src="{!! url('js/code-jquery-1.12.3.min.js')!!}"></script>
    <script src="{!! url('js/code-jquery-ui.1.11.4.min.js')!!}"></script>
    <script src="{!! url('js/jquery.js') !!}"></script>
    <script src="{!! url('js/bootstrap.min.js') !!}"></script>
    <script src="{!! url('assets/js/main.js') !!}"></script>

	<script type="text/javascript" src="{!! url('js/plugins/Highcharts-4.2.6/js/highcharts.js') !!}"></script>
	<script type="text/javascript" src="{!! url('js/plugins/Highcharts-4.2.6/js/modules/exporting.js') !!}"></script>
	<script type="text/javascript" src="{!! url('js/plugins/Highcharts-4.2.6/js/modules/offline-exporting.js') !!}"></script>
	<script type="text/javascript" src="{!! url('js/plugins/Highcharts-4.2.6/js/themes/dark-blue.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/plugins/Highcharts-4.2.6/js/modules/no-data-to-display.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/jquery.dataTables.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/dataTables.bootstrap.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/dataTables.buttons.js') !!}"></script>

    <script type="text/javascript" src="{!! url('css/plugins/fontawesome/js/all.js') !!}"></script>


    <script src="{!! url('js/moment.js') !!}"></script>
   <script src="{!! url('js/bootstrap-datetimepicker.min.js') !!}"></script>
   <script type="text/javascript" src="{!! url('js/jquery.validate.min.js') !!}"></script>
   <script src="{!! url('assets/js/notification.js')!!}"></script>
   <script src="{!! url('js/jquery.mmenu.all.js')!!}"></script>
   <script src="{!! url('assets/js/responsive.js')!!}"></script>

    @yield('page-js')
</body>
</html>
