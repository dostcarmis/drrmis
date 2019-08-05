@extends('layouts.masters.backend-layout')
@section('page-content')
<?php
	$ftype = '';
	if((isset($_GET['ftype']))){
		$ftype = $_GET['ftype'];
	} 
?>


<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Incidents</h1>
	</div>
	<form action="{{action('IncidentsController@destroymultipleIncidents')}}" style="float: left;">
		<div class="col-xs-12">
			<p style="color:green"><?php echo Session::get('message'); ?></p>
			<div class="col-xs-12 ulpaginations np">
				<div class="col-xs-12 col-sm-8 np">
					<a id="btnadd-location" title="Add Incident" class="btnadd-location btn" href="{{action('IncidentsController@viewaddIncident')}}"><span class="glyphicon glyphicon-plus"></span> Add Incident Report</a>
					<button disabled="disabled" type="submit" class="btn btn-deleteselected" title="Delete" value="Multidelete" name="in_delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>	
					<div class="incidentFilter">
						<select class="form-control optFilterIncident" id="optFilterIncident" name="Filter">
							@if($ftype == 'Landslides')
							<option value="">Select Incident</option>
							<option value="Floods">Floods</option>
							<option selected="selected" value="Landslides">Landslides</option>
							@elseif($ftype == 'Floods')
							<option value="">Select Incident</option>
							<option selected="selected" value="Floods">Floods</option>
							<option value="Landslides">Landslides</option>
							@else
							<option value="">Select Incident</option>
							<option value="Floods">Floods</option>
							<option value="Landslides">Landslides</option>
							@endif
							
						</select>
					</div>
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
				<table class="table table-hover table-striped tblcontents tbl-incidents"  id="incidenttable">
				<thead>
					<th class="no-sort"><input type="checkbox" class="headcheckbox"></th>
					<th class="desc">Location</th>	
					<th>Type</th>
					<th>Province</th>	
					<th>Latitude</th>
					<th>Longitude</th>
					<th>Source</th>
					<th>Date</th>	
				</thead>
				<tbody>
					
					@include('pages.deletedialogincident')
				</tbody>
			</table>
		</div>
	</form>
</div>
 @stop
