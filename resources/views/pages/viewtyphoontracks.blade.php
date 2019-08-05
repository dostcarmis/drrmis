@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Typhoon Tracks</h1>
		<form action="{{ action("TyphoontrackController@status") }}">

			<label style="font-size: 24px;vertical-align: top;">Activate Typhoon Track: </label>
			<label class="switch-typhoon">
			@if($typhoonstatus->typhoonstat == 1)
			<input name="typhoonstatus" value="checked" class="typhoonswitch" type="checkbox" checked onchange='this.form.submit()'>
			@else
			<input name="typhoonstatus" value="checked" class="typhoonswitch" type="checkbox" onchange='this.form.submit()'>
			@endif
	
					
		
					
				
		
			  
			  <span class="slider round typhoon"></span>
			</label>
			
		</form>
	</div>
	<form action="{{ action("TyphoontrackController@destroymultipleTyphoons") }}">
	<div class="col-xs-12">
		<p style="color:red"><?php echo Session::get('message'); ?></p>
		<div class="col-xs-12 ulpaginations np">
			<div class="col-xs-8 np">
				<a id="btnadd-location" title="Add Typhoon Track" class="btnadd-location btn" href="{{ action('TyphoontrackController@viewaddTyphoonTracks') }}"><span class="glyphicon glyphicon-plus"></span> Add Typhoon Track</a>

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
				<th class="desc">Typhoon Name</th>
				<th class="desc">Status</th>
				<th class="no-sort">File</th>
			</thead>
			<tbody>					
				@foreach($typhoontracks as $typhoontrack)
				<tr>
					<td><input class="chbox" name="chks[]" value="{{$typhoontrack->id}}" type="checkbox"></td>	
					<td>
						<a class="desctitle" href="#">
							{{$typhoontrack->typhoonName }}
						</a>
						<span class="defsp spactions">
							<div class="inneractions">
								<a href="<?php echo url('edittyphoontrack');?>/<?php echo $typhoontrack->id; ?>">Edit</a> | 
								<a class="deletepost" href="#" id="{{$typhoontrack->id}}" value="{{$typhoontrack->id}}" title="Delete">Delete</a>
							</div>								
						</span>					
					</td>		
					<td>
					@if($typhoontrack->typhoonstat == 1)
						<span style="color:green">Active</span>
					@else
						<span style="color:red">Inactive</span>
					@endif
	
									
					</td>
					<td>
						{{$typhoontrack->typhoonpath }}
					</td>

				</tr>
				@endforeach		

				<!--include('pages.deletefloodpronearea')-->
			</tbody>
		</table>
	</div>
	</form>
</div>

 @stop