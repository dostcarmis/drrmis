<style>
    #clear-fluid #clears-table {font-size: small;}
    #clear-fluid .panel-title{flex-grow: 1;}
    .grid-container {-webkit-column-count: 2;column-count: 2;}
    .grid-container .panel{-webkit-column-break-inside: avoid;page-break-inside: avoid;break-inside: avoid;}
    #addcoords{ width: 100%; }
    #clears-table.table>tbody>tr>td{padding:5px 0px; text-align: center;}
    #clears-table.table>tbody>tr>td.text-danger{color: red !important;}
    #clears-table.table>tbody>tr>td.text-success{color: rgb(4, 157, 4) !important;}
    #clears-table.table>tbody>tr>td.text-warning{color: orange !important;}
</style>
<div id="page-wrapper">
    <div class="container-fluid" id="clear-fluid">
        <div class="wrap">
            <div class="dashboardtitle"><h1 id="h4mapview">CLEARS</h1></div>
            <div class="lead">RAIN-INDUCED LANDSLIDE SUSCEPTIBILITY</div>
            <h4>Map View</h4>
            <div id="addcoords" class="w-100"><span class="ms-3">Click on a report below to view its location</span></div>
            <div class="d-none">
                <span class="title defsp">Drag Map marker to change Coordinates</span>
                <div class="np">
                    <label>Latitude:</label>
                    <input form="fire-form" type="text" name="latitude" id="latitude" class="form-control" value="17.351324" placeholder="Enter latitude">
                </div>
                <div class="np">
                    <label>Longitude:</label>
                    <input form="fire-form" type="text" name="longitude" id="longitude" class="form-control" value="121.17500399999994" placeholder="Enter longitude">
                </div>
                <div class="perinputwrap np">
                    <div class="col-xs-12 text-center np">
                            <input form="fire-form" class="btn btn-updatelocation"  type="submit" value="Save Fire" style="width: 200px">
                    </div>	
                </div>
            </div>
            <div class="mt-5">
                <h4>Reports List</h4>
                <table id="clears-table" class="table tbldashboard table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Survey Date</th>
                            <th class="text-center">Municipality</th>
                            <th class="text-center">Province</th>
                            <th class="text-center">Uploaded by</th>
                            <th class="text-center" data-toggle="tooltip" title="Slope Material">sR</th>
                            <th class="text-center" data-toggle="tooltip" title="Vegetation">vF</th>
                            <th class="text-center" data-toggle="tooltip" title="Frequency of slope failure">fF</th>
                            <th class="text-center" data-toggle="tooltip" title="Presence of springs">sRed</th>
                            <th class="text-center" data-toggle="tooltip" title="Condition of drainage/canal/culvert within the site/slope">dRed</th>
                            <th class="text-center" data-toggle="tooltip" title="Amount of rainfall (mm) in 24 hours">Rain</th>
                            <th class="text-center" data-toggle="tooltip" title="Land use">lF</th>
                            <th class="text-center" data-toggle="tooltip" title="Slope rating">&alpha;Rating</th>
                            <th class="text-center" data-toggle="tooltip" title="Factor of stability">Fs</th>
                            <th class="text-center">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($res as $r)
                            <tr long = "{{$r->survey_longitude}}" lat = "{{$r->survey_latitude}}" report-id="{{$r->id}}">
                                <td class="c-date">{{date('Y-m-d',strtotime($r->survey_date))}}</td>
                                <td class="c-m-id" m_id="{{$r->municipality_id}}">{{$r->municipality->name}}</td>
                                <td>{{$r->province->name == "Mountain Province" ? "Mt. Province":$r->province->name }}</td>
                                <td>{{$r->user->first_name." ".$r->user->last_name}}</td>
                                <td class="text-center c-material" data-toggle="tooltip" mid = "{{$r->material_id}}" title="{{$r->slopeMaterial($r->material_id)}}">{{$r->sRating}}</td>
                                <td class="text-center c-vegetation" data-toggle="tooltip" title="{{$r->vegetation($r->vFactor)}}">{{$r->vFactor}}</td>
                                <td class="text-center c-freq" data-toggle="tooltip" title="{{$r->frequency($r->frequency_id)}}" fid = {{$r->frequency_id}}>{{$r->fFactor}}</td>
                                <td class="text-center c-spring" data-toggle="tooltip" title="{{$r->springs($r->sRed)}}">{{$r->sRed}}</td>
                                <td class="text-center c-canal" data-toggle="tooltip" title="{{$r->canals($r->dRed)}}">{{$r->dRed}}</td>
                                <td class="text-center c-rain" data-toggle="tooltip" title="{{$r->rain($r->rain)}}">{{$r->rain}}</td>
                                <td class="text-center c-land" data-toggle="tooltip" lid="{{$r->land_id}}" title="{{$r->land($r->land_id)}}">{{$r->lFactor}}</td>
                                <td class="text-center c-slope" data-toggle="tooltip" title="{{$r->slopeAngle($r->alphaRating)}}" >{{$r->alphaRating}}</td>
                                <td class="text-center c-stability strong {{
                                    ($r->Fs >= 1.2) ? "text-success" : 
                                    (
                                        ($r->Fs < 1.2 && $r->Fs >= 1) || ($r->Fs < 1 && $r->Fs >= 0.7) ? "text-warning" : 
                                        (
                                            ($r->Fs < 0.7) ? "text-danger" : ""
                                        )
                                    )}}" data-toggle="tooltip" title="{{$r->stability($r->Fs)}}">{{$r->Fs}}</td>
                                <td>
                                    @if(Auth::user()->id == $r->user_id)
                                    <div class="btn-group" role="group" aria-label="...">
                                        <button id="clears-e-btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#clears-edit-modal"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        <button id="clears-d-btn" type="button" class="btn btn-danger" data-toggle="modal" data-target="#clears-delete-modal"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </div>
                                    @endif
                                </td>
                            </tr>                        
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="strong d-flex mt-3">
                <h4>Reference Tables</h4>
                <button id="master-panel-toggler" class="my-auto ms-3 btn btn-sm strong border-none" is_hidden="false">Hide all</button>
            </div>
            <div class="grid-container">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="d-flex">
                            <h5 class="panel-title">Slope Material | <b><i>sRating</i></b></h5>
                            <button class="border-none bg-none p-0 panel-toggler" data-toggle="tooltip" title="Toggle show/hide"><i class="fa fa-expand" aria-hidden="true" class="panel-toggler"></i></button>
                        </div>
                        <hr>
                        <table class="table" is_hidden="false">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Value</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>HR1</td><td class="text-center">100</td><td>Massive and intact hard rock</td></tr>
                                <tr><td>HR2</td><td class="text-center">45</td><td>Blocky, well-interlocked hard rock, rock mass consisting mostly of cubical blocks</td></tr>
                                <tr><td>HR3</td><td class="text-center">25</td><td>Very blocky and fractured hard rock (disturbed with multifaceted angular blocks formed by 4 or more discontinuity sets) </td></tr>
                                <tr><td>HR4</td><td class="text-center">13</td><td>Disintegrated, unstable rocks and boulders, protruding rock fragments</td></tr>
                                <tr><td>SR1</td><td class="text-center">30</td><td>Massive and intact soft rock</td></tr>
                                <tr><td>SR2</td><td class="text-center">15</td><td>Very blocky and fractured soft rock </td></tr>
                                <tr><td>HS1</td><td class="text-center">25</td><td>Stiff, cemented and dense gravelly, sandy, silty and clayey soils</td></tr>
                                <tr><td>SS1</td><td class="text-center">10</td><td>Gravelly soil</td></tr>
                                <tr><td>SS2</td><td class="text-center">8</td><td>Sandy soil</td></tr>
                                <tr><td>SS3</td><td class="text-center">5</td><td>Clayey/silty soil</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="d-flex">
                            <h5 class="panel-title">Slope Angle | <b><i>&alpha;Rating</i></b></h5>
                            <button class="border-none bg-none p-0 panel-toggler" data-toggle="tooltip" title="Toggle show/hide"><i class="fa fa-expand" aria-hidden="true" class="panel-toggler"></i></button>
                        </div>
                        <hr>
                        <table class="table" is_hidden="false">
                            <thead>
                                <tr>
                                    <th>Value</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>100</td><td>Slope angle greater than 75°</td></tr>
                                <tr><td>32</td><td>Slope angle greater than 60° but less than or equal to 75°</td></tr>
                                <tr><td>17</td><td>Slope angle greater than 45° but less than or equal to 60°</td></tr>
                                <tr><td>10</td><td>Slope angle greater than 30° but less than or equal to 45°</td></tr>
                                <tr><td>5</td><td>Slope angle greater than 15° but less than or equal to 30°</td></tr>
                                <tr><td>2</td><td>Slope angle less than or equal to 15°</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="d-flex">
                            <h5 class="panel-title">Vegetation | <b><i>vF</i></b></h5>
                            <button class="border-none bg-none p-0 panel-toggler" data-toggle="tooltip" title="Toggle show/hide"><i class="fa fa-expand" aria-hidden="true" class="panel-toggler"></i></button>
                        </div>
                        <hr>
                        <table class="table" is_hidden="false">
                            <thead>
                                <tr>
                                    <th>Value</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>1.0</td><td>No vegetation</td></tr>
                                <tr><td>1.1</td><td>Predominantly grass or vegetation with shallow roots</td></tr>
                                <tr><td>1.2</td><td>Coconut, bamboo or vegetation with moderately deep roots</td></tr>
                                <tr><td>1.5</td><td>Dense forests with trees of the same specie having age less than or equal to 20 years</td></tr>
                                <tr><td>2.0</td><td>Dense and mixed forests with trees having age less than or equal to 20 years or; Dense forests with pine trees having ages of more than 20 years</td></tr>
                                <tr><td>2.5</td><td>Dense and mixed forests with trees having ages of more than 20 years</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="d-flex">
                            <h5 class="panel-title">Frequency of failure | <b><i>fF</i></b></h5>
                            <button class="border-none bg-none p-0 panel-toggler" data-toggle="tooltip" title="Toggle show/hide"><i class="fa fa-expand" aria-hidden="true" class="panel-toggler"></i></button>
                        </div>
                        <hr>
                        <table class="table" is_hidden="false">
                            <thead>
                                <tr>
                                    <th>Value</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>0.5</td><td>Once a year or more than once a year</td></tr>
                                <tr><td>0.7</td><td>Presence of past failure, but occurrence not yearly</td></tr>
                                <tr><td>0.7</td><td>Presence of tensile cracks in ground</td></tr>
                                <tr><td>0.7</td><td>If with retaining wall, wall is deformed</td></tr>
                                <tr><td>1.2</td><td>None</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="d-flex">
                            <h5 class="panel-title">Presence of spring | <b><i>sRed</i></b></h5>
                            <button class="border-none bg-none p-0 panel-toggler" data-toggle="tooltip" title="Toggle show/hide"><i class="fa fa-expand" aria-hidden="true" class="panel-toggler"></i></button>
                        </div>
                        <hr>
                        <table class="table" is_hidden="false">
                            <thead>
                                <tr>
                                    <th>Value</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>2</td><td>Year-long</td></tr>
                                <tr><td>1</td><td>Only during rainy season</td></tr>
                                <tr><td>0</td><td>No flow/spring</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="d-flex">
                            <h5 class="panel-title">Condition of drainage/canal/culvert | <b><i>dRed</i></b></h5>
                            <button class="border-none bg-none p-0 panel-toggler" data-toggle="tooltip" title="Toggle show/hide"><i class="fa fa-expand" aria-hidden="true" class="panel-toggler"></i></button>
                        </div>
                        <hr>
                        <table class="table" is_hidden="false">
                            <thead>
                                <tr>
                                    <th>Value</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>2</td><td>No drainage system</td></tr>
                                <tr><td>2</td><td>Totally clogged, filled with debris</td></tr>
                                <tr><td>1</td><td>Partially clogged or overflows during heavy rains</td></tr>
                                <tr><td>1</td><td>Water leaks into the slope</td></tr>
                                <tr><td>0</td><td>Good working condition</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="d-flex">
                            <h5 class="panel-title">Amount of rainfall (mm) in 24 hours | <b><i>Rain</i></b></h5>
                            <button class="border-none bg-none p-0 panel-toggler" data-toggle="tooltip" title="Toggle show/hide"><i class="fa fa-expand" aria-hidden="true" class="panel-toggler"></i></button>
                        </div>
                        <hr>
                        <table class="table" is_hidden="false">
                            <thead>
                                <tr>
                                    <th>Value</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>0</td><td>50mm or less</td></tr>
                                <tr><td>2</td><td>More than 50mm but less than 100mm</td></tr>
                                <tr><td>3</td><td>More than 100mm but less than 200mm</td></tr>
                                <tr><td>4</td><td>More than 200mm</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="d-flex">
                            <h5 class="panel-title">Land use | <b><i>lF</i></b></h5>
                            <button class="border-none bg-none p-0 panel-toggler" data-toggle="tooltip" title="Toggle show/hide"><i class="fa fa-expand" aria-hidden="true" class="panel-toggler"></i></button>
                        </div>
                        <hr>
                        <table class="table" is_hidden="false">
                            <thead>
                                <tr>
                                    <th>Value</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>1.4</td><td>Dense residential area (with closely spaced structures &#60;5m)</td></tr>
                                <tr><td>1.4</td><td>Commercial with building/s having 2 storeys or more</td></tr>
                                <tr><td>1.25</td><td>Residential area with buildings having 2 storeys spaced at &#8805;5m</td></tr>
                                <tr><td>1.4</td><td>Road/highway with heavy traffic (1 truck or more every 10mins)</td></tr>
                                <tr><td>1.25</td><td>Road/highway with light traffic (less than 1 truck every 10mins)</td></tr>
                                <tr><td>1.0</td><td>Agricultural area, grasslands and bushlands</td></tr>
                                <tr><td>1.0</td><td>Forest</td></tr>
                                <tr><td>1.0</td><td>Uninhabited and no vegetation</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="d-flex">
                            <h5 class="panel-title">Factor of safety | <b><i>Fs</i></b></h5>
                            <button class="border-none bg-none p-0 panel-toggler" data-toggle="tooltip" title="Toggle show/hide"><i class="fa fa-expand" aria-hidden="true"></i></button>
                        </div>
                        <hr>
                        <table class="table" is_hidden="false">
                            <thead>
                                <tr>
                                    <th>Value</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td><i>Fs</i> &#8805; 1.2</td><td>Stable</td></tr>
                                <tr><td>1 &#8804; <i>Fs</i> < 1.2</td><td>Marginally stable</td></tr>
                                <tr><td>0.7 &#8804; <i>Fs</i> < 1</td><td>Susceptible</td></tr>
                                <tr><td><i>Fs</i> < 0.7</td><td>Highly susceptible</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div id="clears-edit-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit CLEARS Data <i class="fa fa-info-circle" text-align="right" aria-hidden="true"  data-toggle="tooltip"  title="Hover over the choices to view descriptions"></i></h4>
            </div>
            <div class="modal-body">
                <div class="form-group px-3">
                    <form id="clears-edit-form">
                        <label for="form-c-date">Survey date</label>
                        <input type="date" class="form-control" id="form-c-date">
                        @if (Auth::user()->role_id <=3)
                            <label for="form-c-m-id">Municipality</label>
                            <select class="form-control" id="form-c-m-id">
                                @foreach ($munis as $m)
                                    <option value="{{$m->id}}">{{$m->name}}</option>
                                @endforeach
                            </select>
                        @endif
                        <label for="form-c-material">Material | <i>sRating</i></label>
                        <select class="form-control" id="form-c-material">
                            <option value="HR1" data-toggle="tooltip" sr = "100" title="sR = HR1: 100">Massive and intact hard rock</option>
                            <option value="HR2" data-toggle="tooltip" sr = "45" title="sR = HR2: 45">Blocky, well-interlocked hard rock, rock mass consisting mostly of cubical blocks</option>
                            <option value="HR3" data-toggle="tooltip" sr = "25" title="sR = HR3: 25">Very blocky and fractured hard rock (disturbed with multifaceted angular blocks formed by 4 or more discontinuity sets)</option>
                            <option value="HR4" data-toggle="tooltip" sr = "13" title="sR = HR4: 13">Disintegrated, unstable rocks and boulders, protruding rock fragments</option>
                            <option value="SR1" data-toggle="tooltip" sr = "30" title="sR = SR1: 30">Massive and intact soft rock</option>
                            <option value="SR2" data-toggle="tooltip" sr = "15" title="sR = SR2: 15">Very blocky and fractured soft rock</option>
                            <option value="HS1" data-toggle="tooltip" sr = "25" title="sR = HS1: 25">Stiff, cemented and dense gravelly, sandy, silty and clayey soils</option>
                            <option value="SS1" data-toggle="tooltip" sr = "10" title="sR = SS1: 10">Gravelly soil</option>
                            <option value="SS2" data-toggle="tooltip" sr = "8" title="sR = SS2: 8">Sandy soil</option>
                            <option value="SS3" data-toggle="tooltip" sr = "5" title="sR = SS3: 5">Clayey/silty soil</option>
                        </select>
                        <label for="form-c-vegetation">Vegetation | <i>vF</i></label>
                        <select class="form-control" id="form-c-vegetation">
                            <option value="1.0" data-toggle="tooltip" title="vf = 1.0">No vegetation</option>
                            <option value="1.1" data-toggle="tooltip" title="vf = 1.1">Predominantly grass or vegetation with shallow roots</option>
                            <option value="1.2" data-toggle="tooltip" title="vf = 1.2">Coconut, bamboo or vegetation with moderately deep roots</option>
                            <option value="1.5" data-toggle="tooltip" title="vf = 1.5">Dense forests with trees of the same specie having age less than or equal to 20 years</option>
                            <option value="2.0" data-toggle="tooltip" title="vf = 2.0">Dense and mixed forests with trees having age less than or equal to 20 years or; Dense forests with pine trees having ages of more than 20 years</option>
                            <option value="2.5" data-toggle="tooltip" title="vf = 2.5">Dense and mixed forests with trees having ages of more than 20 years</option>
                        </select>
                        <label for="form-c-freq">Failure Frequency | <i>fF</i></label>
                        <select class="form-control" id="form-c-freq">
                            <option value="1" fF = "0.5" title="fF = 0.5">Once a year or more than once a year</option>
                            <option value="2" fF = "0.7" title="fF = 0.7">Presence of past failure, but occurrence not yearly</option>
                            <option value="3" fF = "0.7" title="fF = 0.7">Presence of tensile cracks in ground</option>
                            <option value="4" fF = "0.7" title="fF = 0.7">If with retaining wall, wall is deformed</option>
                            <option value="5" fF = "1.2" title="fF = 1.2">None</option>
                        </select>
                        <br>
                        <input type="radio" value="1" name="reds" id="reds-1"><label for="reds-1">Spring and Canal Data</label>&nbsp&nbsp
                        <input type="radio" value="2" name="reds" id="reds-2"><label for="reds-2">Rain Data</label><br>
                        <div id="red-inputs" style="display: none">
                            <label for="form-c-spring">Presence of Springs | <i>sRed</i></label>
                            <select class="form-control" id="form-c-spring">
                                <option value="2" title="sRed = 2">Year-long</option>
                                <option value="1" title="sRed = 1">Only during rainy season</option>
                                <option value="0" title="sRed = 0">No flow/spring</option>
                            </select>
                            <label for="form-c-canal">Drainage Condition | <i>dRed</i></label>
                            <select class="form-control" id="form-c-canal">
                                <option value="1" dred="2" title="dRed = 2">No drainage system</option>
                                <option value="2" dred="2" title="dRed = 2">Totally clogged, filled with debris</option>
                                <option value="3" dred="1" title="dRed = 1">Partially clogged or overflows during heavy rains</option>
                                <option value="4" dred="1" title="dRed = 1">Water leaks into the slope</option>
                                <option value="5" dred="0" title="dRed = 0">Good working condition</option>
                            </select>
                        </div>
                        <div id="rain-input" style="display: none">
                            <label for="form-c-rain">Rain | <i>Rain</i></label>
                            <select class="form-control" id="form-c-rain">
                                <option value="0" title="Rain = 0">50mm or less</option>
                                <option value="2" title="Rain = 2">More than 50mm but less than 100mm</option>
                                <option value="3" title="Rain = 3">More than 100mm but less than 200mm</option>
                                <option value="4" title="Rain = 4">More than 200mm</option>
                            </select>
                        </div>
                        
                        <label for="form-c-land">Land Use | <i>lF</i></label>
                        <select class="form-control" id="form-c-land">
                            <option lf="1.4" title="lF = 1.4" value="1">Dense residential area (with closely spaced structures &#60;5m)</option>
                            <option lf="1.4" title="lF = 1.4" value="2">Commercial with building/s having 2 storeys or more</option>
                            <option lf="1.25" title="lF = 1.25" value="3">Residential area with buildings having 2 storeys spaced at &#8805;5m</option>
                            <option lf="1.4" title="lF = 1.4" value="4">Road/highway with heavy traffic (1 truck or more every 10mins)</option>
                            <option lf="1.25" title="lF = 1.25" value="5">Road/highway with light traffic (less than 1 truck every 10mins)</option>
                            <option lf="1.0" title="lF = 1.0" value="6">Agricultural area, grasslands and bushlands</option>
                            <option lf="1.0" title="lF = 1.0" value="7">Forest</option>
                            <option lf="1.0" title="lF = 1.0" value="8">Uninhabited and no vegetation</option>
                        </select>
                        <label for="form-c-slope">Slope | <i>&alpha;Rating</i></label>
                        <select class="form-control" id="form-c-slope">
                            <option title="&alpha;Rating = 100" value="100">Slope angle greater than 75°</option>
                            <option title="&alpha;Rating = 32" value="32">Slope angle greater than 60° but less than or equal to 75°</option>
                            <option title="&alpha;Rating = 17" value="17">Slope angle greater than 45° but less than or equal to 60°</option>
                            <option title="&alpha;Rating = 10" value="10">Slope angle greater than 30° but less than or equal to 45°</option>
                            <option title="&alpha;Rating = 5" value="5">Slope angle greater than 15° but less than or equal to 30°</option>
                            <option title="&alpha;Rating = 2" value="2">Slope angle less than or equal to 15°</option>
                        </select>
                        <label>Stability | <i>Fs</i></label>
                        <input type="text" class="form-control" readonly disabled id="form-c-stability">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="clears-delete-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete CLEARS Data</h4>
            </div>
            <div class="modal-body">
                wow
            </div>
        </div>
    </div>
</div>
@section('page-js-files')
<script type="text/javascript" src="{!! url('assets/dropzone/dropzone.js') !!}"></script>
<script type="text/javascript">
    var baseUrl = "{{ url('/') }}";
    var token = "{{ Session::token() }}";
    var images = []; 
    var counter = 0;
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dZUpload", { 
        url: "uploadfireimages",
        params: {
            _token: token
        },
        init: function() {
            this.on("error", function(file) {console.log("ooopppssss");}),
            this.on("success", function(file, response) { 
                var imagefile = baseUrl + '/files/1/Fire Images/'+file["name"] +'-@';
                images[counter] = imagefile;
                document.getElementById("fireimages").value = images;
                counter++;
            })
        }
    });
    Dropzone.options.myAwesomeDropzone = {
        paramName: "file", 
        maxFilesize: 2, 
        addRemoveLinks: true,    
    };
    CKEDITOR.replace( 'piw-textarea', {
        filebrowserImageBrowseUrl: '{{ asset("laravel-filemanager?type=Images") }}',
        filebrowserImageUploadUrl: '{{ asset("laravel-filemanager/upload?type=Images&_token=") }}{{csrf_token()}}',
        filebrowserBrowseUrl: '{{ asset("laravel-filemanager?type=Files") }}',
        filebrowserUploadUrl: '{{ asset("laravel-filemanager/upload?type=Files&_token=") }}{{csrf_token()}}'
    });
