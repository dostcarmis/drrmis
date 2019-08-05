@extends('layouts.masters.backend-layout')
@section('page-content')
@if(($currentUser->id == $roadnetworks->user_id) || ($currentUser->role_id <= 3))
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Edit Road Report</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach


<form id="userform" action="{{ action('RoadController@updateRoadnetwork') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="id" value="<?= $roadnetworks->id ?>">	
	@if($currentUser->role_id != 5)
		<div class="col-xs-12 perinputwrap">
			<div class="col-xs-6 npl">
				<label>Report Status:</label>
					<select name="report_status" id="report_status" class="form-control">
						@if($roadnetworks->report_status === 'Published')
						<option value="Pending">Pending</option>
						<option selected="selected" value="Published">Published</option>
						@else
						<option selected="selected" value="Pending">Pending</option>
						<option  value="Published">Published</option>
						@endif
					</select>
			</div>
		</div>	
	@endif
	<div class="col-xs-12 col-sm-6 perinputwrap dates">
		<label>Date & Time</label>
		<div class='input-group date' id="date">
            <input type='text' name="date" value="<?= $roadnetworks->date ?>" placeholder="Date & Time" class="form-control" />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
        @if ($errors->has('date')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Road Status:</label>
		<select name="status" id="status" class="form-control">
		@if($roadnetworks->status === 'Open')
			<option selected="selected" value="Open">Open</option>
			<option value="Closed">Closed</option>
			<option value="One Way">One Way</option>
			<option value="Open and Closed Situation">Open and Closed Situation</option>	
		@elseif($roadnetworks->status === 'Closed')
			<option value="Open">Open</option>
			<option selected="selected"  value="Closed">Closed</option>
			<option value="One Way">One Way</option>
			<option value="Open and Closed Situation">Open and Closed Situation</option>
		@elseif($roadnetworks->status === 'One Way')
			<option value="Open">Open</option>
			<option  value="Closed">Closed</option>
			<option  selected="selected"  value="One Way">One Way</option>
			<option value="Open and Closed Situation">Open and Closed Situation</option>
		@else
			<option value="Open">Open</option>
			<option value="Closed">Closed</option>
			<option value="One Way">One Way</option>
			<option selected="selected"  value="Open and Closed Situation">Open and Closed Situation</option>	
		@endif			
		</select>
	</div>
	
	<div class="col-xs-12 perinputwrap">
		<label>Address:</label>
		<input type="text" name="address" value="<?= $roadnetworks->location ?>" id="address" class="form-control" placeholder="Enter Address">
		@if ($errors->has('address')) <span class="reqsymbol">*</span> @endif
	</div>		

	<div class="col-xs-12 perinputwrap">
		<label>Author:</label>
		<input type="text" name="author" value="<?= $roadnetworks->author ?>" id="author" class="form-control" placeholder="Enter Source ">
		@if ($errors->has('author')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 perinputwrap">
		<label>Description:</label>
		<textarea class="form-control" name="description" placeholder="Enter description" id="description"><?= $roadnetworks->description ?></textarea>
	</div>
	
	<div class="col-xs-12 perinputwrap text-right">
	<a class ="btn btn-update" title="Update" data-toggle="modal" data-target="#mymodal">Update</a>
	<a class="btn btn-cancel" href="{{ action("RoadController@viewRoadnetworks") }}">Cancel</a> 
	@include('pages.editdialogroadnetwork')
	</div>
	
</form>
@else
<h2>Insufficient Permission!!!</h2>
<span class="defsp"><img src="<?php echo url('assets/images/goodjob.gif');?>"></span>
@endif
 @stop