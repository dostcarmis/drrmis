@extends('layouts.masters.incidents-mapview-layouts')
@section('left-section')
<aside id="menuincidents">
    @include('layouts.partials.mapviewleftnav')
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
?>
@endsection

@section('page-js-files')
<script>


    var landslides = {!! json_encode($landslides->toArray()) !!};
    var floods = {!! json_encode($floods->toArray()) !!};
    var floodimage = {!! json_encode($floodimage) !!};
    var landslideimages = {!! json_encode($landslideimages) !!};

</script>
<script src="{!! url('assets/js/mapview.js') !!}"></script>

@stop