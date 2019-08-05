@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Category</h1>
	</div>
	<form action="{{ action("CategoriesController@destroymultipleCategories") }}">
	<div class="col-xs-12">
		<p style="color:red"><?php echo Session::get('message'); ?></p>

		<div class="col-xs-12 ulpaginations np">
			<div class="col-xs-8 np">
				<a id="btnadd-location" title="Add Category" class="btnadd-location btn" href="{{ action("CategoriesController@viewaddCategories") }}"><span class="glyphicon glyphicon-plus"></span> Add Category</a>

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
		<table class="table table-hover tblcoordinates tbl-categories" id="dashboardtables">
			<thead>
				<th class="no-sort"><input type="checkbox" class="headcheckbox"></th>
				<th>Category</th>
			</thead>
			<tbody>					
				@foreach($categories as $category)
				<tr>
					<td><input class="chbox" name="chks[]" value="{{$category->id}}" type="checkbox"></td>
					<td>
						<a class="desctitle" href="<?php echo url('editcategory'); ?>/<?php echo $category->id?>">
							{{ $category->name }}
						</a>
						<span class="defsp spactions">
							<div class="inneractions">
								<a href="<?php echo url('editcategory'); ?>/<?php echo $category->id; ?>">Edit</a> | 
								<a class="deletepost" href="#" id="{{$category->id}}" value="{{$category->id}}" title="Delete">Delete</a>
							</div>								
						</span>
					</td>	
				</tr>
				@endforeach	
			@include('pages.deletedialogcategories')
			</tbody>
		</table>
	</div>
	</form>
</div>

 @stop