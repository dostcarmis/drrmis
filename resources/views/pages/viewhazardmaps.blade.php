@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Hazard Maps</h1>
	</div>
	<form action="{{action('HazardmapsController@destroymultipleHazardmaps')}}">
		<div class="col-xs-12">
			<p style="color:red"><?php echo Session::get('message'); ?></p>
			<div class="col-xs-12 ulpaginations np">
				<div class="col-xs-12 col-sm-8 np">
					<a id="btnadd-location" title="Add Hazardmap" class="btnadd-location btn" href="{{action('HazardmapsController@addHazardmap')}}"><span class="glyphicon glyphicon-plus"></span> Add Hazard Map</a>

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
			<table class="table table-hover tblcontents table-striped tbl-hazards"  id="dashboardtables">
				<thead>
					<th class="no-sort"><input type="checkbox" class="headcheckbox"></th>
					<th class="desc">Hazard Map</th>	
					<th>Status</th>
					<th>Province</th>	
					<th>Municipality</th>					
					<th>Category</th>
					<th>Type</th>
				</thead>
				<tbody>
				@foreach($hazardmaps as $hazardmap)
					<tr>						
						<td><input class="chbox" name="chks[]" value="{{$hazardmap->id}}"  type="checkbox"></td>
						<td>
							<a class="desctitle" href="<?php echo url('edithazardmap'); ?>/<?php echo $hazardmap->id?>">{{ $hazardmap->name }}</a>
							<span class="defsp spactions">
								<div class="inneractions">
									<a href="<?php echo url('edithazardmap'); ?>/<?php echo $hazardmap->id; ?>">Edit</a> | 
									<a class="deletepost" href="#" id="{{$hazardmap->id}}" value="{{$hazardmap->id}}" title="Delete">Delete</a>
								</div>								
							</span>
						</td>
						
						<td>
							@if($hazardmap->status == 1)
								Active
							@else
								Inactive
							@endif
						</td>
						<td>
						@foreach($provinces as $province)
						@if($province->id == $hazardmap->province_id)
							{{ $province->name }}
						@endif
						@endforeach						

						</td>
						<td>
						@foreach($municipalities as $municipality)
						@if($municipality->id == $hazardmap->municipality_id)
							{{ $municipality->name }}
						@endif
						@endforeach						
						</td>
						<td>
						@if($hazardmap->category_id == 1)
							MBG
						@elseif($hazardmap->category_id == 2)
							NOAH
						@elseif($hazardmap->category_id == 3)
							Phivolcs
						@else
							DREAM / LiPAD
						@endif
						</td>
						<td>
						@if($hazardmap->overlaytype == "kmlfile")
							KML FILE
						@else
							IMAGE
						@endif
							
						</td>	
				
					</tr>
					@endforeach
					@include('pages.deletedialoghazardmap')
				</tbody>
			</table>
		</div>
	</form>
</div>
 @stop
