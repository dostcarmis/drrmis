@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Edit User</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach

<form id="editform" action="{{ action('UserController@updateuser') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">	
	<input type="hidden" name="id" value="<?= $users->id ?>">	


		<div class="col-xs-12 col-sm-6 perinputwrap">
			<label>First Name</label>
			<input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="<?= $users->first_name ?>">
			@if ($errors->has('first_name')) <span class="reqsymbol">*</span> @endif
		</div>
		<div class="col-xs-12 col-sm-6 perinputwrap">
			<label>Last Name</label>
			<input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="<?= $users->last_name ?>">
			@if ($errors->has('last_name')) <span class="reqsymbol">*</span> @endif
		</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Email</label>
		<input type="text" name="email" id="email" class="form-control" placeholder="Email Address" value="<?= $users->email ?>">
		@if ($errors->has('email')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Number</label>
		<input type="text" name="cellphone_num" id="cellphone_num" class="form-control" placeholder="Cellphone Number" value="<?= $users->cellphone_num ?>">
		@if ($errors->has('cellphone_num')) <span class="reqsymbol">*</span> @endif
	</div>
	@if($currentUser->role_id == 1)
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Province:</label>
		<select name="province_idedit" id="province_idedit" class="form-control">
			@foreach($provinces as $province)
				@if($users->province_id === $province->id)
				<option selected="selected" value="{{ $province->id }}">{{ $province->name }}</option>
				@else
				<option value="{{ $province->id }}">{{ $province->name }}</option>
				@endif		
			@endforeach
		</select>
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Municipality:</label>
		<select name="municipality_idedit" id="municipality_idedit" class="form-control">
			@foreach($municipalities as $municipality)
				@if($municipality->province_id === $users->province_id)
					@if($users->municipality_id === $municipality->id)
					<option selected="selected" value="{{ $municipality->id }}">{{ $municipality->name }}</option>
					@else
					<option value="{{ $municipality->id }}">{{ $municipality->name }}</option>
					@endif		
				@endif

			@endforeach
		</select>

	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Group:</label>
		<select name="group" id="group" class="form-control">
			<option>None</option>
			@foreach($groups as $group)
				@if($group->grp_id === $users->group)
					<option selected="selected" value="{{ $group->grp_id }}">
						{{ $group->group_name }}
					</option>
				@else
					<option value="{{ $group->grp_id }}">
						{{ $group->group_name }}
					</option>
				@endif
			@endforeach
		</select>
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Role:</label>
		<select name="role_id" id="role_id" class="form-control">
			@foreach($roles as $role)
				@if($role->id === $users->role_id)
					<option selected="selected" value="{{ $role->id }}">{{ $role->name }}</option>
				@else
					<option value="{{ $role->id }}">{{ $role->name }}</option>
				@endif
			@endforeach
		</select>
	</div>
	@endif
	

	<div class="col-xs-12 perinputwrap text-right">
	<a class ="btn btn-update" title="Update" data-toggle="modal" data-target="#mymodal">Update User</a>
	<a class="btn btn-cancel" href="{{ action("UserController@viewusers") }}">Cancel</a> 
	@include('pages.edituserdialog')
	</div>
	
</form>
 @stop

 
