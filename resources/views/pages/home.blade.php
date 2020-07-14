@extends('layouts.masters.homepage-layout')
@section('left-section')
<aside id="leftmenu">
    @include('layouts.partials.homeleftnav')
</aside>
@endsection
@section('legend-section')
<aside id="homepagelegend" style="display: none;">
	@include('layouts.partials.homerightnav')
</aside>
@endsection
@section('page-content')
<div class="container-fluid">
    <div class="row">  
    	<div id="content-window" style="position: absolute;z-index: 0;"></div>  	
        <div id="map"></div>      
    </div>    
</div>

@include('pages.loginmodal')
@stop
@section('page-js-files')

<script src="{!! url('assets/js/map.js')!!}"></script>
<script src="{!! url('assets/js/home.js') !!}"></script>

@if ($errors->all && count($errors->all()) > 0)
<script>$('#modalLoginForm').modal();</script>
@endif
  

@stop