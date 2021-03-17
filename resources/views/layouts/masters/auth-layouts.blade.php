<!DOCTYPE html>
<html class="wrapdef" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Monitoring & Early Warning Systems for Landslides & Other Hazards</title>  
    <link rel="icon" href="{{ URL::asset('assets/images/favicon.png') }}" type="image/x-icon" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{--<link  href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link  href="{{ URL::asset('css/sb-admin.css') }}" rel="stylesheet">  
    <link  href="{{ URL::asset('css/plugins/morris.css') }}" rel="stylesheet">  
    <link href="{{ URL::asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('assets/fonts/allfonts/stylesheet.css') }}">
    <link href="{{ URL::asset('assets/css/skin.css') }}" rel="stylesheet">
     <link href="{{ URL::asset('assets/css/responsive.css') }}" rel="stylesheet">
     
</head>
<body>
    <aside  id="login">
        <div class="container">
            @yield('page-content')
        </div>
    </aside>
    <script>
        const baseURL = "{{ url('/') }}/";
    </script>
    <script src="{!! url('js/jquery1-11-3.min.js')!!}"></script> 
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script>
        const baseurl = {{ url('/') }};
    </script>
    <script src="{{ asset('assets/js/register.js') }}"></script>

    @yield('page-js-files')
    
</body>
</html>