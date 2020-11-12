@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Landslides</h1>
	</div>

	<form action="{{ action('LandslideController@destroymultipleLandslides') }}">
		<div class="col-xs-12">
			<p style="color:green"><?php echo Session::get('message'); ?></p>
			<div class="col-xs-12 ulpaginations np">
				<div class="col-xs-12 col-sm-8 np">
					<a id="btnadd-location" title="Add Landslide" class="btnadd-location btn" href="{{ action('LandslideController@viewaddLandslide') }}">
						<span class="glyphicon glyphicon-plus"></span> Add Landslide Report</a>
					<button disabled="disabled" type="submit" class="btn btn-deleteselected" title="Delete">
						<i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
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

			<table class="table table-hover table-striped tblcontents tbl-landslides"  id="dashboardtables">

				<thead>
					<th class="no-sort"><input type="checkbox" class="headcheckbox"></th>
					<th class="desc">Location</th>	
					<th>Municipality</th>
					<th>Province</th>	
					<th>Typhoon Name</th>
					<th>Latitude</th>
					<th>Longitude</th>
					<th>Source</th>
					<th>Date</th>
				</thead>
				<tbody>
				@foreach($landslides as $landslide)
					<tr>						
						<td>

						@if(($currentUser->id == $landslide->created_by) || ($currentUser->role_id <= 3))
						<input class="chbox" name="chks[]" value="{{$landslide->id}}"  type="checkbox">
						@else
						<input  type="checkbox" disabled>
						@endif

						</td>

						<td>

						@if(($currentUser->id == $landslide->created_by) || ($currentUser->role_id <= 3))
						<a class="desctitle" href="<?php echo url('viewperlandslide'); ?>/<?php echo $landslide->id?>">
							{{ $landslide->road_location }} {{$landslide['municipal'] ? json_decode($landslide['municipal'])->name : ''}}, 
							{{$landslide['province'] ? json_decode($landslide['province'])->name : ''}}</a>
						@else
						<a class="desctitle" href="<?php echo url('viewperlandslide'); ?>/<?php echo $landslide->id?>">
							{{ $landslide->road_location }} {{$landslide['municipal'] ? json_decode($landslide['municipal'])->name : ''}}, 
							{{$landslide['province'] ? json_decode($landslide['province'])->name : ''}}</a>
						@endif						

						@if($landslide->report_status != "Published")
						<span class="repstat">— {{$landslide->report_status}}</span>
						@endif

						<span class="defsp spactions">
							<div class="inneractions">
								@if(($currentUser->id == $landslide->created_by) || ($currentUser->role_id <= 3))
								<a href="<?php echo url('editlandslide'); ?>/<?php echo $landslide->id; ?>">Edit</a> | 
								<a class="deletepost" href="#" id="{{$landslide->id}}" value="{{$landslide->id}}" title="Delete">Delete</a> |
								@endif
								<a href="<?php echo url('viewperlandslide'); ?>/<?php echo $landslide->id?>">Preview</a> 
							</div>								
						</span>
						</td>
						<td>{{$landslide['municipal'] ? json_decode($landslide['municipal'])->name : ''}}</td>
					    <td>{{$landslide['province'] ? json_decode($landslide['province'])->name : ''}}</td>						
						<td>{{$landslide->typhooname }}</td>
						<td>{{$landslide->latitude}}</td>
						<td>{{$landslide->longitude}}</td>						
						<td>{{$landslide->author}}</td>
						<td>
						<?php echo date("F j, Y g:i A", strtotime($landslide->date));?>
						</td>					</tr>
					@endforeach
					@include('pages.deletedialoglandslide')
				</tbody>
			</table>
		</div>
	</form>
</div>

 @stop

