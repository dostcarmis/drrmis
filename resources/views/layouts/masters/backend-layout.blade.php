<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Monitoring & Early Warning Systems for Landslides & Other Hazards</title>
    <link rel="icon" href="{{ URL::asset('assets/images/favicon.png')}}" type="image/x-icon" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />  
    <link href="{{ URL::asset('css/jquery.mmenu.all.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link  href="{{ URL::asset('css/sb-admin.css') }}" rel="stylesheet">   
    <link rel="stylesheet" href="{!! url('css/selectize.default.css') !!}">
    <link href="{{ URL::asset('assets/css/skin.css') }}" rel="stylesheet">
 	<link href="{{ URL::asset('assets/css/responsive.css') }}" rel="stylesheet">
    <link  href="{{ URL::asset('css/plugins/morris.css') }}" rel="stylesheet">  
    <link href="{{ URL::asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('assets/fonts/allfonts/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/dropzone/dropzone-1.css') }}">
    <link rel="stylesheet" href="{!! url('css/jquery-ui.css') !!}">
    <link rel="stylesheet" href="{!! url('css/buttons.dataTables.css') !!}">
    <link rel="stylesheet" href="{!! url('css/bootstrap-datetimepicker.css') !!}">
    @yield('pagecss')
    <link rel="stylesheet" href="{!! url('css/dataTables.bootstrap.css') !!}">
	<link rel="stylesheet" href="{!! url('css/daterangepicker.css') !!}">
	<link rel="stylesheet" href="{!! url('css/plugins/kendo-ui/kendo.common.min.css') !!}">
    <link rel="stylesheet" href="{!! url('css/plugins/kendo-ui/kendo.flat.min.css') !!}">
    <link rel="stylesheet" href="{!! url('css/plugins/kendo-ui/kendo.flat.mobile.min.css') !!}">
    <link rel="stylesheet" href="{!! url('css/plugins/kendo-ui/kendo.dataviz.flat.min.css') !!}">
    <link id="themecss" rel="stylesheet" href="{!! url('css/plugins/shield-ui/all.min.css') !!}">
    <script>
        const baseURL = "{{ url('/') }}/";
    </script>
    <script src="{!! url('js/jquery1-11-3.min.js')!!}"></script>   
    <script src="{!! url('js/code-jquery-1.12.3.min.js')!!}"></script>
    <script src="{!! url('js/code-jquery-ui.1.11.4.min.js')!!}"></script>
    <script src="{!! url('js/jquery-2.2.0.js')!!}"></script>
    <script src="{!! url('js/bootstrap.min.js') !!}"></script>
    {{-- <script src="{!! url('js/jquery-3.6.0.min.js')!!}"></script> --}}
    <script type="text/javascript" src="{!! url('js/jquery-ui.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/jquery.dataTables.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/dataTables.bootstrap.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/dataTables.buttons.js') !!}"></script>
</head>
<body class="bckclass">
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
    
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyC058wNQG2iAeF7z0ysRHQw_0Gsqd6Xp5s"></script> 
    <script src="{!! url('js/moment.js') !!}"></script>
    <script src="{!! url('js/bootstrap-datetimepicker.min.js') !!}"></script>

    <script type="text/javascript" src="{!! url('js/bootstrap-datepicker.js') !!}"}></script>
    <script src="{!! url('assets/js/confirmation.js') !!}"></script>
    <script src="{!! url('assets/js/main.js') !!}"></script>

    
    <script type="text/javascript" src="{!! url('js/buttons.flash.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/buttons.html5.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/buttons.print.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/jszip.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/pdfmake.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/vfs_fonts.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/bootstrap-datepicker.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/jquery.tabletojson.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/plugins/Highcharts-4.2.6/js/highcharts.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/plugins/Highcharts-4.2.6/js/modules/exporting.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/plugins/Highcharts-4.2.6/js/modules/offline-exporting.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/plugins/Highcharts-4.2.6/js/themes/dark-unica.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/daterangepicker.js') !!}"></script>
	
	<script type="text/javascript" src="{!! url('js/plugins/shield-ui/shieldui-all.min.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/plugins/shield-ui/jszip.min.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/jquery.validate.min.js') !!}"></script>

    <script type="text/javascript" src="{!! url('js/plugins/kendo-ui/kendo.all.min.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/plugins/kendo-ui/jszip.min.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/plugins/kendo-ui/pako_deflate.min.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/plugins/morris/raphael.min.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/plugins/morris/morris.js') !!}"></script>

    <script src="{!! url('assets/js/notification.js')!!}"></script>
    <script src="{!! url('assets/js/jquery.tablesorter.js')!!}"></script>
    <script src="{!! url('assets/js/search.js')!!}"></script>
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>    
    <script src="{!! url('js/jquery.mmenu.all.min.js')!!}"></script>
    <script src="{!! url('assets/js/responsive.js')!!}"></script>
    <script src="{!! url('assets/js/confirm2.js')!!}"></script>
    <script src="{!! url('assets/js/pagelayouts.js')!!}"></script>
    <script>
        function fireToast(icon,text){
            $.toast({
                text: text, // Text that is to be shown in the toast
                icon: icon, // Type of toast icon
                showHideTransition: 'fade', // fade, slide or plain
                allowToastClose: true, // Boolean value true or false
                hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                position: 'top-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
            })
        }
    </script>
     @yield('page-js-files')

  
    
</body>
</html>