</script>
@endsection
<script>
    $(document).on('click','.panel-toggler',function(e){
        e.stopImmediatePropagation();
        $(e.target).closest('.panel-body').find('.table').toggle();
    })
    .on('click','#master-panel-toggler',function(){
        let hidden = $(this).attr("is_hidden");
        if(hidden == "true"){
            $('#clear-fluid .panel .table').attr('is_hidden','false').show();
            $(this).text('Hide all').attr('is_hidden','false')
        }else{
            $('#clear-fluid .panel .table').attr('is_hidden','true').hide();
            $(this).text("Show all").attr('is_hidden','true')
        }
    })
    .on('click','#clears-table tbody tr',function(e){
        if($(e.target).is('button') || $(e.target).is('i')){e.preventDefault(); return false;}
        if($(e.target).not('button') && $(e.target).not('i')){
            let lat = parseFloat($(e.currentTarget).attr('lat'));
            let long = parseFloat($(e.currentTarget).attr('long'));
            $('#addcoords').css('height','500px')
            var map = new google.maps.Map(document.getElementById('addcoords'),{
                center:{
                    lat:lat,
                    lng:long
                },
                zoom:13
            });
            var marker = new google.maps.Marker({
                position:{lat:lat,lng:long},
                map:map,
                draggable:false
            });
            window.location='#h4mapview';
        }
        
    })
    .on('click','#clears-e-btn',function(e){
        e.preventImmedatePropagation;
        $('[data-toggle="tooltip"]').tooltip();
        let row = $(e.currentTarget).closest('tr');
        let date = row.find('.c-date').text();
        let muni = row.find('.c-m-id').attr('m_id');
        let material = row.find('.c-material').attr('mid');
        let veg = row.find('.c-vegetation').text();
        let freq = row.find('.c-freq').attr('fid');
        let spring = row.find('.c-spring').text();
        let canal = row.find('.c-canal').text();
        let rain = row.find('.c-rain').text();
        let land = row.find('.c-land').attr('lid');
        let slope = row.find('.c-slope').text();
        $('#clears-edit-form #form-c-date').val(date);
        $('#clears-edit-form #form-c-m-id').val(muni);
        $('#clears-edit-form #form-c-material').val(material);
        $('#clears-edit-form #form-c-vegetation').val(veg);
        $('#clears-edit-form #form-c-freq').val(freq);
        $('#clears-edit-form #form-c-spring').val(spring);
        $('#clears-edit-form #form-c-canal').val(canal);
        $('#clears-edit-form #form-c-rain').val(rain);
        $('#clears-edit-form #form-c-land').val(land);
        $('#clears-edit-form #form-c-slope').val(slope);
        let sr = parseFloat($("#form-c-material option:selected").attr('sr'));
        let fF = parseFloat($("#form-c-freq option:selected").attr('fF'));
        let lf = parseFloat($("#form-c-land option:selected").attr('lf'));
        let corrosion = sr;
        if(rain != "" && rain != null){
            $('#reds-2').prop('checked',true);
            $('#reds-1').prop('checked',false);
            $('#rain-input').show();
            $('#red-inputs').hide();
            corrosion -= parseInt(rain);
        }else{
            $('#reds-1').prop('checked',true);
            $('#reds-2').prop('checked',false);
            $('#rain-input').hide();
            $('#red-inputs').show();
            let dred = parseInt($("#form-c-canal option:selected").attr('dred'));
            let sred = parseInt(spring);
            corrosion -= dred;
            corrosion -= sred;
        }
        let Fs = ((parseFloat(veg) * fF * corrosion) / (parseInt(slope) * lf)).toFixed(2);
        $('#form-c-stability').val(Fs);
    })
</script>