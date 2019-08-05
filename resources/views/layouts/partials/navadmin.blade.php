<!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top hidden-xs" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <ul class="nav navbar-right top-nav">
                 @if( !$currentUser )
                    <li class="login">{!! link_to_route('get_login', 'Login') !!}</li>
                      <li class="divider">|</li>
                      <li class="register">{!! link_to_route('get_register', 'Register') !!}</li>         
                @else  

                <li class="dropdown">
                    @include('pages.navnotification')
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
                
                <a class="navbar-brand"><span class="visible-xs hidden-sm hidden-md hidden-lg">MEWSLOH</span><span class="hidden-xs visible-sm visible-md visible-lg"><span>M</span>onitoring & <span>E</span>arly Warning System for <span>L</span>andslides & Other Hazards</span></a>
            </div>
            <!-- Top Menu Items -->
            
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="{{action('HydrometController@dashboard')}}"><i class="fa fa-tachometer"></i> Dashboard</a>
                        <ul id="dashboard" class="in" aria-expanded="true">
                            <li>
                                <a href="{{ action("PagesController@home") }}">View Site</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#report" class="" aria-expanded="true">
                            <i class="fa fa-bullhorn" aria-hidden="true"></i> Report <i class="fa fa-fw fa-caret-down"></i>
                        </a>
                        <ul id="report" class="collapse" aria-expanded="true">
                            <li>
                                <a href="{{ action("ReportController@showReport") }}"><i class="fa fa-line-chart"></i> Report Generation </a>
                                
                            </li>
                            <li class="dropside">
                                <a href="#"><i class="demo-icon icon-flood">&#xe800;</i> Incidents</a>
                                <ul id="ul-incidents" class="dropdown-menu fslevel">
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
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#monitor" class="" aria-expanded="true">
                            <i class="demo-icon">&#xe804;</i> Monitor <i class="fa fa-fw fa-caret-down"></i>
                        </a>
                        <ul id="monitor" class="collapse" aria-expanded="true">
                            <li class="dropside">
                                <a href="#"><i class="demo-icon icon-waterlevel">&#xe801;</i> Hydromet Data</a>
                                <ul id="hydrometdata" class="dropdown-menu fslevel">
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
                            <li class="dropside">
                                <a href="#"><i class="demo-icon icon-flood">&#xe800;</i> Incidents</a>
                                <ul id="ul-incidents" class="dropdown-menu fslevel">
                                    <li class="dropside-side ndlevel">
                                        <a href="{{action('IncidentsController@viewIncidents')}}?ftype=all"">Tabular</a>
                                        <ul class="dropdown-menu">
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
                                <a href="http://www1.pagasa.dost.gov.ph/index.php/floods/status-of-monitored-dams" target="_blank"><i class="demo-icon icon-dam">&#xe802;</i> Dam Status</a>
                            </li> 

                            <li>
                                <a href="{{ action("PagesController@home") }}"><i class="fa fa-map" aria-hidden="true"></i> Hazard Maps</a>
                            </li>                   
                        </ul>
                    </li>              
                    

                    

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#sms-module" class="" aria-expanded="true"><i class="glyphicon glyphicon-signal"></i> Warn <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="sms-module" class="collapse" aria-expanded="true">

                            <li>
                                <a href="{{ action("SMSController@viewRegisteredContacts") }}"><i class="glyphicon glyphicon-user" aria-hidden="true"></i> Subscribers </a>
                            </li>
                            <li>
                                <a href="{{ action("SMSController@viewAllNotifications") }}"><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i> All Notifications </a>
                            </li>

                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#data" class="" aria-expanded="true"><i class="fa fa-book" aria-hidden="true"></i> Libraries <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="data" class="collapse" aria-expanded="true">

                            <li class="dropside">
                                <a href="#"><i class="fa fa-linode" aria-hidden="true"></i> Threshold</a>
                                <ul id="ul-incidents" class="dropdown-menu fslevel">
                                    <li>                           
                                        <a href="{{ action("ThresholdController@viewThreshold") }}"> Landslide Threshold</a>
                                    </li>
                                    <li>
                                        <a href="{{ action("ThresholdFlood@viewThresholdFlood") }}"> Flood Threshold</a>
                                    </li>

                                 </ul>
                            </li> 
                            <li>
                                <a href="{{action('HazardmapsController@viewHazardmaps')}}"><i class="fa fa-map" aria-hidden="true"></i> Hazard Maps</a>
                            </li> 

   
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#users" class="" aria-expanded="true"><i class="fa fa-user"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="users" class="collapse" aria-expanded="true">
                            <li>
                                <a href="{{ action("UserController@viewusers") }}"><i class="fa fa-users"></i> View Users</a>
                            </li>
                            <li>
                                <a href="{{ action("UserController@viewadduser") }}"><i class="fa fa-user-plus"></i> Add Users</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#links" class="" aria-expanded="true"><i class="fa fa-external-link-square" aria-hidden="true"></i> DRRM Links <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="links" class="collapse" aria-expanded="true">

                            <li>
                                <a href="http://www.pagasa.dost.gov.ph/" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> PAGASA</a>
                            </li>
                            
                            <li>
                                <a href="http://www.phivolcs.dost.gov.ph/" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> PHIVOLCS</a>
                            </li>
                            <li>
                                <a href="http://fmon.asti.dost.gov.ph/" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> PREDICT</a>
                            </li>
                            <li>
                                <a href="http://climatex.dost.gov.ph/" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> ClimateX</a>
                            </li>
                            
                            <li>
                                <a href="http://noah.dost.gov.ph/" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> NOAH</a>
                            </li>
                            <li>
                                <a href="https://dream.upd.edu.ph/" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> DREAM</a>
                            </li>   
                            <li>
                                <a href="https://lipad.dream.upd.edu.ph/" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> LIPAD</a>
                            </li>   
   
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>