<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <li>
            <a href="{{ action("PagesController@home") }}"><i class="fa fa-eye" aria-hidden="true"></i> View Site</a>
        </li>
        <li>
            <a href="{{action('HydrometController@dashboard')}}"><i class="fa fa-tachometer"></i> Dashboard</a>
        </li>
        @if (Auth::user()->hasAccess(1))
        <li>
            <a data-toggle="modal" data-target="#selectfilemodal" href="#"><i class="fa fa-download"></i> 
                <span class="nav-module">{{Auth::user()->module(1)->name}}</span> </a>
        </li>
        @endif
        @if (Auth::user()->hasAccess(2))
        <li>
            <a data-toggle="modal" data-target="#selectsitreplevelmodal" href="#">
                <i class="fa fa-file-pdf-o" aria-hidden="true"></i> <span class="nav-module">{{Auth::user()->module(2) ? Auth::user()->module(2)->name:""}}</span>
            </a>
        </li>
        @endif
        <!------------------------------------ Report Dropdown -------------------------------------------->

        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#report" class="" aria-expanded="true">
                <i class="fa fa-bullhorn" aria-hidden="true"></i> Report <i class="fa fa-fw fa-caret-down float-end"></i>
            </a>
            <ul id="report" class="collapse" aria-expanded="true">
                @if (Auth::user()->hasAccess(3,'create'))
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
                @endif
                @if (Auth::user()->hasAccess(7))
                <li>
                    <a href="{{ action("ReportController@showReport") }}">
                        <i class="fa fa-line-chart"></i> <span class="nav-module">{{Auth::user()->module(7)->name}}</span></a>
                    </a>
                </li>         
                @endif                                      
            </ul>
        </li>

        <!------------------------------------ Monitor Dropdown -------------------------------------------->

        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#monitor" class="" aria-expanded="true">
                <i class="fa fa-desktop" aria-hidden="true"></i> Monitor <i class="fa fa-fw fa-caret-down float-end"></i>
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
                @if (Auth::user()->hasAccess(4))
                <li id="nav-clears">
                    <a href="#">
                        <i class="fa fa-files-o"></i> <span class="nav-module">{{Auth::user()->module(4)->name}}</span></a>
                    </a>
                </li>
                @endif
                @if (Auth::user()->hasAccess(5))
                <li>
                    @if (Auth::user()->role_id < 4)
                        <a data-toggle="modal" data-target="#selectProvmodal" href="#">
                            <i class="fa fa-files-o"></i> <span class="nav-module">{{Auth::user()->module(5)->name}}</span>
                        </a>
                    @else
                        <a href="{{ url("riskassessmentfiles/".Auth::user()->province_id."/".Auth::user()->municipality_id) }}">
                            <i class="fa fa-files-o"></i> <span class="nav-module">{{Auth::user()->module(5)->name}}</span>
                        </a>
                    @endif
                    
                </li>
                @endif
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

        @if(Auth::user()->hasAccess(8)) 
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#data" class="" aria-expanded="true">
                <i class="fa fa-book" aria-hidden="true"></i> <span class="nav-module">{{Auth::user()->module(8)->name}}</span> <i class="fa fa-fw fa-caret-down float-end"></i>
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

        @if(Auth::user()->hasAccess(6))
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#users" class="" aria-expanded="true">
                <i class="fa fa-user"></i> <span class="nav-module">{{Auth::user()->module(6)->name}}</span> <i class="fa fa-fw fa-caret-down float-end"></i>
            </a>
            <ul id="users" class="collapse" aria-expanded="true">
                @if(Auth::user()->hasAccess(6,'read'))
                <li>
                    <a href="{{ action("UserController@viewusers") }}">
                        <i class="fa fa-users"></i> View Users
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasAccess(6,'create'))
                <li>
                    <a href="{{ action("UserController@viewadduser") }}">
                        <i class="fa fa-user-plus"></i> Add Users
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasAccess(6,'read'))
                <li>
                    <a href="{{ action("UserController@viewGroups") }}">
                        <i class="fa fa-object-group"></i> View User Group
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasAccess(6,'create'))
                <li>
                    <a href="{{ action("UserController@viewCreateGroup") }}">
                        <i class="fa fa-plus-square-o"></i> Add User Group
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasAccess(6,'read'))
                <li>
                    <a href="{{ action("UserlogsController@viewactivitylogs") }}">
                        <i class="fa fa-user-secret"></i> User Activity
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        @if(Auth::user()->role_id == 1)
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#modules_expand" class="" aria-expanded="true">
                <span class="glyphicon glyphicon-wrench"></span> Module Access <i class="fa fa-fw fa-caret-down float-end"></i>
            </a>
            <ul id="modules_expand" class="collapse" aria-expanded="true">
                <li id="li-ma-users"><a href="#">User Access</a></li>
                <li id="li-modules"><a href="#">Module Management</a></li>
                <li id="li-roles"><a href="#">Role Management</a></li>
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