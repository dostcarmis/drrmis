@extends('layouts.masters.incidents-mapview-layouts')
@section('left-section')
<aside id="menuincidents">
    
</aside>
@endsection

@section('page-content')

<div class="container-fluid">
    <div class="row">    	
        <div id="incidentmap"></div>     
    </div>    
</div>
<?php 

$floodimages = [];
$landslideimages = [];
$clearsimages = [];$ccounter = 0;
$counter = 0;
$slcounter = 0;


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
		'image' => unserialize($clear->image),
	);
} 
?>


@endsection

@section('page-js-files')
<script>
    var landslides = {!! json_encode($landslides->toArray()) !!};
    var floods = {!! json_encode($floods->toArray()) !!};
	var clears = {!! json_encode($clears->toArray()) !!};
    var clearsimage = {!! json_encode($clearsimages) !!};
    var floodimage = {!! json_encode($floodimage) !!};
    var landslideimages = {!! json_encode($landslideimages) !!};
	
</script>
<script src="{!! url('assets/js/mapview.js') !!}"></script>

@endsection