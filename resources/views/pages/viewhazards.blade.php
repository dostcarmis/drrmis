@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Hazards</h1>
	</div>
	<form action="{{action('HazardsController@destroymultipleHazards')}}">
		<div class="col-xs-12">
			<p style="color:green"><?php echo Session::get('message'); ?></p>
			<div class="col-xs-12 ulpaginations np">
				<div class="col-xs-12 col-sm-8 np">
					<a id="btnadd-location" title="Add Hazards" class="btnadd-location btn" href="{{action('HazardsController@viewaddHazard')}}"><span class="glyphicon glyphicon-plus"></span> Add Hazard</a>

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
			<table class="table table-hover table-striped tblcontents tbl-hazards"  id="dashboardtables">
				<thead>
					<th class="no-sort"><input type="checkbox" class="headcheckbox"></th>
					<th class="desc">Name</th>
					<th>Description</th>	
				</thead>
				<tbody>
				@foreach($hazards as $hazard)
					<tr>						
						<td>

						<input class="chbox" name="chks[]" value="{{$hazard->id}}"  type="checkbox"></td>

					<td>
							<a class="desctitle" href="<?php echo url('edithazard'); ?>/<?php echo $hazard->id?>">{{ $hazard->name }}</a>	
							<span class="defsp spactions">
								<div class="inneractions">
	
									<a href="<?php echo url('edithazard'); ?>/<?php echo $hazard->id; ?>">Edit</a> | 
									<a class="deletepost" href="#" id="{{$hazard->id}}" value="{{$hazard->id}}" title="Delete">Delete</a> | 

								</div>								
							</span>
						</td>											
						<td>{{$hazard->description }}</td>

						
					</tr>
					@endforeach
				@include('pages.deletedialoghazard')
				</tbody>
			</table>
		</div>
	</form>
</div>
 @stop
