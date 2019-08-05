@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Flood-prone Areas</h1>
	</div>
	<form action="{{ action("FloodproneareasController@destroymultipleFloodproneAreas") }}">
	<div class="col-xs-12">
		<p style="color:red"><?php echo Session::get('message'); ?></p>
		<div class="col-xs-12 ulpaginations np">
			<div class="col-xs-8 np">
				<a id="btnadd-location" title="Add Flood-prone Area" class="btnadd-location btn" href="{{ action("FloodproneareasController@viewaddFloodproneArea") }}"><span class="glyphicon glyphicon-plus"></span> Add Flood-prone Area</a>

<button disabled="disabled" type="submit" class="btn btn-deleteselected" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>			
			</div>
			<div class="col-xs-4 text-right np">
				<div class="col-xs-12 col-sm-10 col-sm-offset-2 text-right">
					<div class="input-group">				  
					  <input type="text" class="form-control" placeholder="Search" id="searchall" name="searchall" >
					  <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
					</div>
			    </div>
			</div>
		</div>
		
		<table class="table table-hover tblthreshold"  id="dashboardtables">
			<thead>
				<th class="no-sort"><input type="checkbox" class="headcheckbox"></th>
				<th class="desc">Address</th>
				<th>Municipality</th>
				<th>Province</th>				
			</thead>
			<tbody>					
				@foreach($floodproneareas as $floodpronearea)
				<tr>
					<td><input class="chbox" name="chks[]" value="{{$floodpronearea->id}}" type="checkbox"></td>					
					<td>
						<a class="desctitle" href="#">
							{{$floodpronearea->address }}
						</a>
						<span class="defsp spactions">
							<div class="inneractions">
								<a href="<?php echo url('editfloodpronearea');?>/<?php echo $floodpronearea->id; ?>">Edit</a> | 
								<a class="deletepost" href="#" id="{{$floodpronearea->id}}" value="{{$floodpronearea->id}}" title="Delete">Delete</a>
							</div>								
						</span>					
					</td>
					<td>
						@foreach($municipalities as $municipality)
							@if($municipality->id == $floodpronearea->municipality_id)
								{{$municipality->name}}
							@endif
						@endforeach
					</td>
					<td>
						@foreach($provinces as $province)
							@if($province->id == $floodpronearea->province_id)
								{{$province->name}}
							@endif
						@endforeach
					</td>
				</tr>
				@endforeach		

				@include('pages.deletefloodpronearea')
			</tbody>
		</table>
	</div>
	</form>
</div>

 @stop