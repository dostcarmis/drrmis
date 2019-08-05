@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Landslide Threshold</h1>
	</div>
	<form action="{{ action("ThresholdController@destroymultipleThreshold") }}">
	<div class="col-xs-12">
		<p style="color:red"><?php echo Session::get('message'); ?></p>
		<div class="col-xs-12 ulpaginations np">
			<div class="col-xs-8 np">
				<a id="btnadd-location" title="Add Threshold" class="btnadd-location btn" href="{{ action("ThresholdController@viewaddThreshold") }}"><span class="glyphicon glyphicon-plus"></span> Add Threshold</a>

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
				<th>Sensor Type</th>
				<th>Landslide (mm)</th>
				<th>Date</th>
			</thead>
			<tbody>					
				@foreach($threshold as $thval)
				<tr>
					<td><input class="chbox" name="chks[]" value="{{$thval->id}}" type="checkbox"></td>					
					<td>
					<a class="desctitle" href="<?php echo url('editthreshold'); ?>/<?php echo $thval->id?>">
						@foreach($sensors as $sensor)
							@if($thval->address_id === $sensor->id)
							{{ $sensor->address }}				
							@endif
						@endforeach
					</a>
					<span class="defsp spactions">
						<div class="inneractions">
							<a href="<?php echo url('editthreshold'); ?>/<?php echo $thval->id; ?>">Edit</a> | 
							<a class="deletepost" href="#" id="{{$thval->id}}" value="{{$thval->id}}" title="Delete">Delete</a>
						</div>								
					</span>
					
					</td>
					<td>
						@foreach($sensors as $sensor)
							@if($thval->address_id === $sensor->id)
								@foreach($categories as $category)
									@if($category->id === $sensor->category_id)
										{{$category->name}}
									@endif
								@endforeach			
							@endif
						@endforeach
					</td>
					<td>{{ $thval->threshold_landslide}}</td>
					<td><?php echo date("F j Y g:i A", strtotime($thval->threshold_date));?></td>	
				</tr>
				@endforeach		

				@include('pages.deletethreshold')
			</tbody>
		</table>
	</div>
	</form>
</div>

 @stop