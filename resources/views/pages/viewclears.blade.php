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
    fieldset {
        display: block !important;
        margin-inline-start: 2px !important;
        margin-inline-end: 2px !important;
        padding-block-start: 0.35em !important;
        padding-inline-start: 0.75em !important;
        padding-inline-end: 0.75em !important;
        padding-block-end: 0.625em !important;
        min-inline-size: min-content !important;
        border-width: 2px !important;
        border-style: groove !important;
        border-color: rgb(192, 192, 192) !important;
        border-image: initial !important;
    }
    
    legend{    
        display: block !important;
        padding-inline-start: 2px !important;
        padding-inline-end: 2px !important;
        border-width: initial !important;
        border-style: none !important;
        border-color: initial !important;
        border-image: initial !important;
        font-size: 16px !important;
        width: unset !important;
        margin-bottom: 0 !important;
    }
    .modal { overflow-y: auto; } 
    #preview-overlay{background-color:rgba(0,0,0,0.4); opacity: 0; transition: all 0.2s;}
    #preview-overlay:hover{opacity: 1;}
    #report-view-div .well{font-family: Menlo,Monaco,Consolas,"Courier New",monospace;}
    #c-print-paper{
        width: 21cm;
        overflow: hidden;
        height: 29.7cm;
        font-size: 10.5pt;}
    @media print{
        @page { 
            size: A4;  margin: 0.5in; 
        }
    }
