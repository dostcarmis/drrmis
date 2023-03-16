<!-- Navigation -->
<style>
    .navbar-nav>li>a{padding: 10px 10px;}
    .navbar-nav .fa,.navbar-nav .fas{width: 14px !important;}
</style>

<!------------------------------------ Horizontal Navbar ---------------------------------------------------------------------------------------------->

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="innerNav">
    <ul class="nav navbar-right top-nav">
        @if(!Auth::user())
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
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img class="smimg" src="{{ Auth::user()->profile_img }}"> 
                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} <b class="caret"></b>
            </a>
            <ul class="dropdown-menu drpinner">
                <div class="col-xs-6 np leftsideinner">
                    <li class="left"><img src="{{ Auth::user()->profile_img }}"></li>
                </div>
                <div class="col-xs-6 rightsideinner" style="padding-right:0px;">
                    <li>
                        <a class="btn" href="{{ action("UserController@profile") }}">Profile</a>
                    </li>                        
                    <li>
                        {!! link_to_route('get_logout', 'Log out',array() ,array('class' => 'btn')) !!}
                    </li>
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
        <a class="navbar-brand">
            <span class="visible-xs hidden-sm hidden-md hidden-lg">DRRMIS</span>
            <span class="hidden-xs visible-sm visible-md visible-lg">
                <span>M</span>onitoring & <span>E</span>arly Warning System for <span>L</span>andslides & Other Hazards
            </span>
        </a>
    </div>

    <!-------------------------------- Vertical Menu Navbar ------------------------------------------------------------------------------------------------------------------------->
    <div id="navsidebar">
        @include('layouts.partials.navsidebar')
    </div>

    <!-- /.navbar-collapse -->  

</nav>

@include('pages.mainviewriskassessfiles') 
@include('pages.selectsitrepmodal')
@include('pages.selectfiletypemodal')
<link rel="stylesheet" href="{{asset('assets/css/jquery.toast.min.css')}}">
<script src="{{asset('assets/js/jquery.toast.min.js')}}"></script>

<script>
    $(document)
    .on('click','#innerNav .navbar-ex1-collapse a[data-toggle=collapse]',function(e){
        $('#innerNav .navbar-ex1-collapse a[data-toggle=collapse]').not($(e.currentTarget)).toggleClass('collapsed').attr('aria-expanded','false').next('.collapse').removeClass('in').attr('aria-expanded','false');
    })
    .on('click','#nav-clears, #li-clears',function(){
        let url = baseURL+"clears-show";
        $.ajax({
            type:"POST",
            data:{},
            url: url,
            success:function(r){
                $('#page-wrapper').html(r)
                $('#clears-table').DataTable();
                $('[data-toggle="tooltip"]').tooltip();
            }
        })
    })
    .on('click','#li-ma-users',function(){
        let url = baseURL+"user-accesses";
        $.ajax({
            type:"POST",
            data:{},
            url: url,
            success:function(r){
                $(document).unbind('click','.ma-save').off('click','.ma-save');
                $(document).unbind('click','.nav-pills li:not(.active).m-toggle');
                $('#page-wrapper').html(r)
                $('[data-toggle="tooltip"]').tooltip();
            }
        })
    })
    .on('click','#li-modules',function(){
        let url = baseURL+"modules";
        $.ajax({
            type:"POST",
            data:{},
            url: url,
            success:function(r){
                $(document).unbind('click','.ma-save').off('click','.ma-save');
                $(document).unbind('click','.nav-pills li:not(.active).m-toggle');
                $('#page-wrapper').html(r)
                $('[data-toggle="tooltip"]').tooltip();
            }
        })
    })
    .on('click','#li-roles',function(){
        let url = baseURL+"rolesmgmt";
        $.ajax({
            type:"POST",
            data:{},
            url: url,
            success:function(r){
                $(document).unbind('click','.ma-save').off('click','.ma-save');
                $(document).unbind('click','.nav-pills li:not(.active).m-toggle');
                $('#page-wrapper').html(r)
                $('[data-toggle="tooltip"]').tooltip();
            }
        })
    });




</script>

