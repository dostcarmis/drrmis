@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Municipalities</h1>
	</div>
	<form action="{{ action("MunicipalityController@destroymultipleMunicipality") }}">
	<div class="col-xs-12">
		<p style="color:red"><?php echo Session::get('message'); ?></p>
		<div class="col-xs-12 ulpaginations np">
			<div class="col-xs-8 np">
				<a id="btnadd-location" title="Add Municipality" class="btnadd-location btn" href="{{ action("MunicipalityController@viewaddMunicipality") }}"><span class="glyphicon glyphicon-plus"></span> Add Municipality</a>
				<button disabled="disabled" type="submit" class="btn btn-deleteselected" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
			
			</div>
			<div class="col-xs-4 text-right np">{{ $municipality->links() }}</div>
		</div>
		<table class="table table-hover tblcoordinates" id="dashboardtables">
			<thead>
				<th><input type="checkbox" class="headcheckbox"></th>
				<th>Municipality</th>
				<th>Provinces</th>
				<th>Action</th>
			</thead>
			<tbody>					
				@foreach($municipality as $municplty)
				<tr>
					<td><input class="chbox" name="chks[]" value="{{$municplty->id}}" type="checkbox"></td>
					<td>{{ $municplty->name }}</td>	
					<td>
					@foreach($provinces as $province)
						@if($municplty->province_id === $province->id)
						{{ $province->name }}
						@endif
					@endforeach
					</td>
				<td>
					<a class="editcoords" title="Edit"  href="<?php echo url('editmunicipality'); ?>/<?php echo 
					$municplty->id?>"><span class="glyphicon glyphicon-pencil"></span></a> | <a class="deledit" id="{{$municplty->id}}" value="{{$municplty->id}}" href="#" title="Delete"><span class="glyphicon glyphicon-trash">
						</span></a>
					</td>
				</tr>
				@endforeach	

			@include('pages.deletdialogmunicipality')
			</tbody>
		</table>
	</div>
	</form>
</div>

 @stop