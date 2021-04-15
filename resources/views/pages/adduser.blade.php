@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Add User</h1>
	</div>
</div>

@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach


<form id="userform" action="{{ action('UserController@addnewuser') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">	
	<div class="col-xs-12 perinputwrap">
		<label>First Name</label>
		<input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name">
		@if ($errors->has('first_name')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12  perinputwrap">
		<label>Last Name</label>
		<input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name">
		@if ($errors->has('last_name')) <span class="reqsymbol">*</span> @endif
	</div>	
	<div class="col-xs-12  perinputwrap">
		<label>Username</label>
		<input type="text" name="username" id="username" class="form-control" placeholder="Username">
		@if ($errors->has('username')) <span class="reqsymbol">*</span> @endif
	</div>	
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Email</label>
		<input type="text" name="email" id="email" class="form-control" placeholder="Email Address">
		@if ($errors->has('email')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
	<label>Contact Number</label>
		<input type="text" name="cellphone_num" id="email" class="form-control" placeholder="Contact Number">
		@if ($errors->has('cellphone_num')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12  perinputwrap">
		<label>Position/Designation</label>
		<input type="text" name="position" id="position" class="form-control" placeholder="Position/Designation">
		@if ($errors->has('position')) <span class="reqsymbol">*</span> @endif
	</div>
	@if(Auth::user()->role_id == 1)
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Province:</label>
		<select name="province_id" id="province_id" class="form-control">
			<option>Select Province</option>
			@foreach($provinces as $province)
			<option value="{{ $province->id }}">{{ $province->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Municipality:</label>
		<select name="municipality_id"  id="municipality_id" class="form-control" disabled="disabled">
		
		</select>
	</div>
	<div class="col-xs-12 perinputwrap">
		<div class="col-xs-12 np col-sm-6">
			<label>Role:</label>
			<select name="role" id="role" class="form-control">
			@foreach($roles as $role)
				<option value="{{ $role->id }}">{{ $role->name }}</option>
			@endforeach
			</select>
		</div>
	</div>
	@endif
	
		
	<div class="col-xs-12 perinputwrap text-right">
	<input class ="btn btn-updatelocation"  type ="submit" value="Add User">
	<a class="btn btn-cancel" href="{{ action("UserController@viewusers") }}">Cancel</a> 
	</div>

</form>
 @stop