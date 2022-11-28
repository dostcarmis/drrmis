<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<div class="loginform">
  <div class="container-fluid">
      <nav class="navbar hidden-xs navbar-default" id="login-nav">        
        {{-- <form action="api/loginform" method="POST">
          <input type="text" name="data" class="d-none">
          <button type="submit">send</button>
        </form> --}}
      @if( !Auth::user() )
      
      <ul class="nav navbar-nav navbar-right"> 
        <li class="login">
        <a href="" data-toggle="modal" data-target="#modalLoginForm">Login</a>
        </li>
      </ul> 
      
      <!--<ul class="nav navbar-nav navbar-right">    
          <li class="login">{!! link_to_route('get_login', 'Login') !!}</li>   
        </ul>-->
      @else
      <ul class="nav navbar-nav navbar-right">    
      <li class="dropdown">
        <a href="#" data-toggle="dropdown"><img class="smimg" src="{{ Auth::user()->profile_img }}"> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}  <b class="caret"></b></a>
        <ul class="dropdown-menu homedrp">
            <li><a href="{{ action("HydrometController@dashboard") }}"> Dashboard</a></li>
            <li><a href="{{ action("UserController@profile") }}">Profile</a></li>                        
            <li>{!! link_to_route('get_logout', 'Log out') !!}</li>
        </ul>
      </li>    

       </ul>
         @endif  
         
      </nav>
  </div>
</div>

@include('pages.selectfiletypemodal')
@include('pages.selectsitrepmodal')
@include('pages.loginmodal')

