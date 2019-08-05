@extends('layouts.masters.auth-layouts')
@section('page-content')
<div class="row">

	<div class="col-xs-12 loginwrap col-sm-offset-4 col-sm-4">
		<h1>Login</h1>
		@foreach ($errors->all() as $message)
		    <p style="color:red">{{ $message }}</p>
		@endforeach
		{!! Form::open(['route' => 'post_login', 'id' => 'login-form'])!!}
			{!! Form::text('login',null,['id' => 'email', 'class' => 'form-control txtlogin', 'placeholder' => 'Email Address or Username', 'required']) !!}
			{!! Form::password('password',['id' => 'password', 'class' => 'form-control txtpassword', 'placeholder' => 'Password', 'required']) !!}
			<div class="col-xs-12 np text-center">{!! Form::button('Sign in', ['class' => 'btn btn-primary btnlogindef', 'type' => 'submit']) !!}</div>
		{!! Form::close() !!}
		<span class="defsp spsignup text-center">{!! link_to_route('get_register', 'Sign up') !!} for new account</span>
		<span class="defsp spsignup text-center"> or {!! link_to_action('PagesController@home', 'Go back') !!} to map</span>
	</div>
</div>
@stop
