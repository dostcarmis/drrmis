<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Monitoring & Early Warning Systems for Landslides & Other Hazards</title>
    
    <link rel="icon" href="{{ URL::asset('assets/images/favicon.png') }}" type="image/x-icon" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />  
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link  href="{{ URL::asset('css/sb-admin.css') }}" rel="stylesheet">   
    <link href="{{ URL::asset('assets/css/skin.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/responsive.css') }}" rel="stylesheet">
    <link  href="{{ URL::asset('css/plugins/morris.css') }}" rel="stylesheet">  
    <link href="{{ URL::asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('assets/fonts/allfonts/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/dropzone/dropzone.css') }}">

	<link rel="stylesheet" href="{!! url('css/plugins/kendo-ui/kendo.common.min.css') !!}">
    <link rel="stylesheet" href="{!! url('css/plugins/kendo-ui/kendo.flat.min.css') !!}">
    <link rel="stylesheet" href="{!! url('css/plugins/kendo-ui/kendo.flat.mobile.min.css') !!}">
    <link rel="stylesheet" href="{!! url('css/plugins/kendo-ui/kendo.dataviz.flat.min.css') !!}">
	<link rel="stylesheet" href="{!! url('assets/css/sms.css') !!}">
    <link rel="stylesheet" href="{!! url('css/select2.min.css') !!}">

</head>
<body class="bckclass">

    @include('layouts.partials.nav')

    <aside  id="wrapper">
        <div id="page-wrapper">
            <div class="container-fluid">
                @yield('page-content')
               
            </div>
        </div>
    </aside>

    <script>
        const baseURL = "{{ url('/') }}/";
    </script>
    <script src="{!! url('js/jquery-1.12.3.js')!!}"></script>
    <script src="{!! url('js/jquery-ui.min.js')!!}"></script>
    <script src="{!! url('js/bootstrap.min.js') !!}"></script>
	<script src="{!! url('js/moment.js') !!}"></script>
    <script src="{!! url('assets/js/notification.js')!!}"></script>
    <script src="{!! url('js/select2.full.min.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/plugins/kendo-ui/kendo.all.min.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/plugins/kendo-ui/jszip.min.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/plugins/kendo-ui/pako_deflate.min.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/plugins/morris/raphael.min.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/plugins/morris/morris.js') !!}"></script>
    @yield('page-js-files')
</body>
</html>
