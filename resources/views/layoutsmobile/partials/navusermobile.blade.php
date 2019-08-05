@include('layouts.partials.banner')
@section('mobilemenus')
<div class="col-xs-12 navmainmenumobile" id="mobilehomelinkwrap">
    <ul>
        <li>
            <a href="#mainmenus" class="stripelink"><span></span></a>
        </li>
        <li>            
            <a href="{{action('NotificationsController@viewmobileNotifications')}}" id="seenotificationsmobile" value="1">
                <i class="fa fa-bell"></i>
                @if($notifcount != 0)
                    <span class="notifcount">{{ $notifcount }}</span>
                @endif       
            </a>
        </li>
        <li>
            <a href="{{ action("PagesController@home") }}"><i class="fa fa-external-link" aria-hidden="true"></i></a>
        </li>
        <li>
            <a href="#mainmenumobile"><i class="fa fa-user-o" aria-hidden="true"></i></a>
        </li>
    </ul>
</div>
@endsection
<nav id="mainmenus" class="mobilenav hidden-sm hidden-lg hidden-md" role="navigation">
    <ul>
        <li><a href="{{action('HydrometController@dashboard')}}">Dashboard</a></li>
        
        <li><span>Report</span>
            <ul>
                <li><a href="{{ action("ReportController@showReport") }}">Report Generation </a></li>
                <li><span>Incidents</span>
                    <ul>
                        <li>
                            <a href="{{ action('IncidentsController@viewaddIncident') }}">Landslide</a>
                        </li>
                        <li>
                            <a href="{{ action('IncidentsController@viewaddIncident') }}">Flood</a>
                        </li>
                        <li>
                            <a href="{{ action('RoadController@viewaddRoadnetwork') }}">Road Closures</a>
                        </li>
                    </ul>
                </li>
             
            </ul>
        </li>
        <li><span>Monitor</span>
            <ul>
                <li><span>Hydromet Data</span>
                    <ul>
                        <li>
                            <a href="{{action('ChartController@viewmultipleCharts')}}">Graphical</a>
                        </li>
                        <li>
                            <a href="{{action('HydrometController@viewHydrometdata')}}">Tabular</a>
                        </li>
                        <li>
                            <a href="{{action('PagesController@home')}}">Map View</a>
                        </li>
                    </ul>
                </li>
                <li><span>Incidents</span>
                    <ul>
                        <li><span>Tabular</span>
                        <ul>
                            <li><a value="Landslide" class="filterincident" href="{{action('IncidentsController@viewIncidents')}}?ftype=landslides">Landslides</a></li>
                            <li><a value="Flood" class="filterincident" href="{{action('IncidentsController@viewIncidents')}}?ftype=floods">Floods</a></li>
                            <li><a href="{{ action("RoadController@viewRoadnetworks") }}">Road Closures</a></li>
                        </ul>
                        </li>
                        <li>
                            <a href="{{action('PagesController@mapView')}}">Map View</a>
                        </li>
                    </ul>                    
                </li>
                <li>
                    <a href="http://www.pagasa.dost.gov.ph/index.php/floods/status-of-monitored-dams" target="_blank">Dam Status</a>
                </li> 
  
                <li>
                    <a href="{{ action("PagesController@home") }}">Hazard Maps</a>
                </li> 
            </ul>
        </li>
        <li><span>DRRM Links</span>
            <ul>
                <li>
                    <a href="http://www.pagasa.dost.gov.ph/" target="_blank">PAGASA</a>
                </li>
                
                <li>
                    <a href="http://www.phivolcs.dost.gov.ph/" target="_blank">PHIVOLCS</a>
                </li>
                <li>
                    <a href="http://fmon.asti.dost.gov.ph/" target="_blank">PREDICT</a>
                </li>
                <li>
                    <a href="http://climatex.dost.gov.ph/" target="_blank">ClimateX</a>
                </li>
                
                <li>
                    <a href="http://noah.dost.gov.ph/" target="_blank">NOAH</a>
                </li>
                <li>
                    <a href="https://dream.upd.edu.ph/" target="_blank">DREAM</a>
                </li>   
                <li>
                    <a href="https://lipad.dream.upd.edu.ph/" target="_blank">LIPAD</a>
                </li>   

            </ul>
        </li>
    </ul>
</nav>
<nav id="mainmenumobile" class="mobilenav hidden-sm hidden-lg hidden-md" role="navigation">
<ul class="top-nav">
     @if( !$currentUser )
        <li class="login">{!! link_to_route('get_login', 'Login') !!}</li>
        <li class="register">{!! link_to_route('get_register', 'Register') !!}</li>         
    @else  
    
    <li><a href="{{ action("UserController@profile") }}"><img class="smimg" src="{{ $currentUser->profile_img }}"> {{ $currentUser->first_name }} {{ $currentUser->last_name }}</a></li>
    <li>{!! link_to_route('get_logout', 'Log out',array() ,array('class' => 'btn')) !!}</li>
                   
        @endif                   
</ul>
</nav>
