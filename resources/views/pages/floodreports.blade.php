@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Generate Flood List</h1>
	</div>
		<div class="col-xs-12">
			<p style="color:red"><?php echo Session::get('message'); ?></p>
			<div class="col-xs-12 sorting-reports col-xs-12 well per-inputhydrometfilter">
				<div class="col-xs-12">
					<form action="{{ action('FloodController@filterFloodReport') }}" method="post">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="col-xs-12 col-sm-2 np">
							<label class="lblreportgen">Province: </label>
							<select class="form-control inputreportgen" name="inputreportgen">
							<option value="0">All Provinces</option>	
								@foreach($provinces as $province)
									<option value="{{$province->id}}">{{$province->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-xs-12 col-sm-3">
							<label class="lblreportgen text-right">Date: </label>
							@if($datadate != '')
								<input type="text" id="daterangeinput" class="form-control inputreportgen" name="daterangeinput" value="{{$datadate}}" />
							@else
								<input type="text" id="daterangeinput" class="form-control inputreportgen" name="daterangeinput" value="" />
							@endif
											
						</div>
						<div class="col-xs-12 col-sm-1">
							<input type="submit" class="btn btn-submit btn-filter" value="Filter" id="filter_table" name="filter_table">
						</div>
					</form>
					
				</div>
			</div>
			<table class="table table-hover table-striped tblcontents tbl-reportgen"  id="floodreportable">
				<thead>
					<th>Location</th>
					<th>Province</th>
					<th>Rainfall Value</th>
					<th>Created by</th>
					<th>Date</th>
				</thead>
				<tbody>
					@foreach($floods as $flood)
						<tr>
							<td>
								{{$flood->location}}
							</td>
							<td>
								@foreach($provinces as $province)
									@if($province->id == $flood->province_id)
										{{$province->name}}
									@endif
								@endforeach
							</td>
							
							<td>
								{{$flood->pastrainvalue}} mm
							</td>
							<td>
								@foreach($users as $user)
									@if($user->id == $flood->user_id)
										{{$user->last_name}}, {{$user->first_name}}
									@endif
								@endforeach

							</td>
							<td>
								<?php echo date("F j Y g:i A", strtotime($flood->date));?>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
</div>
 @stop
