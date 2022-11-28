@extends('layouts.masters.auth-layouts')
@section('page-content')
	<div class="row">
		<div class="col-xs-12 loginwrap col-sm-offset-4 col-sm-4">
			<h1>Register Account</h1>
				@foreach ($errors->all() as $message)
				    <p style="color:red">{{ $message }}</p>
				@endforeach
				{!! Form::open(['route' => 'post_register', 'id' => 'registration-form'])!!}
				{!! Form::text('first_name', null, 
							   ['id' => 'first_name', 
								'class' => 'txtfname form-control', 
								'placeholder' => 'First Name', 
								'required']) !!}
				{!! Form::text('last_name', null,
							   ['id' => 'last_name', 
								'class' => 'txtlname form-control', 
								'placeholder' => 'Last Name',
								'required']) !!}
				{!! Form::email('email',null,['id' => 'email', 'class' => 'txtemail form-control', 'placeholder' => 'Email Address', 'required']) !!}
				{!! Form::text('username',null,['id' => 'username', 'class' => 'txtusername form-control', 'placeholder' => 'Username', 'required']) !!}
				{!! Form::password('password',['id' => 'password', 'class' => 'form-control txtpassword', 'placeholder' => 'Password', 'required']) !!}
				<select name="province_id" id="province_id" class="form-control">
						<option>Select Province</option>	
					@foreach($provinces as $province)				
						<option value="{{ $province->id }}">{{ $province->name }}</option>			
					@endforeach
				</select>
				<select name="municipality_id" id="municipality_id" disabled="disabled" class="form-control">
					<option>Select Municipality</option>
				</select>
				<div class="col-xs-12 np text-center">{!! Form::button('Register', ['class' => 'btn btn-primary btnlogindef', 'type' => 'submit']) !!}</div>
		{!! Form::close() !!}
		<span class="defsp spsignup text-center">Already Registered? {!! link_to_route('get_login', 'Login here') !!} </span>
		<span class="defsp spsignup text-center"> or {!! link_to_action('PagesController@home', 'Go back') !!} to map</span>
		</div>
	</div>
@endsection
@section('page-js-files')

@endsection