<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="loginwrap">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1; color: #fff;">
            <span aria-hidden="true">&times;</span>
          </button>
        <h1>Login</h1>
      <div class="modal-body mx-3">
            @foreach ($errors->all() as $message)
                <p style="color:red">{{ $message }}</p>
            @endforeach
            {!! Form::open(['route' => 'post_login', 'id' => 'login-form'])!!}
                {!! Form::text('login',null,['id' => 'email', 'class' => 'form-control txtlogin', 'placeholder' => 'Email Address or Username', 'required']) !!}
                {!! Form::password('password',['id' => 'password', 'class' => 'form-control txtpassword', 'placeholder' => 'Password', 'required']) !!}
                <!--<div class="col-xs-12 np text-center">{!! Form::button('Sign in', ['class' => 'btn btn-primary btnlogindef', 'type' => 'submit']) !!}</div>-->
            <!--<span class="defsp spsignup text-center">{!! link_to_route('get_register', 'Sign up') !!} for new account</span>-->
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <div class="col-xs-12 np text-center">{!! Form::button('Sign in', ['class' => 'btn btn-primary btnlogindef', 'type' => 'submit']) !!}</div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>