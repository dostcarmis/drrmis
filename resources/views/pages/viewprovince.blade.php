@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Provinces</h1>
	</div>
	<form action="{{ action("ProvinceController@destroymultipleProvinces") }}">
	<div class="col-xs-12">
		<p style="color:red"><?php echo Session::get('message'); ?></p>
		<div class="col-xs-12 ulpaginations np">
			<div class="col-xs-8 np">
				<a id="btnadd-location" title="Add Province" class="btnadd-location btn" href="{{ action("ProvinceController@viewaddProvince") }}"><span class="glyphicon glyphicon-plus"></span> Add Province</a>
				<button disabled="disabled" type="submit" class="btn btn-deleteselected" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
			
			</div>
			<div class="col-xs-4 text-right np">{{ $provinces->links() }}</div>
		</div>
		<table class="table table-hover tblcoordinates" id="dashboardtables">
			<thead>
				<th><input type="checkbox" class="headcheckbox"></th>
				<th>Provinces</th>
				<th>Action</th>
			</thead>
			<tbody>					
				@foreach($provinces as $province)
				<tr>
					<td><input class="chbox" name="chks[]" value="{{$province->id}}" type="checkbox"></td>
					<td>{{ $province->name }}</td>		
				<td>
					<a class="editcoords" title="Edit"  href="<?php echo url('editprovince'); ?>/<?php echo 
					$province->id?>"><span class="glyphicon glyphicon-pencil"></span></a> | <a class="deledit" id="{{$province->id}}" value="{{$province->id}}" href="#" title="Delete"><span class="glyphicon glyphicon-trash">
						</span></a>
					</td>
				</tr>
				@endforeach	
				@include('pages.deletedialogprovinces')
			</tbody>
		</table>
	</div>
	</form>
</div>

 @stop