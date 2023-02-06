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
<?php 

$floodimages = [];
$landslideimages = [];
$counter = 0;
$slcounter = 0;
$clearsimages = [];$ccounter = 0;
foreach ($floods as $flood) {
	$floodimage[$counter++] = array(
		'id' => $flood->id,
		'image' => unserialize($flood->incident_images),
	);
} 
foreach ($landslides as $landslide) {
	$landslideimages[$slcounter++] = array(
		'id' => $landslide->id,
		'image' => unserialize($landslide->incident_images),
	);
} 
foreach ($clears as $clear) {
	$clearsimages[$ccounter++] = array(
		'id' => $clear->id,
		// 'image' => unserialize($clear->image),
	);
} 
?>
@include('pages.loginmodal')
@stop
@section('page-js-files')
<script>
    var landslides = {!! json_encode($landslides->toArray()) !!};
    var floods = {!! json_encode($floods->toArray()) !!};
    var floodimage = {!! json_encode($floodimage) !!};
	var clears = {!! json_encode($clears->toArray()) !!};
    var clearsimages = {!! json_encode($clearsimages) !!};
    var landslideimages = {!! json_encode($landslideimages) !!};
</script>

<script src="{!! url('assets/js/map.js')!!}"></script>
<script src="{!! url('assets/js/home.js') !!}"></script>



@if ($errors->all && count($errors->all()) > 0)
<script>$('#modalLoginForm').modal();</script>
@endif
  

@stop