<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="innerNav">
    <ul class="nav navbar-right top-nav">
         @if(!$currentUser)
            <li class="login">{!! link_to_route('get_login', 'Login') !!}</li>
              <li class="divider">|</li>
              <li class="register">{!! link_to_route('get_register', 'Register') !!}</li>         
        @else  
        <li class="dropdown">
           <a href="#" id="seenotifications" value="1" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell"></i>
                <span class="notifcount hidden"></span>    
            </a>
            <ul class="dropdown-menu message-dropdown">
                 <li class="message-header">
                    Notifications
                </li>
                <li id="message-preview" class="message-preview">
                    
                </li>                        
                <li class="message-footer">
                    <a href="{{ action("SMSController@viewAllNotifications") }}" class="text-center">View all Notifications</a>
                </li>
            </ul>
        </li>

        <li class="dropdown">
           <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img class="smimg" src="{{ $currentUser->profile_img }}"> {{ $currentUser->first_name }} {{ $currentUser->last_name }}  <b class="caret"></b></a>
              <ul class="dropdown-menu drpinner">
                  <div class="col-xs-6 np leftsideinner"><li class="left"><img src="{{ $currentUser->profile_img }}"></li></div>
                  <div class="col-xs-6 rightsideinner" style="padding-right:0px;">
                    <li>
                      <a class="btn" href="{{ action("UserController@profile") }}">Profile</a>
                  </li>                        
                   <li>{!! link_to_route('get_logout', 'Log out',array() ,array('class' => 'btn')) !!}</li>
                  </div>                             
              </ul>
            </li>            
            @endif                   
    </ul>
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand"><span class="visible-xs hidden-sm hidden-md hidden-lg">DRRMIS</span><span class="hidden-xs visible-sm visible-md visible-lg">INCIDENT MAP VIEW</a>
    </div>


<!------------------------------------ Vertical Menu Navbar ------------------------------------------------------------------------------------------------------------------------->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="{{action('HydrometController@dashboard')}}"><i class="fa fa-tachometer"></i> Dashboard</a>
            </li> 
            
            <li>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><span class="glyphicon glyphicon-calendar"></span>Date:
                            <div class="well" style="background-color: #262626; color: #FFFFFF;">
                                <div id="reportrange" style="background: #fff;cursor: pointer; padding: 5px 10px; border: 2px solid #fff; width: 100%; color: black;">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                        </h4>   
                    </div>
                </div>
            </li>

            <div style="color: white; margin-bottom: 10px;">Select Incident:<br>
                <input type="checkbox" name="Landslide" value="landslide"> Landslide<br>
                <input type="checkbox" name="Flood" value="flood"> Floods<br>
            </div>  

            

            <div class="col-xs-12 r-links">
                <a href="#" id="all-viewmap" class="btn btn-default btn-block" onclick="$(this).toggleIconsAll();">View all incidents </a> 
            </div>

            <div class="col-xs-12 r-links">
                <a href="#" id="all-filteredmap" class="btn btn-default btn-block" onclick="$(this).toggleIconWithDateFilter()"> Proceed </a> 
            </div>

        </ul>    
    </div>
</nav>
   


  

