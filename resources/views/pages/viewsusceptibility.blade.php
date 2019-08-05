@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Susceptibility</h1>
	</div>
	<form action="{{ action("SusceptibilityController@destroymultipleSusceptibility") }}">
	<div class="col-xs-12">
		<p style="color:red"><?php echo Session::get('message'); ?></p>
		<div class="col-xs-12 ulpaginations np">
			<div class="col-xs-8 np">
				<a id="btnadd-location" title="Add Susceptibility" class="btnadd-location btn" href="{{ action("SusceptibilityController@viewaddSusceptibility") }}"><span class="glyphicon glyphicon-plus"></span> Add Susceptibility</a>
				<button disabled="disabled" type="submit" class="btn btn-deleteselected" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>			
			</div>
			<div class="col-xs-12 col-sm-4">
				<div class="col-xs-12 np text-right">
					<div class="input-group">				  
						  <input class="form-control" id="searchall" type="text" name="searchall" placeholder="Search">
						  <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
						</div>
		   				    
		    	</div>
			</div>
		</div>
		<table class="table table-hover tblcoordinates tbl-susceptibility"  id="dashboardtables">
			<thead>
				<th class="no-sort"><input type="checkbox" class="headcheckbox"></th>
				<th>Address</th>
				<th>Landslide Susceptibility Level</th>
				<th>Flood Susceptibility Level</th>
			</thead>
			<tbody>					
				@foreach($susceptibility as $scval)
				<tr>
					<td><input class="chbox" name="chks[]" value="{{$scval->id}}" type="checkbox"></td>					
					<td>
					<a class="desctitle" href="<?php echo url('editsusceptibility'); ?>/<?php echo $scval->id?>">
						@foreach($sensors as $sensor)
							@if($scval->address_id === $sensor->id)
								{{ $sensor->address }}				
							@endif
						@endforeach
					</a>
					<span class="defsp spactions">
						<div class="inneractions">
							<a href="<?php echo url('editsusceptibility'); ?>/<?php echo $scval->id; ?>">Edit</a> | 
							<a class="deletepost" href="#" id="{{$scval->id}}" value="{{$scval->id}}" title="Delete">Delete</a>
						</div>								
					</span>
					</td>
					<td>{{ $scval->susceptibility_landslide}}</td>
					<td>{{ $scval->susceptibility_flood }}</td>
				</tr>

				@endforeach		
				@include('pages.deletesusceptibility')
			</tbody>
		</table>
	</div>
</form>
</div>

 @stop