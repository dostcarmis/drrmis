@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Road Status Report</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach

<form id="userform" action="{{ action('RoadController@saveRoadnetwork') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="col-xs-12 col-sm-6 perinputwrap dates">
		<label>Date & Time</label>
		<div class='input-group date' id="date">
            <input type='text' name="date" placeholder="Date & Time" class="form-control" />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
        @if ($errors->has('date')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Road Status:</label>
		<select name="status" id="status" class="form-control">
			<option value="One Way">Open</option>
			<option value="Closed">Closed</option>
			<option value="One Way">One Way</option>
			<option value="Open & Closed Situation">Open & Closed Situation</option>			
		</select>
	</div>	
	<div class="col-xs-12 perinputwrap">
		<label>Location:</label>
		<input type="text" name="address" id="address" class="form-control" placeholder="Enter location">
		@if ($errors->has('address')) <span class="reqsymbol">*</span> @endif
	</div>

	<div class="col-xs-12 perinputwrap">
		<label>Source:</label>
		<input type="text" name="author" id="author" class="form-control" placeholder="Enter Source / Office">
		@if ($errors->has('author')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 perinputwrap">
		<label>Description:</label>
		<textarea class="piw-textarea form-control" name="description" placeholder="Enter description" id="description"></textarea>
	</div>
	
	<div class="col-xs-12 perinputwrap text-right">
	<input class ="btn btn-updatelocation"  type ="submit" value="Save">
	<a class="btn btn-cancel" href="{{ action("RoadController@viewRoadnetworks") }}">Cancel</a> 
	</div>

</form>
 @stop