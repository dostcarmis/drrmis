<!-- Navigation -->
<style>
    .navbar-nav>li>a{padding: 10px 10px;}
    .navbar-nav>li>a>.fa,.navbar-nav>li>a>.fas{max-width: 14px;}
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
    
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="{{ action("PagesController@home") }}"><i class="fa fa-eye" aria-hidden="true"></i> View Site</a>
            </li>
            <li>
                <a href="{{action('HydrometController@dashboard')}}"><i class="fa fa-tachometer"></i> Dashboard</a>
            </li>
            <li>
                <a data-toggle="modal" data-target="#selectfilemodal" href="#"><i class="fa fa-download"></i> DRRM KM Resources </a>
            </li>
            <li>
                <a data-toggle="modal" data-target="#selectsitreplevelmodal" href="#"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Sit Reps</a>
            </li>
            <!------------------------------------ Report Dropdown -------------------------------------------->

            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#report" class="" aria-expanded="true">
                    <i class="fa fa-bullhorn" aria-hidden="true"></i> Report <i class="fa fa-fw fa-caret-down float-end"></i>
                </a>
                <ul id="report" class="collapse" aria-expanded="true">
                    
                    <li class="dropside">
                        <a href="#"><i class="demo-icon icon-flood">&#xe800;</i> Add Incident</a>
                        <ul id="ul-incidents" class="dropdown-menu fslevel">
                            <li>
                                <a href="{{ action('LandslideController@viewaddLandslide') }}">+New Landslide Report</a>
                            </li>
                            <li>
                                <a href="{{ action('FloodController@viewaddFlood') }}">+New Flood Report</a>
                            </li>
                            <li>
                                <a href="{{ action('RoadController@viewaddRoadnetwork') }}">+New Road Closures Report</a>
                            </li>
                            <li>
                                <a href="{{ action('FiresController@viewaddFire') }}">+New Fire Report</a>
                            </li>
                            <li>
                                <a href="{{ action('VehicularController@viewaddvehicular') }}">+New Vehicular Report</a>
                            </li>
                        </ul>
                    </li> 
                    <li>
                        <a href="{{ action("ReportController@showReport") }}">
                            <i class="fa fa-line-chart"></i> Report Generation
                        </a>
                    </li>                                               
                </ul>
            </li>

            <!------------------------------------ Monitor Dropdown -------------------------------------------->
    
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#monitor" class="" aria-expanded="true">
                    <i class="fa fa-desktop" aria-hidden="true"></i> View Incidents <i class="fa fa-fw fa-caret-down float-end"></i>
                </a>
                <ul id="monitor" class="collapse" aria-expanded="true">
                    <li class="dropside">
                        <a href="#"><i class="demo-icon icon-waterlevel">&#xe801;</i> Hydromet Data</a>
                        <ul id="hydrometdata" class="dropdown-menu fslevel">
                            <li><a href="{{action('ChartController@viewmultipleCharts')}}">Graphical</a></li>
                            <li><a href="{{action('HydrometController@viewHydrometdata')}}">Tabular</a></li>
                            <li><a href="{{action('PagesController@home')}}">Map View</a></li>
                        </ul>
                    </li> 
                    <li class="dropside">
                        <a href="#"><i class="demo-icon icon-flood">&#xe800;</i> Incidents</a>
                        <ul id="ul-incidents" class="dropdown-menu fslevel">
                            <li class="dropside-side ndlevel">
                                <a>Tabular</a>
                                <ul class="dropdown-menu">
                                    {{--
                                    <li>
                                        <a value="Landslide" class="filterincident" href="{{action('IncidentsController@viewIncidents')}}?ftype=landslides">
                                            Landslides
                                        </a>
                                    </li>
                                    --}}
                                    <li>
                                        <a value="Landslide" class="filterincident" href="{{action('LandslideController@viewLandslides')}}">
                                            Landslide Reports
                                        </a>
                                    </li>
                                    <li>
                                        <a value="Flood" class="filterincident" href="{{action('FloodController@viewFloods')}}?ftype=floods">
                                            Floods Reports
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ action("RoadController@viewRoadnetworks") }}">
                                            Road Closures Reports
                                        </a>
                                    </li>
                                    <li>
                                        <a value="Fire" class="filterincident" href="{{action('LandslideController@viewLandslides')}}">
                                            Fire Reports
                                        </a>
                                    </li>
                                    <li>
                                        <a value="Vehicular" class="filterincident" href="{{action('LandslideController@viewLandslides')}}">
                                            Vehicular Reports
                                        </a>
                                    </li>
                                </ul>
                            </li>                                   
                            <li>
                                <a href="{{action('PagesController@incidentsMapView')}}">
                                    Map View
                                </a>
                            </li>
                        </ul>
                    </li> 
                    <li>
                        <a href="http://bagong.pagasa.dost.gov.ph/flood#dam-information" target="_blank">
                            <i class="demo-icon icon-dam">&#xe802;</i> Dam Status</a>
                        </li> 
                    {{--
                    <li>
                        <a href="{{ action("PagesController@home") }}">
                            <i class="fa fa-map" aria-hidden="true"></i> Hazard Maps
                        </a>
                    </li>
                    --}}              
                </ul>
            </li>      

            <!------------------------------------ Risk Assessment Dropdown -------------------------------------------->

            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#riskassess" class="" aria-expanded="true">
                    <i class="fa fa-flag"></i> Risk Assessment <i class="fa fa-fw fa-caret-down float-end"></i>
                </a>
                <ul id="riskassess" class="collapse" aria-expanded="true">
                    <li id="nav-clears">
                        <a href="#">
                            <i class="fa fa-files-o"></i> CLEARS
                        </a>
                    </li>
                    <li>
                        <a data-toggle="modal" data-target="#selectProvmodal" href="#">
                            <i class="fa fa-files-o"></i> PDRA
                        </a>
                    </li>
                    <li>
                        <a href="https://hazardhunter.georisk.gov.ph/" target="_blank">
                            <i class="fa fa-link" aria-hidden="true"></i> Others
                        </a>
                    </li>
                    <li>
                        @if(Auth::check() && Auth::user()->role_id < 3)
                        <a data-toggle="modal" data-target="#selectProvmodal" href="#">
                            <i class="fa fa-files-o"></i> Files
                        </a>
                        @else
                        <a href="{{ url("riskassessmentfiles/".Auth::user()->province->name) }}">
                            <i class="fa fa-files-o"></i> Files
                        </a>
                        @endif

                    </li>
                </ul>
            </li>

            <!------------------------------------ Warn Dropdown -------------------------------------------->
                
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#sms-module" class="" aria-expanded="true">
                    <i class="fa fa-signal"></i> Warn <i class="fa fa-fw fa-caret-down float-end"></i>
                </a>
                <ul id="sms-module" class="collapse" aria-expanded="true">
                    <li class="divider"><i class="fa fa-flag"></i></li>
                    <li>
                        <a href="{{ action("SMSController@viewNotificationSubscribers") }}">
                            <i class="fa fa-users"></i> Notification Subscribers 
                        </a>
                    </li>
                    <li>
                        <a href="{{ action("SMSController@viewAllNotifications") }}">
                            <i class="fa fa-flag"></i> All Notifications 
                        </a>
                    </li>
                    <li class="divider"><i class="fa fa-comment"></i> </li>
                    <li>
                        <a href="{{ action("SMSController@viewRegisteredContacts") }}">
                            <i class="fa fa-address-book"></i> Contacts
                        </a>
                    </li>
                    <li>
                        <a href="{{ action("SMSController@viewComposeMessage") }}">
                            <i class="fa fa-comment"></i> Compose Message
                        </a>
                    </li>
                    <li>
                        <a href="{{ action("SMSController@viewSentMessages") }}">
                            <i class="fa fa-paper-plane"></i> Sent
                        </a>
                    </li>
                </ul>
            </li>
                    
            <!---------------------------------- Libraries Dropdown -------------------------------------------->

            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2) 
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#data" class="" aria-expanded="true">
                    <i class="fa fa-book" aria-hidden="true"></i> Libraries <i class="fa fa-fw fa-caret-down float-end"></i>
                </a>
                <ul id="data" class="collapse" aria-expanded="true">
                    <li>
                        <a href="{{ action("SensorsController@viewSensor") }}">
                            <i class="fa fa-lg  fa-map-marker" aria-hidden="true"></i> Sensors
                        </a>
                    </li>
                    <li class="dropside">
                        <a href="{{ action("ThresholdController@viewThreshold") }}">
                            <i class="fa fa-linode" aria-hidden="true"></i> Threshold
                        </a>
                    </li> 
                    <li>
                        <a href="{{ action("SusceptibilityController@viewSusceptibility") }}">
                            <i class="fa fa-linode" aria-hidden="true"></i> Susceptibility
                        </a>
                    </li> 
                    <li>
                        <a href="{{ action('TyphoontrackController@viewTyphoonTracks') }}">
                            <i class="fa fa-road" aria-hidden="true"></i> Typhoon Tracks
                        </a>
                    </li> 
                    <li>
                        <a href="{{ action('HazardmapsController@viewHazardmaps')}}">
                            <i class="fa fa-map" aria-hidden="true"></i> Hazard Maps
                        </a>
                    </li> 
                    <li>
                        <a href="{{ action('HazardsController@viewHazards') }}">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Hazards
                        </a>
                    </li>
                    <li>
                        <a href="{{ action("FloodproneareasController@viewFloodproneAreas")}}">
                            <i class="fa fa-files-o" aria-hidden="true"></i> Flood-prone Areas
                        </a>
                    </li>
                    <li class="divider"><i class="fa fa-gear" aria-hidden="true"></i></li>
                    <li>
                        <a href="{{ action("CategoriesController@viewCategories") }}">
                            <i class="fa fa-list" aria-hidden="true"></i> Sensor Categories
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            <!---------------------------------- Users Dropdown -------------------------------------------->

            @if(Auth::user()->role_id <= 2 )
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#users" class="" aria-expanded="true">
                    <i class="fa fa-user"></i> Users <i class="fa fa-fw fa-caret-down"></i>
                </a>
                <ul id="users" class="collapse" aria-expanded="true">
                    <li>
                        <a href="{{ action("UserController@viewusers") }}">
                            <i class="fa fa-users"></i> View Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ action("UserController@viewadduser") }}">
                            <i class="fa fa-user-plus"></i> Add Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ action("UserController@viewGroups") }}">
                            <i class="fa fa-object-group"></i> View User Group
                        </a>
                    </li>
                    <li>
                        <a href="{{ action("UserController@viewCreateGroup") }}">
                            <i class="fa fa-plus-square-o"></i> Add User Group
                        </a>
                    </li>
                    <li>
                        <a href="{{ action("UserlogsController@viewactivitylogs") }}">
                            <i class="fa fa-user-secret"></i> User Activity
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            <!---------------------------------- DRRMLinks Dropdown -------------------------------------------->
            
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#links" class="" aria-expanded="true">
                    <i class="fa fa-external-link-square" aria-hidden="true"></i> DRRM Links <i class="fa fa-fw fa-caret-down float-end"></i>
                </a>
                <ul id="links" class="collapse" aria-expanded="true">
                    <li>
                        <a href="http://www.pagasa.dost.gov.ph/" target="_blank">
                            <i class="fa fa-link" aria-hidden="true"></i> PAGASA
                        </a>
                    </li>
                    <li>
                        <a href="http://www.phivolcs.dost.gov.ph/" target="_blank">
                            <i class="fa fa-link" aria-hidden="true"></i> PHIVOLCS
                        </a>
                    </li>
                    <li>
                        <a href="http://fmon.asti.dost.gov.ph/" target="_blank">
                            <i class="fa fa-link" aria-hidden="true"></i> PREDICT
                        </a>
                    </li>
                    <li>
                        <a href="http://climatex.dost.gov.ph/" target="_blank">
                            <i class="fa fa-link" aria-hidden="true"></i> ClimateX
                        </a>
                    </li>
                    <li>
                        <a href="http://noah.dost.gov.ph/" target="_blank">
                            <i class="fa fa-link" aria-hidden="true"></i> NOAH
                        </a>
                    </li>
                    <li>
                        <a href="https://dream.upd.edu.ph/" target="_blank">
                            <i class="fa fa-link" aria-hidden="true"></i> DREAM
                        </a>
                    </li>   
                    <li>
                        <a href="https://lipad.dream.upd.edu.ph/" target="_blank">
                            <i class="fa fa-link" aria-hidden="true"></i> LIPAD
                        </a>
                    </li>
                    <li>
                        <a href="https://hazardhunter.georisk.gov.ph/" target="_blank">
                            <i class="fa fa-link" aria-hidden="true"></i> HazardhunterPH
                        </a>
                    </li>   
                    <li>
                        <a href="https://v2-cloud.meteopilipinas.gov.ph/" target="_blank">
                            <i class="fa fa-link" aria-hidden="true"></i> MDSI
                        </a>
                    </li>   
                    <li>
                        <a href="http://www.geoportal.gov.ph/?fbclid=IwAR0RX5o20shREypitmacKXnGAe6IBjhHnnkZzTzZqJLAKaNpMlqwS8Wf4Vc" target="_blank">
                            <i class="fa fa-link" aria-hidden="true"></i> Geoportal
                        </a>
                    </li>
                    <li>
                        <a href="http://gdis.mgb.gov.ph/mgbgoogle/?fbclid=IwAR1PxiAnZfvPzbDR_-ursAeDCgP2troJRbOcg9u78cbT0iOCmzgjC_ucN2o" target="_blank">
                            <i class="fa fa-link" aria-hidden="true"></i> MGB gdis
                        </a>
                    </li>
                    <li>
                        <a href="http://dews.asti.dost.gov.ph/" target="_blank">
                            <i class="fa fa-link" aria-hidden="true"></i> DEWS
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

    <!-- /.navbar-collapse -->  

</nav>

@include('pages.mainviewriskassessfiles') 
@include('pages.selectsitrepmodal')
@include('pages.selectfiletypemodal')

<script>
    $(document)
    .on('click','#innerNav .navbar-ex1-collapse a[data-toggle=collapse]',function(e){
        $('#innerNav .navbar-ex1-collapse a[data-toggle=collapse]').not($(e.currentTarget)).toggleClass('collapsed').attr('aria-expanded','false').next('.collapse').removeClass('in').attr('aria-expanded','false');
    })
    .on('click','#nav-clears',function(){
        let url = baseURL+"clears-show";
        $.ajax({
            type:"POST",
            data:{},
            url: url,
            success:function(r){
                $('#page-wrapper').html(r)
                $('#clears-table').DataTable();
                $('[data-toggle="tooltip"]').tooltip();
                /* var map = new google.maps.Map(document.getElementById('addcoords'),{
                    center:{
                        lat:17.351324,
                        lng:121.17500399999994
                    },
                    zoom:9
                });
                var marker = new google.maps.Marker({
                    position:{
                        lat:17.351324,
                        lng:121.17500399999994
                    },
                    map:map,
                    draggable:false
                }); */
            }
        })
    })
</script>