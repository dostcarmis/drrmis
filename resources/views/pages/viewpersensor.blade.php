@extends('layouts.masters.other-layouts')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header viewpersensorTitle">{{ $sensor->address }}</h1>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 rowDetails">
		<p class="pDetails"><i class="far fa-map"></i> 
		@foreach($provinces as $province)
			@if($province->id == $sensor->province_id)
				<span class="province">Province: {{$province->name}}</span><br/>
			@endif
		@endforeach
		@foreach($municipalities as $municipality)
			@if($municipality->id == $sensor->municipality_id)
				<span class="municipality">Municipality: {{$municipality->name}}</span>
			@endif
		@endforeach
		</p>
		<p class="pDetails lat"><i class="fas fa-map-marker-alt"></i><span class="latitude">Latitude: {{$sensor->latitude}}</span><br/><span class="longitude">Longitude: {{$sensor->longitude}}</span></p>
	</div>
</div>


<div id="persensorchart"></div>
<div class="row">
	<div class="col-xs-12 np">
		<a href="{{action('HydrometController@viewHydrometdata')}}" class="btnback btn" title="Back to Sensors"><i class="fas fa-level-up-alt"></i> View Sensors</a>
		
	</div>
</div>
@stop
@section('page-js')
<script src="{!! url('assets/js/sensorschart.js')!!}"></script>
@stop