</style>
<div id="page-wrapper">
    <div class="container-fluid" id="clear-fluid">
        <div class="wrap">
            <div class="dashboardtitle"><h1 id="h4mapview">CLEARS</h1></div>
            <div class="lead">RAIN-INDUCED LANDSLIDE SUSCEPTIBILITY</div>
            <h4>Map View</h4>
            <div class="row">
                <div class="col-sm-6">
                    <div id="addcoords" class="w-100"><span class="ms-3">Click on a report below to view its location</span></div>
                </div>
                <div class="col-sm-6">
                    <img id="preview-image" class="w-100">
                </div>
            </div>
            
            
            <div class="mt-5" id="reports-list-div">{{-- TABLE --}}
                <h4>Reports List</h4>
                <div id="alert-update-1" style="display: none" class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class=" alert-close close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Update successful.
                </div>
                <div id="alert-update-0" style="display: none" class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close alert-close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Update failed.
                </div>
                <div id="alert-delete-1" style="display: none" class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close alert-close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Report deleted.
                </div>
                
                <div class="d-flex">
                    <span class="glyphicon glyphicon-filter" style="line-height: 34px"></span><span style="font-size: 16px; line-height: 34px">Filter: </span>
                    <select id="upload-filter" class="form-control" style="max-width: 200px">
                        <option value="1" selected>All Reports</option>
                        <option value="2">My Reports</option>
                    </select>
                
                    <select id="fs-filter" class="form-control" style="max-width: 200px">
                        <option value="1" selected>All Fs</option>
                        <option value="2">Stable</option>
                        <option value="3">Marginally Stable</option>
                        <option value="4">Susceptible</option>
                        <option value="5">Highly Susceptible</option>
                    </select>

                    <button class="btn btn-sm btn-primary" id="clears-a-button" style="margin-left:auto" data-toggle="modal" data-target="#clears-add-modal">Add Report</button>
                </div>
                <div id="alert-danger" style="display: none" class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close alert-close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <span id="content"></span>
                </div>
                <div id="the_table">
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
                                {{-- <th class="text-center">#</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($res as $r)
                            <tr long = "{{$r->survey_longitude}}" lat = "{{$r->survey_latitude}}" report-id="{{$r->id}}" upload-date = "<?php echo date('Y-m-d',strtotime($r->created_at)); ?>" image="{{$r->image}}">
                                <td class="c-date-slot"><span class="c-date">{{date('Y-m-d',strtotime($r->survey_date))}}</span><br>
                                    <span class="defsp spactions">
                                        <div class="inneractions">
                                            <a href="#" class="clears-v-btn" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a> | 
                                            @if(Auth::user()->id == $r->user_id)
                                            <a href="#" {{-- class="clears-e-btn" --}} title="Edit" data-toggle="modal" data-target="#clears-edit-modal"><i class="fa fa-pencil clears-e-btn" aria-hidden="true"></i></a> | 
                                            <a class="deletepost clears-d-btn" href="#" data-toggle="modal" data-target="#clears-delete-modal" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            @endif
                                            | 
                                            <a href="#report-view-div" class="c-report" title="Report"><i class="fa fa-file-o" aria-hidden="true"></i></a>
                                        </div>								
                                    </span>
                                </td>
                                <td class="c-m-id" m_id="{{$r->municipality_id}}">{{$r->municipality->name}}</td>
                                <td class="c-p-id">{{$r->province->name == "Mountain Province" ? "Mt. Province":$r->province->name }}</td>
                                <td class="c-uploader">{{$r->user->first_name." ".$r->user->last_name}}</td>
                                <td class="text-center c-material" data-toggle="tooltip" mid = "{{$r->material_id}}" title="{{$r->slopeMaterial($r->material_id)}}">{{$r->sRating}}</td>
                                <td class="text-center c-vegetation" data-toggle="tooltip" title="{{$r->vegetation($r->vFactor)}}">{{$r->vFactor}}</td>
                                <td class="text-center c-freq" data-toggle="tooltip" title="{{$r->frequency($r->frequency_id)}}" fid = {{$r->frequency_id}}>{{$r->fFactor}}</td>
                                <td class="text-center c-spring" data-toggle="tooltip" title="{{$r->springs($r->sRed)}}">{{$r->sRed}}</td>
                                <td class="text-center c-canal" did="{{$r->drain_id}}" data-toggle="tooltip" title="{{$r->canals($r->dRed)}}">{{$r->dRed}}</td>
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
                            </tr>                        
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-5 d-none" id="report-view-div">{{-- REPORT --}}
                <h4>Generated Report</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="well text-left">
                            Location: <span class="r-municipality"></span>, <span class="r-province"></span><br>
                            Survey Date: <span class="r-date"></span><br>
                            Latitude: <span class="r-lat"></span><br>
                            Longitude: <span class="r-lon"></span><br>
                            Slope Material: <span class="r-sr"></span><br>
                            Vegetation: <span class="r-vf"></span><br>
                            Frequency of slope failure: <span class="r-ff"></span><br>
                            Presence of springs: <span class="r-sred"></span><br>
                            Condition of drainage/canal/culvert: <span class="r-dred"></span><br>
                            Amount of rainfall (mm) in 24 hours: <span class="r-rain"></span><br>
                            Land use: <span class="r-lf"></span><br>
                            Slope Rating: <span class="r-slope"></span><br>
                            Factor of Stability: <span class="r-fs"></span><br>
                            The slope is <span class="r-fs-desc"></span><br>
                            This report is submitted by <span class="r-name"></span> on <span class="r-upload-date"></span>.
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-sm btn-primary" id="r-print-report">Print Report</button>
                        <button class="btn btn-sm btn-secondary" id="r-view-map" >View Map</button>
                        <button class="btn btn-sm btn-secondary" id="r-view-table">Back to list</button>
                    </div>
                </div>
                <div class="d-none">
                    <iframe name= "print_frame" frameborder="0"></iframe>
                    <div id="c-print-paper">
                        <style>
                            @media print{
                                @page { 
                                    size: A4;  margin: 0.5in; 
                                }
                                body{
                                    font-size: 10.5pt;font-family: 'Times New Roman', Times, serif;
                                }
                            }
                        </style>
                        <div style="text-align: center">
                            <span style="font-size: 20pt">RAIN-INDUCED LANDSLIDE SUSCEPTIBILITY REPORT</span><br>
                            <span style="font-size: 14pt">DOST-CAR | DRRMIS</span><br><br>
                        </div>
                        <span style="font-size: 13pt">Report Details</span><br>
                        <div style="border:1px solid rgb(74, 74, 74); width: 100%; "></div>
                        <br>
                        <b>Location:</b> <span class="r-municipality"></span>, <span class="r-province"></span><br>
                        <b>Survey Date:</b> <span class="r-date"></span><br>
                        <b>Latitude:</b> <span class="r-lat"></span><br>
                        <b>Longitude:</b> <span class="r-lon"></span><br>
                        <b>Slope Material:</b> <span class="r-sr"></span><br>
                        <b>Vegetation:</b> <span class="r-vf"></span><br>
                        <b>Frequency of slope failure:</b> <span class="r-ff"></span><br>
                        <b>Presence of springs:</b> <span class="r-sred"></span><br>
                        <b>Condition of drainage/canal/culvert:</b> <span class="r-dred"></span><br>
                        <b>Amount of rainfall (mm) in 24 hours:</b> <span class="r-rain"></span><br>
                        <b>Land use:</b> <span class="r-lf"></span><br>
                        <b>Slope Rating:</b> <span class="r-slope"></span><br>
                        <b>Factor of Stability:</b> <span class="r-fs"></span><br>
                        The slope is <span class="r-fs-desc"></span><br>
                        This report is submitted by <span class="r-name"></span> on <span class="r-upload-date"></span>.
                        <br><br><br>
                        <span style="font-size: 9pt"><i>Report generated by drrmis.dostcar.ph on <span class="c-current-date">{{date('F d, Y')}}</span></i></span>
                    </div>
                </div>
                
            </div>
            <div class="strong d-flex mt-3">{{-- REFERENCES --}}
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
                        <input type="hidden" name="clears_id" id="form-c-id">
                        <fieldset>
                            <legend>Location and Date</legend>
                            <label for="form-c-date">Survey date</label>
                            <input type="date" class="form-control" id="form-c-date" name="survey_date">
                            <label for="form-c-m-id">Municipality</label>
                            @if (Auth::user()->role_id <=3)
                                <select class="form-control" id="form-c-m-id" name="municipality_id">
                                    @foreach ($munis as $m)
                                        <option value="{{$m->id}}">{{$m->name}}</option>
                                    @endforeach
                                </select>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="form-c-slat">Latitude</label>
                                        <input type="number" step="0.000000000000001" max="90" min="-90" class="form-control" name="survey_latitude" id="form-c-slat">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="form-c-slon">Longitude</label>
                                        <input type="number" step="0.000000000000001" max="180" min="-180" class="form-control" name="survey_longitude" id="form-c-slon">
                                    </div>
                                    <div class="col-md-4">
                                        <label style="color: white">white</label>
                                        <button class="btn btn-primary" id="show-coord-map" data-toggle="modal" data-target="#clears-coordinate-modal" type="button">Select from map</button>                                        
                                    </div>
                                </div>

                            @else
                                <select class="form-control" id="form-c-m-id" name="municipality_id" readonly>
                                    @foreach ($munis as $m)
                                        <option value="{{$m->id}}">{{$m->name}}</option>
                                    @endforeach
                                </select>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="form-c-slat">Latitude</label>
                                        <input type="text" readonly class="form-control" name="survey_latitude" id="form-c-slat">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="form-c-slon">Longitude</label>
                                        <input type="text" readonly class="form-control" name="survey_longitude" id="form-c-slon">
                                    </div>
                                </div>
                            @endif
                            <label>Site Image</label>
                            <div class="d-flex d-none" id="form-image-holder">
                                <input type="file" accept=".jpg,.jpeg,.png" name="image" id="form-c-image" class="form-control" >
                                <button id="" type="button" class="btn btn-sm btn-secondary form-c-res-image-btn" default="">Reset Image</button>
                            </div>
                            
                            <br>
                            <div id="c-image-preview" style="width: 100%; height:300px; background-size: cover; background-position:center">
                                <div id="preview-overlay" class="pos-rel w-100 h-100">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="pos-rel w-100 h-100">
                                                <label for="form-c-image" class="btn btn-sm btn-primary pos-a r0 y-centered" style="color:white; ">
                                                    Change Image
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="pos-rel w-100 h-100">
                                                <button type="button" class="btn btn-sm btn-secondary pos-a centered form-c-res-image-btn" default="">Reset Image</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="pos-rel w-100 h-100">
                                                <button id="form-c-del-image-btn" type="button" class="btn btn-sm btn-danger pos-a y-centered" style="color:white;">Delete Image</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            <input type="hidden" name="del-image" id="form-c-del-image">
                        </fieldset>
                        <fieldset class="mt-3">
                            <legend>Numerator Factors</legend>
                            <label for="form-c-material">Material | <i>sRating</i></label>
                            <select class="form-control" id="form-c-material" name="material_id">
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
                            <input type="hidden" id="form-c-sRating" name="sRating">
                            <label for="form-c-vegetation">Vegetation | <i>vF</i></label>
                            <select class="form-control" id="form-c-vegetation" name="vFactor">
                                <option value="1.0" data-toggle="tooltip" title="vf = 1.0">No vegetation</option>
                                <option value="1.1" data-toggle="tooltip" title="vf = 1.1">Predominantly grass or vegetation with shallow roots</option>
                                <option value="1.2" data-toggle="tooltip" title="vf = 1.2">Coconut, bamboo or vegetation with moderately deep roots</option>
                                <option value="1.5" data-toggle="tooltip" title="vf = 1.5">Dense forests with trees of the same specie having age less than or equal to 20 years</option>
                                <option value="2.0" data-toggle="tooltip" title="vf = 2.0">Dense and mixed forests with trees having age less than or equal to 20 years or; Dense forests with pine trees having ages of more than 20 years</option>
                                <option value="2.5" data-toggle="tooltip" title="vf = 2.5">Dense and mixed forests with trees having ages of more than 20 years</option>
                            </select>
                            <label for="form-c-freq">Failure Frequency | <i>fF</i></label>
                            <select class="form-control" id="form-c-freq" name="frequency_id">
                                <option value="1" fF = "0.5" title="fF = 0.5">Once a year or more than once a year</option>
                                <option value="2" fF = "0.7" title="fF = 0.7">Presence of past failure, but occurrence not yearly</option>
                                <option value="3" fF = "0.7" title="fF = 0.7">Presence of tensile cracks in ground</option>
                                <option value="4" fF = "0.7" title="fF = 0.7">If with retaining wall, wall is deformed</option>
                                <option value="5" fF = "1.2" title="fF = 1.2">None</option>
                            </select>
                            <input type="hidden" name="fFactor" id="form-c-fF">
                            <br>
                            <input type="radio" value="1" name="reds" id="reds-1"><label for="reds-1">Spring and Canal Data</label>&nbsp&nbsp
                            <input type="radio" value="2" name="reds" id="reds-2"><label for="reds-2">Rain Data</label><br>
                            <div id="red-inputs" style="display: none">
                                <label for="form-c-spring">Presence of Springs | <i>sRed</i></label>
                                <select class="form-control" id="form-c-spring" name="sRed">
                                    <option value="-1" id="form-c-spring-empty">-Select one-</option>
                                    <option value="2" title="sRed = 2">Year-long</option>
                                    <option value="1" title="sRed = 1">Only during rainy season</option>
                                    <option value="0" title="sRed = 0">No flow/spring</option>
                                </select>
                                <label for="form-c-canal">Drainage Condition | <i>dRed</i></label>
                                <select class="form-control" id="form-c-canal" name="drain_id">
                                    <option value="-1" id="form-c-canal-empty">-Select one-</option>
                                    <option value="1" dred="2" title="dRed = 2">No drainage system</option>
                                    <option value="2" dred="2" title="dRed = 2">Totally clogged, filled with debris</option>
                                    <option value="3" dred="1" title="dRed = 1">Partially clogged or overflows during heavy rains</option>
                                    <option value="4" dred="1" title="dRed = 1">Water leaks into the slope</option>
                                    <option value="5" dred="0" title="dRed = 0">Good working condition</option>
                                </select>
                                <input type="hidden" name="dRed" id="form-c-dRed">
                            </div>
                            <div id="rain-input" style="display: none">
                                <label for="form-c-rain">Rain | <i>Rain</i></label>
                                <select class="form-control" id="form-c-rain" name="rain">
                                    <option value="-1" id="form-c-rain-empty">-Select one-</option>
                                    <option value="0" title="Rain = 0">50mm or less</option>
                                    <option value="2" title="Rain = 2">More than 50mm but less than 100mm</option>
                                    <option value="3" title="Rain = 3">More than 100mm but less than 200mm</option>
                                    <option value="4" title="Rain = 4">More than 200mm</option>
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="mt-3">
                            <legend>Denominator Factors</legend>
                            <label for="form-c-land">Land Use | <i>lF</i></label>
                            <select class="form-control" id="form-c-land" name="land_id">
                                <option lf="1.4" title="lF = 1.4" value="1">Dense residential area (with closely spaced structures &#60;5m)</option>
                                <option lf="1.4" title="lF = 1.4" value="2">Commercial with building/s having 2 storeys or more</option>
                                <option lf="1.25" title="lF = 1.25" value="3">Residential area with buildings having 2 storeys spaced at &#8805;5m</option>
                                <option lf="1.4" title="lF = 1.4" value="4">Road/highway with heavy traffic (1 truck or more every 10mins)</option>
                                <option lf="1.25" title="lF = 1.25" value="5">Road/highway with light traffic (less than 1 truck every 10mins)</option>
                                <option lf="1.0" title="lF = 1.0" value="6">Agricultural area, grasslands and bushlands</option>
                                <option lf="1.0" title="lF = 1.0" value="7">Forest</option>
                                <option lf="1.0" title="lF = 1.0" value="8">Uninhabited and no vegetation</option>
                            </select>
                            <input type="hidden" name="lFactor" id="form-c-lF">
                            <label for="form-c-slope">Slope | <i>&alpha;Rating</i></label>
                            <select class="form-control" id="form-c-slope"  name="alphaRating">
                                <option title="&alpha;Rating = 100" value="100">Slope angle greater than 75°</option>
                                <option title="&alpha;Rating = 32" value="32">Slope angle greater than 60° but less than or equal to 75°</option>
                                <option title="&alpha;Rating = 17" value="17">Slope angle greater than 45° but less than or equal to 60°</option>
                                <option title="&alpha;Rating = 10" value="10">Slope angle greater than 30° but less than or equal to 45°</option>
                                <option title="&alpha;Rating = 5" value="5">Slope angle greater than 15° but less than or equal to 30°</option>
                                <option title="&alpha;Rating = 2" value="2">Slope angle less than or equal to 15°</option>
                            </select>
                        </fieldset>
                        <fieldset class="mt-3">
                            <legend>Computed Factor of Stability</legend>
                            <label>Stability | <i>Fs</i></label>
                            <input type="text" class="form-control mb-3 " name="Fs" readonly id="form-c-stability">
                        </fieldset>
                        
                        
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit" form="clears-edit-form">Update</button>
            </div>
        </div>
    </div>
</div>
<div id="clears-add-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add CLEARS Report <i class="fa fa-info-circle" text-align="right" aria-hidden="true"  data-toggle="tooltip"  title="Hover over the choices to view descriptions"></i></h4>
            </div>
            <div class="modal-body">
                <div class="form-group px-3">
                    <form id="clears-add-form">
                        <fieldset>
                            <legend>Location and Date</legend>
                            <label for="form-ac-date">Survey date</label>
                            <input type="date" class="form-control" id="form-ac-date" name="survey_date" required>
                            <label for="form-ac-m-id">Municipality</label>
                            @if (Auth::user()->role_id <=3)
                                <select class="form-control" id="form-ac-m-id" name="municipality_id">
                                    @foreach ($munis as $m)
                                        <option value="{{$m->id}}">{{$m->name}}</option>
                                    @endforeach
                                </select>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="form-ac-slat">Latitude</label>
                                        <input type="number" step="0.000000000000001" max="90" min="-90" class="form-control" name="survey_latitude" id="form-ac-slat" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="form-ac-slon">Longitude</label>
                                        <input type="number" step="0.000000000000001" max="180" min="-180" class="form-control" name="survey_longitude" id="form-ac-slon" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label style="color: white">white</label>
                                        <button class="btn btn-primary" id="show-coord-map2" data-toggle="modal" data-target="#clears-coordinate-modal2" type="button">Select from map</button>                                        
                                    </div>
                                </div>
                            @else
                                <select class="form-control" id="form-ac-m-id" name="municipality_id" readonly>
                                    @foreach ($munis as $m)
                                        <option value="{{$m->id}}">{{$m->name}}</option>
                                    @endforeach
                                </select>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="form-ac-slat">Latitude</label>
                                        <input type="text" readonly class="form-control" name="survey_latitude" id="form-ac-slat">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="form-ac-slon">Longitude</label>
                                        <input type="text" readonly class="form-control" name="survey_longitude" id="form-ac-slon">
                                    </div>
                                </div>
                            @endif
                            <label for="form-ac-image">Site image</label>
                            <input type="file" accept=".jpg,.jpeg,.png" name="image" class="form-control" id="form-ac-image"> 
                        </fieldset>

                        <fieldset class="mt-3">
                            <legend>Numerator Factors</legend>
                            <label for="form-ac-material">Material | <i>sRating</i></label>
                            <select class="form-control" id="form-ac-material" name="material_id">
                                <option value="HR1" data-toggle="tooltip" sr = "100" title="sR = HR1: 100" selected>Massive and intact hard rock</option>
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
                            <input type="hidden" id="form-ac-sRating" name="sRating" value="100">
                            <label for="form-ac-vegetation">Vegetation | <i>vF</i></label>
                            <select class="form-control" id="form-ac-vegetation" name="vFactor">
                                <option value="1.0" data-toggle="tooltip" title="vf = 1.0" selected>No vegetation</option>
                                <option value="1.1" data-toggle="tooltip" title="vf = 1.1">Predominantly grass or vegetation with shallow roots</option>
                                <option value="1.2" data-toggle="tooltip" title="vf = 1.2">Coconut, bamboo or vegetation with moderately deep roots</option>
                                <option value="1.5" data-toggle="tooltip" title="vf = 1.5">Dense forests with trees of the same specie having age less than or equal to 20 years</option>
                                <option value="2.0" data-toggle="tooltip" title="vf = 2.0">Dense and mixed forests with trees having age less than or equal to 20 years or; Dense forests with pine trees having ages of more than 20 years</option>
                                <option value="2.5" data-toggle="tooltip" title="vf = 2.5">Dense and mixed forests with trees having ages of more than 20 years</option>
                            </select>
                            <label for="form-ac-freq">Failure Frequency | <i>fF</i></label>
                            <select class="form-control" id="form-ac-freq" name="frequency_id">
                                <option value="1" fF = "0.5" title="fF = 0.5" selected>Once a year or more than once a year</option>
                                <option value="2" fF = "0.7" title="fF = 0.7">Presence of past failure, but occurrence not yearly</option>
                                <option value="3" fF = "0.7" title="fF = 0.7">Presence of tensile cracks in ground</option>
                                <option value="4" fF = "0.7" title="fF = 0.7">If with retaining wall, wall is deformed</option>
                                <option value="5" fF = "1.2" title="fF = 1.2">None</option>
                            </select>
                            <input type="hidden" name="fFactor" id="form-ac-fF" value="0.5">
                            <br>
                            <input type="radio" value="1" name="a-reds" id="a-reds-1" checked><label for="a-reds-1" >Spring and Canal Data</label>&nbsp&nbsp
                            <input type="radio" value="2" name="a-reds" id="a-reds-2"><label for="a-reds-2">Rain Data</label><br>
                            <div id="a-red-inputs">
                                <label for="form-ac-spring">Presence of Springs | <i>sRed</i></label>
                                <select class="form-control" id="form-ac-spring" name="sRed">
                                    <option value="-1" id="form-ac-spring-empty">-Select one-</option>
                                    <option value="2" title="sRed = 2">Year-long</option>
                                    <option value="1" title="sRed = 1">Only during rainy season</option>
                                    <option value="0" title="sRed = 0">No flow/spring</option>
                                </select>
                                <label for="form-ac-canal">Drainage Condition | <i>dRed</i></label>
                                <select class="form-control" id="form-ac-canal" name="drain_id">
                                    <option value="-1" id="form-ac-canal-empty">-Select one-</option>
                                    <option value="1" dred="2" title="dRed = 2">No drainage system</option>
                                    <option value="2" dred="2" title="dRed = 2">Totally clogged, filled with debris</option>
                                    <option value="3" dred="1" title="dRed = 1">Partially clogged or overflows during heavy rains</option>
                                    <option value="4" dred="1" title="dRed = 1">Water leaks into the slope</option>
                                    <option value="5" dred="0" title="dRed = 0">Good working condition</option>
                                </select>
                                <input type="hidden" name="dRed" id="form-ac-dRed">
                            </div>
                            <div id="a-rain-input" style="display: none">
                                <label for="form-ac-rain">Rain | <i>Rain</i></label>
                                <select class="form-control" id="form-ac-rain" name="rain">
                                    <option value="-1" id="form-ac-rain-empty">-Select one-</option>
                                    <option value="0" title="Rain = 0">50mm or less</option>
                                    <option value="2" title="Rain = 2">More than 50mm but less than 100mm</option>
                                    <option value="3" title="Rain = 3">More than 100mm but less than 200mm</option>
                                    <option value="4" title="Rain = 4">More than 200mm</option>
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="mt-3">
                            <legend>Denominator Factors</legend>
                            <label for="form-ac-land">Land Use | <i>lF</i></label>
                            <select class="form-control" id="form-ac-land" name="land_id">
                                <option lf="1.4" title="lF = 1.4" value="1" selected>Dense residential area (with closely spaced structures &#60;5m)</option>
                                <option lf="1.4" title="lF = 1.4" value="2">Commercial with building/s having 2 storeys or more</option>
                                <option lf="1.25" title="lF = 1.25" value="3">Residential area with buildings having 2 storeys spaced at &#8805;5m</option>
                                <option lf="1.4" title="lF = 1.4" value="4">Road/highway with heavy traffic (1 truck or more every 10mins)</option>
                                <option lf="1.25" title="lF = 1.25" value="5">Road/highway with light traffic (less than 1 truck every 10mins)</option>
                                <option lf="1.0" title="lF = 1.0" value="6">Agricultural area, grasslands and bushlands</option>
                                <option lf="1.0" title="lF = 1.0" value="7">Forest</option>
                                <option lf="1.0" title="lF = 1.0" value="8">Uninhabited and no vegetation</option>
                            </select>
                            <input type="hidden" name="lFactor" id="form-ac-lF" value="1.4">
                            <label for="form-ac-slope">Slope | <i>&alpha;Rating</i></label>
                            <select class="form-control" id="form-ac-slope"  name="alphaRating">
                                <option title="&alpha;Rating = 100" value="100">Slope angle greater than 75°</option>
                                <option title="&alpha;Rating = 32" value="32">Slope angle greater than 60° but less than or equal to 75°</option>
                                <option title="&alpha;Rating = 17" value="17">Slope angle greater than 45° but less than or equal to 60°</option>
                                <option title="&alpha;Rating = 10" value="10">Slope angle greater than 30° but less than or equal to 45°</option>
                                <option title="&alpha;Rating = 5" value="5">Slope angle greater than 15° but less than or equal to 30°</option>
                                <option title="&alpha;Rating = 2" value="2">Slope angle less than or equal to 15°</option>
                            </select>
                        </fieldset>
                        <fieldset class="mt-3">
                            <legend>Computed Factor of Stability</legend>
                            <label>Stability | <i>Fs</i></label>
                            <input type="text" class="form-control mb-3 " name="Fs" readonly id="form-ac-stability">
                        </fieldset>
                        
                        
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit" form="clears-add-form">Save</button>
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
                Are you sure you want to delete this report? This can not be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="clears-delete" data-dismiss="modal">Continue</button>
            </div>
        </div>
    </div>
</div>
<div id="clears-coordinate-modal" class="modal fade" role="dialog" style="z-index: 1051">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >&times;</button>
                <h4 class="modal-title">Select Coordinates<i class="fa fa-info-circle" text-align="right" aria-hidden="true"  data-toggle="tooltip"  title="Drag Pin to update coordinates"></i></h4>
            </div>
            <div class="modal-body">
                <div id="newcoords" class="w-100"><span class="ms-3"></span></div>
                <div class="np">
                    <label>Latitude:</label>
                    <input readonly type="text" name="latitude" id="latitude" class="form-control" placeholder="Enter latitude">
                </div>
                <div class="np">
                    <label>Longitude:</label>
                    <input readonly type="text" name="longitude" id="longitude" class="form-control" placeholder="Enter longitude">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="clears-coordinate-modal2" class="modal fade" role="dialog" style="z-index: 1051">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >&times;</button>
                <h4 class="modal-title">Select Coordinates<i class="fa fa-info-circle" text-align="right" aria-hidden="true"  data-toggle="tooltip"  title="Drag Pin to update coordinates"></i></h4>
            </div>
            <div class="modal-body">
                <div id="newcoords2" class="w-100"><span class="ms-3"></span></div>
                <div class="np">
                    <label>Latitude:</label>
                    <input readonly type="text" name="latitude" id="a-latitude" class="form-control" placeholder="Enter latitude">
                </div>
                <div class="np">
                    <label>Longitude:</label>
                    <input readonly type="text" name="longitude" id="a-longitude" class="form-control" placeholder="Enter longitude">
                </div>
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
    
    $('#r-print-report').off().on('click',function(e){
        let content = $('#c-print-paper').html();
        printreport(content);
    })
    
    $(document).on('click','.panel-toggler',function(e){
        e.stopImmediatePropagation();
        $(e.target).closest('.panel-body').find('.table').toggle();
    })
    .on('click','.clears-e-btn',function(e){
        // e.originalEvent.stopImmedatePropagation();
        $('[data-toggle="tooltip"]').tooltip();
        let row = $(e.currentTarget).closest('tr');
        let date = row.find('.c-date').text();
        let muni = row.find('.c-m-id').attr('m_id');
        let material = row.find('.c-material').attr('mid');
        let sRating = row.find('.c-material').text();
        let veg = row.find('.c-vegetation').text();
        let freq = row.find('.c-freq').attr('fid');
        let freq_val = row.find('.c-freq').text();
        let spring = row.find('.c-spring').text();
        let canal = row.find('.c-canal').attr('did');
        let rain = row.find('.c-rain').text();
        let land = row.find('.c-land').attr('lid');
        let lFactor = row.find('.c-land').text();
        let slope = row.find('.c-slope').text();
        let long = row.attr('long');
        let lat = row.attr('lat');
        let id = row.attr('report-id');
        let img = row.attr('image');
        $('#latitude').val(lat);
        $('#longitude').val(long);
        $('#clears-edit-form #form-c-id').val(id);
        $('#clears-edit-form #form-c-date').val(date);
        $('#clears-edit-form #form-c-m-id').val(muni);
        $('#clears-edit-form #form-c-material').val(material);
        $('#clears-edit-form #form-c-sRating').val(sRating);
        $('#clears-edit-form #form-c-vegetation').val(veg);
        $('#clears-edit-form #form-c-freq').val(freq);
        $('#clears-edit-form #form-c-fF').val(freq_val);
        $('#clears-edit-form #form-c-spring').val(spring);
        $('#clears-edit-form #form-c-canal').val(canal);
        $('#clears-edit-form #form-c-rain').val(rain);
        $('#clears-edit-form #form-c-land').val(land);
        $('#clears-edit-form #form-c-lF').val(lFactor);
        $('#clears-edit-form #form-c-slope').val(slope);
        $('#clears-edit-form #form-c-slat').val(lat);
        $('#clears-edit-form #form-c-slon').val(long);
        if( img != '' && img != null && img != undefined){
            $('#form-image-holder').removeClass('d-flex').addClass('d-none')
            $('.form-c-res-image-btn').attr('default',"url({{asset('photos/clears')}}"+"/"+img+")");
            $('#clears-edit-form #c-image-preview').removeClass('d-none');
            $('#clears-edit-form #c-image-preview').css('background-image',"url({{asset('photos/clears')}}"+"/"+img+")");
        }else{
            $('#form-c-image').val('');
            $('#form-image-holder').addClass('d-flex').removeClass('d-none')
            $('#clears-edit-form #c-image-preview').addClass('d-none');
        }
        let sr = parseFloat($("#form-c-material option:selected").attr('sr'));
        let fF = parseFloat($("#form-c-freq option:selected").attr('fF'));
        let lf = parseFloat($("#form-c-land option:selected").attr('lf'));
        let corrosion = sr;
        if(rain != "" && rain != null){
            $('#reds-2').prop('checked',true);
            $('#reds-1').prop('checked',false);
            $('#rain-input').show();
            $('#red-inputs').hide();
            $('#form-c-spring, #form-c-canal').val(-1)
            corrosion -= parseInt(rain);
        }else{
            $('#reds-1').prop('checked',true);
            $('#reds-2').prop('checked',false);
            $('#rain-input').hide();
            $('#form-c-rain').val(-1);
            $('#red-inputs').show();
            let dred = parseInt($("#form-c-canal option:selected").attr('dred'));
            let sred = parseInt(spring);
            $('#form-c-dRed').val(dred)
            corrosion -= dred;
            corrosion -= sred;
        }
        let Fs = ((parseFloat(veg) * fF * corrosion) / (parseInt(slope) * lf)).toFixed(2);
        $('#form-c-stability').val(Fs);
    })
    .on('change','#form-c-image', function(e){
        let file = $('#form-c-image')[0].files[0];
        let reader = new FileReader();
        reader.onloadend = function(){
            $('#c-image-preview').css({'background-image':"url(" + reader.result + ")"});
        }
        if (file) reader.readAsDataURL(file);
        else $('#c-image-preview').css({'background-image':"url()"});
    })
    .on('click','#form-c-del-image-btn', function(e){
        if(confirm("Are you sure you want to remove the image?")){
            $('#form-c-image')[0].value = '';
        }
        
    })
    .on('click','.form-c-res-image-btn', function(e){
        let img = $(this).attr('default');
        $('#clears-edit-form #c-image-preview').css('background-image', img);
        $('#form-c-image')[0].value = '';
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
    .on('click','.clears-v-btn',function(e){
        let lat = parseFloat($(e.currentTarget).closest('tr').attr('lat'));
        let long = parseFloat($(e.currentTarget).closest('tr').attr('long'));
        newMap(lat,long);
        let img = $(this).closest('tr').attr('image');
        if( img != '' && img != null && img != undefined){
            $('#preview-image').attr('src',"{{asset('photos/clears')}}"+"/"+img).css('height','500px');
        }else{
            $('#preview-image').attr('src',"").css('height','0');
        }
    })
    .on('change','#form-c-material,#form-c-vegetation,#form-c-freq,#form-c-spring,#form-c-canal,#form-c-rain,#form-c-land,#form-c-slope,input[type=radio][name=reds]',function(e){
        if($(e.currentTarget).is('input[type=radio][name=reds]')){
            if($(this).val() == 1){
                $('#red-inputs').show();
                $('#rain-input').hide();
            }else{
                $('#red-inputs').hide();
                $('#rain-input').show();
            }
        }
        let material = $('#clears-edit-form #form-c-material').val();
        let veg = $('#clears-edit-form #form-c-vegetation').val();
        let freq = $('#clears-edit-form #form-c-freq').val();
        let spring = $('#clears-edit-form #form-c-spring').val();
        let canal = $('#clears-edit-form #form-c-canal').val();
        let rain = $('#clears-edit-form #form-c-rain').val();
        let land = $('#clears-edit-form #form-c-land').val();
        let slope = $('#clears-edit-form #form-c-slope').val();
        let dred = parseInt($("#form-c-canal option:selected").attr('dred'));
        let sr = parseFloat($("#form-c-material option:selected").attr('sr'));
        let fF = parseFloat($("#form-c-freq option:selected").attr('fF'));
        let lf = parseFloat($("#form-c-land option:selected").attr('lf'));
        let rtype = $('input[type=radio][name=reds]:checked').val();
        let fs = compute(material,veg,freq,spring,canal,dred,rain,land,slope,sr,fF,lf,rtype);
        $('#form-c-stability').val(fs);
        if($(e.currentTarget).is('#form-c-freq')){$('#form-c-fF').val($("#form-c-freq option:selected").attr('fF'))}
        if($(e.currentTarget).is('#form-c-canal')){$('#form-c-dRed').val($("#form-c-canal option:selected").attr('dred'))}
        if($(e.currentTarget).is('#form-c-material')){$('#form-c-sRating').val($("#form-c-material option:selected").attr('sr'))}
        if($(e.currentTarget).is('#form-c-land')){$('#form-c-lF').val($("#form-c-land option:selected").attr('lf'))}
    })
    .on('change','#form-ac-material,#form-ac-vegetation,#form-ac-freq,#form-ac-spring,#form-ac-canal,#form-ac-rain,#form-ac-land,#form-ac-slope,input[type=radio][name=a-reds]',function(e){
        if($(e.currentTarget).is('input[type=radio][name=a-reds]')){
            if($(this).val() == 1){
                $('#a-red-inputs').show();
                $('#a-rain-input').hide();
            }else{
                $('#a-red-inputs').hide();
                $('#a-rain-input').show();
            }
        }
        let material = $('#clears-add-form #form-ac-material').val();
        let veg = $('#clears-add-form #form-ac-vegetation').val();
        let freq = $('#clears-add-form #form-ac-freq').val();
        let spring = $('#clears-add-form #form-ac-spring').val();
        let canal = $('#clears-add-form #form-ac-canal').val();
        let dred = parseInt($("#form-ac-canal option:selected").attr('dred'));
        let rain = $('#clears-add-form #form-ac-rain').val();
        let land = $('#clears-add-form #form-ac-land').val();
        let slope = $('#clears-add-form #form-ac-slope').val();
        let sr = parseFloat($("#form-ac-material option:selected").attr('sr'));
        let fF = parseFloat($("#form-ac-freq option:selected").attr('fF'));
        let lf = parseFloat($("#form-ac-land option:selected").attr('lf'));
        let rtype = $('input[type=radio][name=a-reds]:checked').val();
        let fs = compute(material,veg,freq,spring,canal,dred,rain,land,slope,sr,fF,lf,rtype);
        $('#form-ac-stability').val(fs);
        if($(e.currentTarget).is('#form-ac-freq')){$('#form-ac-fF').val($("#form-ac-freq option:selected").attr('fF'))}
        if($(e.currentTarget).is('#form-ac-canal')){$('#form-ac-dRed').val($("#form-ac-canal option:selected").attr('dred'))}
        if($(e.currentTarget).is('#form-ac-material')){$('#form-ac-sRating').val($("#form-ac-material option:selected").attr('sr'))}
        if($(e.currentTarget).is('#form-ac-land')){$('#form-ac-lF').val($("#form-ac-land option:selected").attr('lf'))}
    })
    .on('submit','#clears-edit-form',function(e){
        e.preventDefault();
        // e.originalEvent.stopImmedatePropagation();
        e.stopImmediatePropagation();
        let url = "{{route('c-update')}}";
        let data = new FormData(document.getElementById('clears-edit-form'));
        let rtype = $('input[type=radio][name=reds]:checked').val();
        if(rtype == 1){
            data.delete("rain");
        }else{
            data.delete("sRed");
            data.delete("dRed");
            data.delete("drain_id");
        }
        $.ajax({
            type:"POST",
            url:url,
            data:data,
            contentType: false,
            processData: false,
            success:function(response){
                if($.isEmptyObject(response.error)){
                    if(response.success){
                        $('.alert').hide();
                        $('#alert-update-1').fadeIn();

                        let report = response.report;
                        let row = $("#clears-table tbody tr[report-id="+report.id+"]");
                        row.attr('long',report.survey_longitude);
                        row.attr('lat',report.survey_latitude);
                        row.attr('image',report.image);
                        row.find('.c-date').text(report.survey_date);
                        row.find('.c-m-id').attr('m_id',report.municipality_id).text(report.municipality_name);
                        row.find('.c-p-id').text(report.province_name == "Mountain Province" ? "Mt. Province":report.province_name);
                        row.find('.c-material').attr('mid',report.material_id).attr('title',report.material).text(report.sRating);
                        row.find('.c-vegetation').attr('title',report.vegetation).text(report.vFactor);
                        row.find('.c-freq').attr('title',report.frequency).attr("fid",report.frequency_id).text(report.fFactor);
                        row.find('.c-spring').attr('title',report.springs).text(report.sRed);
                        row.find('.c-canal').attr('title',report.canals).attr('did',report.drain_id).text(report.dRed);
                        row.find('.c-rain').attr('title',report.rain_d).text(report.rain);
                        row.find('.c-land').attr('title',report.land).attr('lid',report.land_id).text(report.lFactor);
                        row.find('.c-slope').attr('title',report.angle).text(report.alphaRating);
                        row.find('.c-stability').text(report.Fs).removeClass('text-success text-warning text-danger');
                        if(report.Fs>= 1.2){
                            row.find('.c-stability').addClass('text-success');
                        }else if((report.Fs < 1.2 && report.Fs >= 1) || (report.Fs < 1 && report.Fs >= 0.7)){
                            row.find('.c-stability').addClass('text-warning');
                        }else if(report.Fs < 0.7){
                            row.find('.c-stability').addClass('text-danger');
                        }
                        row.find('.c-stability').attr('title',report.stability);
                        $('[data-toggle="tooltip"]').tooltip();
                        $('#clears-edit-modal').modal('hide')
                        
                    }else{
                        if(response.msg){
                            $('.alert').hide();
                            $('#alert-danger').fadeIn();
                            $('#alert-danger #content').text(response.msg)
                        }
                    }
                }else{
                    $('.alert').hide();
                    $('#alert-danger').fadeIn();
                    $('#alert-danger #content').text(response.msg)
                }
            },
            error:function(data){
                $('.alert').hide();
                $('#alert-danger').fadeIn();
                $('#alert-danger #content').text(response.msg)
            }
        })
    })
    .on('submit','#clears-add-form',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        if($('#form-ac-stability').val() == "Invalid data" || isNaN($('#form-ac-stability').val())){
            return false;
        }
        let url = "{{route('c-save')}}";
        let data = new FormData(document.getElementById('clears-add-form'));
        let rtype = $('input[type=radio][name=a-reds]:checked').val();
        if(rtype == 1){
            data.delete("rain");
        }else{
            data.delete("sRed");
            data.delete("dRed");
            data.delete("drain_id");
        }
        $.ajax({
            type:"POST",
            url:url,
            data:data,
            contentType: false,
            processData: false,
            success:function(response){
                if($.isEmptyObject(response.error)){
                    if(response.success == false){
                        if(response.msg){
                            $('.alert').hide();
                            $('#alert-danger').fadeIn();
                            $('#alert-danger #content').text(response.msg)
                        }
                    }else{
                        $('.alert').hide();
                        $('#alert-update-1').fadeIn();
                        if(!response.msg || response.msg == undefined || response.msg == null){
                            $('#the_table').html(response);
                            $('#clears-table').DataTable();
                        }
                        
                        // row.find('.c-stability').attr('title',report.stability);
                        $('[data-toggle="tooltip"]').tooltip();
                        $('#clears-add-modal').modal('hide')
                    }
                }else{
                    $('.alert').hide();
                    $('#alert-danger').fadeIn();
                    $('#alert-danger #content').text(response.error)
                }
            },
            error:function(data){
                $('.alert').hide();
                $('#alert-danger').fadeIn();
                $('#alert-danger #content').text(data.msg)
            }
        })
    })
    .on('click','.alert-close',function(){
        $(this).closest('.alert').fadeOut();
    })
    .on('click','#show-coord-map',function(){
        let lat = parseFloat($('#form-c-slat').val());
        let lng = parseFloat($('#form-c-slon').val());
        $('#newcoords').css('height','400px')
        var map = new google.maps.Map(document.getElementById('newcoords'),{
            center:{
                lat:lat,
                lng:lng
            },
            zoom:9
        });
        var marker = new google.maps.Marker({
            position:{
                lat:lat,
                lng:lng
            },
            map:map,
            draggable:true
        });
        google.maps.event.addListener(marker,'dragend',function(){
            $('#latitude,#form-c-slat').val(marker.getPosition().lat());
            $('#longitude,#form-c-slon').val(marker.getPosition().lng());
        });
    })
    .on('click','#show-coord-map2',function(){
        let lat = $('#form-ac-slat').val();
        let lng = $('#form-ac-slon').val();
        lat = parseFloat(lat != null && lat != undefined && lat.length > 0 ? lat : 17);
        lng = parseFloat(lng != null && lng != undefined && lng.length > 0 ? lng : 121);
        $('#newcoords2').css('height','400px')
        var map = new google.maps.Map(document.getElementById('newcoords2'),{
            center:{
                lat:lat,
                lng:lng
            },
            zoom:9
        });
        var marker = new google.maps.Marker({
            position:{
                lat:lat,
                lng:lng
            },
            map:map,
            draggable:true
        });
        google.maps.event.addListener(marker,'dragend',function(){
            $('#a-latitude,#form-ac-slat').val(marker.getPosition().lat());
            $('#a-longitude,#form-ac-slon').val(marker.getPosition().lng());
        });
    })
    .on('click','.clears-d-btn',function(){
        let id = $(this).closest('tr').attr('report-id');
        $('#clears-delete').attr('report-id',id);
    })
    .on('click','#clears-delete',function(e){
        e.stopImmediatePropagation();
        let url = "{{route('c-delete')}}";
        let id = $(this).attr("report-id");
        let data = new FormData();

        data.set('clears_id',id);
        $.ajax({
            type:"POST",
            url:url,
            data:data,
            contentType: false,
            processData: false,
            success:function(response){
                if($.isEmptyObject(response.error)){
                    if(response.success){
                        $('.alert').hide();
                        $('#alert-delete-1').fadeIn();
                        $('tr[report-id='+id+']').remove();
                        $('#clears-delete-modal').modal('hide')
                        
                    }else{
                        if(response.msg){
                            $('#alert-delete-1').fadeIn();
                        }
                    }
                }else{
                    alert(response.error.messages);
                }
            },
            error:function(data){
                alert(data.responseJSON.message);
            }
        })
    })
    .on('mouseenter','#clears-table tr', function(e){
        $(e.currentTarget).find('.spactions .inneractions').show();
    })
    .on('mouseleave','#clears-table tr', function(e){
        $(e.currentTarget).find('.spactions .inneractions').hide();
    })
    .on('click','#r-view-map',function(){
        let lat = parseFloat($(this).attr('lat'));
        let long = parseFloat($(this).attr('lon'));
        newMap(lat,long);
        let img = $(this).attr('image');
        if( img != '' && img != null && img != undefined){
            $('#preview-image').attr('src',img).css('height','500px');
        }else{
            $('#preview-image').attr('src',"").css('height','0');
        }
    })
    .on('click', '#r-view-table',function(){
        $('#report-view-div, #reports-list-div').toggleClass('d-none');
        $('#addcoords').css('height','0').html('<span class="ms-3">Click on a report below to view its location</span>');
        $('#preview-image').attr('src','').css('height','0');
    })
    .on('click','.c-report',function(e){
        $('#report-view-div').removeClass('d-none');
        $('#reports-list-div').addClass('d-none');
        $('#addcoords').css('height','0').html('<span class="ms-3">Click on a report below to view its location</span>');
        $('#preview-image').attr('src','').css('height','0');
        let img = $(this).closest('tr').attr('image');
        if( img != '' && img != null && img != undefined){
            $('#r-view-map').attr('image',"{{asset('photos/clears')}}"+"/"+img);
        }else{
            $('#preview-image').attr('image',"");
        }
        let row = $(e.currentTarget).closest('tr');
        let date = row.find('.c-date').text();
        let muni = row.find('.c-m-id').text();
        let prov = row.find('.c-p-id').text();
        let material = row.find('.c-material').attr('title');
        let sRating = row.find('.c-material').attr('title');
        let veg = row.find('.c-vegetation').attr('title');
        let freq = row.find('.c-freq').attr('title');
        let freq_val = row.find('.c-freq').attr('title');
        let spring = row.find('.c-spring').attr('title');
        let canal = row.find('.c-canal').attr('title');
        let rain = row.find('.c-rain').attr('title');
        let land = row.find('.c-land').attr('title');
        let slope = row.find('.c-slope').attr('title');
        let fs = row.find('.c-stability').text();
        let fs_desc = row.find('.c-stability').attr('title');
        let long = row.attr('long');
        let lat = row.attr('lat');
        let id = row.attr('report-id');
        let name = row.find('.c-uploader').text();
        let up_date = row.attr('upload-date');
        if(spring == "Empty value"){ spring = "Not recorded"}
        if(canal == "Empty value"){ canal = "Not recorded"}
        if(rain == "Empty value"){ rain = "Not recorded"}
        $('.r-municipality').text(muni);
        $('.r-province').text(prov);
        $(".r-date").text(date);
        $(".r-lat").text(lat);
        $(".r-lon").text(long);
        $('#r-view-map').attr('lat',lat);
        $('#r-view-map').attr('lon',long);
        $(".r-sr").text(sRating);
        $(".r-vf").text(veg);
        $(".r-ff").text(freq);
        $(".r-sred").text(spring);
        $(".r-dred").text(canal);
        $(".r-rain").text(rain);
        $(".r-lf").text(land);
        $(".r-slope").text(slope);
        $(".r-fs").text(fs);
        $(".r-fs-desc").text(fs_desc);
        $(".r-name").text(name);
        $('.r-upload-date').text(up_date);
        window.location='#report-view-div';
    })
    .on('change','#upload-filter, #fs-filter',function(e){
        e.stopImmediatePropagation();
        let val = $('#upload-filter').val();
        let fs = $('#fs-filter').val();
        $.ajax({
            type:"POST",
            url: "{{route('c-filter')}}",
            data: {"filter":val,'fs':fs},
            success:function(res){
                if(!res.msg || res.msg == undefined || res.msg == null){
                    $('#the_table').html(res);
                    $('#clears-table').DataTable();
                }
            }
        });
    })
    
    function compute(material,veg,freq,spring,canal,dred = -1,rain,land,slope,sr,fF,lf,rtype){
        

        let corrosion = sr;
        // let dred = -1;
        let sred = parseInt(spring);
        let invalid = false;
        if(rtype == 2){
            if(rain == -1){invalid = true;}
            else{corrosion -= parseInt(rain);}
        }else{
            
            sred = parseInt(spring);
            if(dred == -1 || sred == -1){invalid = true;}
            else{corrosion -= (dred + sred);}
        }
        let Fs = ((parseFloat(veg) * fF * corrosion) / (parseInt(slope) * lf)).toFixed(2);
        if(invalid){Fs = "Invalid data";}
        
        return Fs;
    }
    function newMap(lat,long){
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
    function printreport(content){
        var prtContent = content;
        var WinPrint = window.open('', 'print_frame', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
        WinPrint.document.write('<html><head>');
        WinPrint.document.write('<base href="' + location.origin + location.pathname + '">');
        WinPrint.document.write('</head><body>');
        WinPrint.document.write(prtContent);
        WinPrint.document.write('</body></html>');
        WinPrint.document.close();
        WinPrint.focus();
        setTimeout(function () {
            WinPrint.print();
            WinPrint.close();
        }, 500);
    }
</script>