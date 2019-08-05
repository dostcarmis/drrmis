@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Edit Susceptibility Value</h1>
	</div>
</div>
<form id="editform" action="{{ action('SusceptibilityController@updateSusceptibility') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">	
	<input type="hidden" name="id" value="<?= $susceptibility->id ?>">	
	<div class="col-xs-12 col-sm-6 perinputwrap">
		{!! Form::label('address','Select Address:') !!}
		<select name="address_id" class="form-control">
			@foreach($sensors as $sensor)
				@if($susceptibility->address_id === $sensor->id)
				<option selected="selected" value="{{ $sensor->id }}">{{ $sensor->address }}</option>
				@else
				<option value="{{ $sensor->id }}">{{ $sensor->address }}</option>
				@endif
			@endforeach
		</select>
	</div>
	<div class="col-xs-12 col-sm-3 perinputwrap">
		{!! Form::label('address','Landslide Level:') !!}
		<select name="landslide" class="form-control">

			@for ($i = 0; $i < 6; $i++)
			    @if($i === $susceptibility->susceptibility_landslide)
			    	<option selected="selected" value="{{ $i }}">{{ $i }}</option>
			    @else
			    <option value="{{ $i }}">{{ $i }}</option>
			    @endif
			@endfor

		</select>
	</div>
	<div class="col-xs-12 col-sm-3 perinputwrap">
		{!! Form::label('address','Flood Level:') !!}
		<select name="flood" class="form-control">
			@for($x= 0; $x < 6 ;$x++)				
				@if($x === $susceptibility->susceptibility_flood)
				<option selected="selected" value="{{ $x }}">{{ $x }}</option>
				@else
				<option value="{{ $x }}">{{ $x }}</option>
				@endif
			@endfor
		</select>
	</div>
	<div class="col-xs-12 perinputwrap text-right">
	<a class ="btn btn-update" title="Update" data-toggle="modal" data-target="#mymodal">Update</a>
	<a class="btn btn-cancel" href="{{ action("SusceptibilityController@viewSusceptibility") }}">Cancel</a> 
	@include('pages.updatesusceptibility')
	</div>


</form>

 @stop