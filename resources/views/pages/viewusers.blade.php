@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Users</h1>
	</div>

	<form action="{{ action("UserController@destroymultipleUser") }}">

	<div class="col-xs-12">
		<p style="color:red"><?php echo Session::get('message'); ?></p>
		<div class="col-xs-12 ulpaginations np">
			<div class="col-xs-12 col-sm-8 np">
				<a id="btnadd-location" title="Add User" class="btnadd-location btn" href="{{ action("UserController@viewadduser") }}"><span class="glyphicon glyphicon-plus"></span> Add User</a>

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
		<table class="table table-hover tblusers" id="dashboardtables">
			<thead>
				<th class="no-sort"><input type="checkbox" class="headcheckbox"></th>
				<th>Name</th>
				<th>Email Address</th>		
				<th>Contact #</th>		
				<th>Role</th>
				<th>Province</th>
				<th>Municipality</th>		
			</thead>
			<tbody>					
				@foreach($users as $user)
				<tr>
					<td><input class="chbox" name="chks[]" value="{{$user->id}}" type="checkbox"></td>
					<td>

					<a class="desctitle" href="<?php echo url('edituser'); ?>/<?php echo $user->id?>">{{ $user->first_name }} {{ $user->last_name }}</a>
						<span class="defsp spactions">
							<div class="inneractions">
								<a href="<?php echo url('edituser'); ?>/<?php echo $user->id; ?>">Edit</a> | 
								<a class="deletepost" href="#" id="{{$user->id}}" value="{{$user->id}}" title="Delete">Delete</a>
							</div>								
						</span>
					</td>
					<td>{{ $user->email }}</td>	
					<td>{{ $user->cellphone_num }}</td>	
					<td>
					@foreach($roles as $role)
					@if($user->role_id === $role->id)
					{{ $role->name }}
					@endif
					@endforeach					
					</td>	
					<td>
					@foreach($provinces as $province)					        
						@if($province->id === $user->province_id)
							{{$province->name}}
						@endif
					@endforeach	
					</td>
					<td>
					@foreach($municipalities as $municipality)
						@if($municipality->id === $user->municipality_id)
							{{$municipality->name}}
						@endif
					@endforeach	
					</td>	
					
					
				</tr>
				@endforeach	
				@include('pages.deletedialoguser')
			</tbody>
		</table>
	</div>
</form>
</div>

 @stop
