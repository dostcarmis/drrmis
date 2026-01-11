@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Landslides (GEE)</h1>
	</div>

	{{-- <form action="{{ action('LandslideController@destroymultipleLandslides') }}"> --}}
    <form action="#">
		<div class="col-xs-12">
			<p style="color:green"><?php echo Session::get('message'); ?></p>
			<div class="col-xs-12 ulpaginations np">
				{{-- <div class="col-xs-12 col-sm-8 np">
					<button disabled="disabled" type="submit" class="btn btn-deleteselected" title="Delete">
						<i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                    </button>
				</div> --}}

				<div class="col-xs-12 col-sm-4">
				<div class="col-xs-12 np text-right">
					<div class="input-group">				  
						  <input class="form-control" id="searchall" type="text" name="searchall" placeholder="Search">
						  <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
						</div>
		    	</div>
			</div>
			</div>

			<table class="table table-hover table-striped tblcontents tbl-landslides" id="dashboardtables">
				<thead>
					<tr>
						<th class="no-sort"><input type="checkbox" class="headcheckbox"></th>
						<th class="desc">Location</th>  
						<th>Coordinates</th>
						<th>Candidate ID</th>
						<th>Validator</th>
						<th>Date</th>
						<th>Area</th>
						<th>Validation Status</th>
					</tr>
				</thead>
				<tbody>
					@foreach($landslides as $landslide)
						@php 
							// Determine permission once per row to keep the logic clean
							$canEdit = (Auth::user()->id == $landslide->created_by) || (Auth::user()->role_id <= 3);
						@endphp

						<tr>                        
							<td>
								@if($canEdit)
									<input class="chbox" name="chks[]" value="{{$landslide->id}}" type="checkbox">
								@else
									<input type="checkbox" disabled>
								@endif
							</td>
							<td>
								<a class="desctitle" href="{{ route('landslide-inventories.show', $landslide->id) }}">
									{{ $landslide->location }}
								</a>

								<span class="defsp spactions">
									<div class="inneractions">
										@if($canEdit)
											<a href="{{ route('landslide-inventories.edit', $landslide->id) }}">Edit</a> | 
										@endif
										<a href="{{ route('landslide-inventories.show', $landslide->id) }}">Preview</a> 
									</div>                              
								</span>
							</td>
							{{-- Dynamic Coordinates (Assumes lat/long columns exist) --}}
							<td>{{ $landslide->latitude }}, {{ $landslide->longitude }}</td>
							<td>{{ $landslide->candidate_id ?? 'N/A' }}</td>        
							<td>{{ $landslide->validator->full_name ?? 'N/A' }}</td>
							<td>
								{{ date("F j, Y", strtotime($landslide->date)) }}
							</td>
							<td>{{ $landslide->area_m2 }}</td>
							<td>
								@if ($landslide->landslideInventoryValidation)
									@php 
										$statusClass = [
											1 => 'text-success', 
											2 => 'text-danger'
										][$landslide->landslideInventoryValidation->id] ?? 'text-warning';
									@endphp
									<span class="repstat {{ $statusClass }}">
										{{ $landslide->landslideInventoryValidation->name }}
									</span>
								@else
									<span class="text-warning">Not yet validated</span>
								@endif
							</td>
						</tr>
					@endforeach
					@include('pages.deletedialoglandslide')
				</tbody>
			</table>
		</div>
	</form>
</div>

@stop