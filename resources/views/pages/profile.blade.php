@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12 np profile-wrap">
		<span class="defsp message"><?php echo Session::get('message'); ?></span>
		<p style="color:red">{{ $errors->first('first_name') }}</p>
		<p style="color:red">{{ $errors->first('email') }}</p>
		<p style="color:red">{{ $errors->first('municipality_id') }}</p>
		<p style="color:red">{{ $errors->first('province_id') }}</p>
		<form enctype="multipart/form-data" action="{{ action('UserController@updateProfile') }}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="col-xs-12 profheadtitle">
				<h3>Name</h3>
			</div>	

			<div class="col-xs-12 col-sm-12 per-labels">
				<div class="col-xs-12 col-sm-2 spprofileslabel">
					<label>Username :</label>
				</div>
				<div class="col-xs-12 col-sm-9">
					<span class="defsp spprofile">
						{{ $user->username }}
					</span>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 per-labels">
				
				<div class="col-xs-12 col-sm-2 spprofileslabel">
					<label>First Name :</label>
				</div>
				<div class="col-xs-12 col-sm-9">
					<span class="defsp spprofile">
		<input type="text" name="first_name" value="{{ $user->first_name }}" class="proformtext form-control">
			</span>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 per-labels">
				<div class="col-xs-12 col-sm-2 spprofileslabel">
					<label>Last Name :</label>
				</div>
				<div class="col-xs-12 col-sm-9">
					<span class="defsp spprofile"><input type="text" name="last_name" value="{{ $user->last_name }}" class="proformtext form-control"></span>
				</div>
			</div>
			<div class="col-xs-12 profheadtitle">
				<h3>Contact Details</h3>
			</div>	
			<div class="col-xs-12 col-sm-12 per-labels">
				<div class="col-xs-12 col-sm-2 spprofileslabel">
					<label>Email Address :</label>
				</div>
				<div class="col-xs-12 col-sm-9">
					<span class="defsp spprofile">
						<input type="text" name="email" value="{{ $user->email }}" class="proformtext form-control">
					</span>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 per-labels">
				<div class="col-xs-12 col-sm-2 spprofileslabel">
					<label>Contact Number :</label>
				</div>
				<div class="col-xs-12 col-sm-9">
					<span class="defsp spprofile">
						<input type="text" name="cellphone_num" value="{{ $user->cellphone_num }}" class="proformtext form-control">
					</span></div>
			</div>	
			<div class="col-xs-12 profheadtitle">
				<h3>About Yourself</h3>
			</div>
			<div class="col-xs-12  col-sm-12 per-labels">
				<div class="col-xs-12 col-sm-2 spprofileslabel spprofileslabelpic">
					<label>Profile Picture :</label>
				</div>
				<div class="col-xs-12 col-sm-9">

					<div class="col-xs-2 profimg-img">
						<img class="profile-img" src="{{ $user->profile_img }}" id="holder">
					</div>
					<div class="col-xs-10 np proimg-right">
						<div class="input-group">
						  <span class="input-group-btn">
						    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
						      <i class="fa fa-picture-o"></i> Choose
						    </a>
						  </span>
						  <input id="thumbnail" class="form-control" value="{{ $user->profile_img }}" type="text" name="filepath">
						</div>
					</div>
				</div>
			</div>	
			@if($currentUser->id != 1)
			<div class="col-xs-12 col-sm-12 per-labels">
				<div class="col-xs-12 col-sm-2 spprofileslabel">
					<label>Province :</label>
				</div>
				<div class="col-xs-12 col-sm-9">
					<span class="defsp spprofile">
						@foreach($provinces as $province)
							@if($currentUser->province_id === $province->id)
							{{ $province->name }}
							@endif
						@endforeach
					</span>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 per-labels">
				<div class="col-xs-12 col-sm-2 spprofileslabel">
					<label>Municipality :</label>
				</div>
				<div class="col-xs-12 col-sm-9">
					<span class="defsp spprofile">
						@foreach($municipalities as $municipality)
							@if($currentUser->municipality_id === $municipality->id)
							{{ $municipality->name }}
							@endif
						@endforeach
					</span>
				</div>
			</div>
			@else
			<div class="col-xs-12 col-sm-12 per-labels">
				<div class="col-xs-12 col-sm-2 spprofileslabel">
					<label>Province :</label>
				</div>
				<div class="col-xs-12 col-sm-9">
					<span class="defsp spprofile">
						<select name="province_id" id="province_id"class="form-control">
							@foreach($provinces as $province)
								@if($user->province_id === $province->id)
									<option selected="selected" value="{{ $province->id }}">{{ $province->name }}</option>
									@else
									<option value="{{ $province->id }}">{{ $province->name }}</option>
								@endif	
							@endforeach
						</select>
					</span></div>
			</div>
			<div class="col-xs-12 col-sm-12 per-labels">
				<div class="col-xs-12 col-sm-2 spprofileslabel">
					<label>Municipality :</label>
				</div>
				<div class="col-xs-12 col-sm-9">
					<span class="defsp spprofile">
						<select name="municipality_id"  id="municipality_id" class="form-control">
							@foreach($municipalities as $municipality)
								@if($municipality->province_id === $user->province_id)
									@if($user->municipality_id === $municipality->id)
										<option selected="selected" value="{{ $municipality->id }}">{{ $municipality->name }}</option>
									@else
										<option value="{{ $municipality->id }}">{{ $municipality->name }}</option>
									@endif	
								@endif				
							@endforeach
						</select>
					</span>
				</div>
			</div>
			@endif
			<div class="col-xs-12 col-sm-12 per-labels">
				<div class="col-xs-12 col-sm-2 spprofileslabel">
					<label>Position :</label>
				</div>
				<div class="col-xs-12 col-sm-9">
					<span class="defsp spprofile">
						<input type="text" name="position" placeholder="Position" value="{{ $user->position }}" class="proformtext form-control">
					</span></div>
			</div>
			<div class="col-xs-12 col-sm-12 per-labels">
				<div class="col-xs-12 col-sm-2 spprofileslabel">
					<label>Designation :</label>
				</div>
				<div class="col-xs-12 col-sm-9">
					<span class="defsp spprofile">
						<input type="text" placeholder="Designation" name="designation" value="{{ $user->designation }}" class="proformtext form-control">
					</span></div>
			</div>	
			<div class="col-xs-12 col-sm-12 per-labels">
				<div class="col-xs-12 col-sm-2 spprofileslabel">
					<label>Role :</label>
				</div>
				<div class="col-xs-12 col-sm-9">
					<span class="defsp spprofile">
						@foreach($roles as $role)
							@if($currentUser->role_id === $role->id)
							{{ $role->name }}
							@endif
							@endforeach
					</span>
				</div>
			</div>	
			<div class="col-xs-12 profheadtitle">
				<h3>Account Management</h3>
			</div>
			<div class="col-xs-12 col-sm-12 per-labels">
				<div class="col-xs-12 col-sm-2 spprofileslabel">
					<label>New Password:</label>
				</div>
				<div class="col-xs-12 col-sm-9">
					<span class="defsp spprofile">
						<input type="password" name="password" placeholder="New Password" class="proformtext form-control">
					</span>
				</div>
			</div>
			<div class="col-xs-12 perinputwrap text-left">
				<input class ="btn btn-updatelocation"  type ="submit" value="Update Profile">
		 	</div>
		</form>
	</div>
</div>

 @stop
 @section('page-js-files')
<script src="{{asset('vendor/laravel-filemanager/js/lfm.js')}}"></script>
<script type="text/javascript">
	jQuery(function($){
		$('#lfm').filemanager('file');
	});
</script>
@endsection