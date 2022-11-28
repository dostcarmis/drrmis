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
                            <th class="text-center" data-toggle="tooltip" title="Slope Material">sF</th>
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
                            <tr long = "{{$r->survey_longitude}}" lat = "{{$r->survey_latitude}}" onclick="window.location='#h4mapview'">
                                <td>{{date('Y-m-d',strtotime($r->survey_date))}}</td>
                                <td>{{$r->municipality->name}}</td>
                                <td>{{$r->province->name == "Mountain Province" ? "Mt. Province":$r->province->name }}</td>
                                <td>{{$r->user->first_name." ".$r->user->last_name}}</td>
                                <td class="text-center" data-toggle="tooltip" title="{{$r->slopeMaterial($r->material_id)}}">{{$r->sRating}}</td>
                                <td class="text-center" data-toggle="tooltip" title="{{$r->vegetation($r->vFactor)}}">{{$r->vFactor}}</td>
                                <td class="text-center" data-toggle="tooltip" title="{{$r->frequency($r->frequency_id)}}">{{$r->fFactor}}</td>
                                <td class="text-center" data-toggle="tooltip" title="{{$r->springs($r->sRed)}}">{{$r->sRed}}</td>
                                <td class="text-center" data-toggle="tooltip" title="{{$r->canals($r->dRed)}}">{{$r->dRed}}</td>
                                <td class="text-center" data-toggle="tooltip" title="{{$r->rain($r->rain)}}">{{$r->rain}}</td>
                                <td class="text-center" data-toggle="tooltip" title="{{$r->land($r->land_id)}}">{{$r->lFactor}}</td>
                                <td class="text-center" data-toggle="tooltip" title="{{$r->slopeAngle($r->alphaRating)}}" >{{$r->alphaRating}}</td>
                                <td class="strong {{
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
                                        <button type="button" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        <button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
                <button id="master-panel-toggler" class="my-auto ms-3 btn btn-sm strong border-none">Hide all</button>
            </div>
            <div class="grid-container">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="d-flex">
                            <h5 class="panel-title">Slope Material | <b><i>sF</i></b></h5>
                            <button class="border-none bg-none p-0 panel-toggler" data-toggle="tooltip" title="Toggle show/hide"><i class="fa fa-expand" aria-hidden="true" class="panel-toggler"></i></button>
                        </div>
                        <hr>
                        <table class="table">
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
                        <table class="table">
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
                        <table class="table">
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
                        <table class="table">
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
                        <table class="table">
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
                        <table class="table">
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
                        <table class="table">
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Value</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>1.4</td><td>Dense residential area (with closely spaced structures &#60;m)</td></tr>
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
                        <table class="table">
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

            {{-- <div id="dZUpload" class="dropzone form-control pos-rel">
                <div class="dz-default dz-message pos-a centered">Drop images here or click to upload image</div>
            </div> --}}
            
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
<script type="text/javascript">
	
    /* google.maps.event.addListener(marker,'dragend',function(){
        $('#latitude').val(marker.getPosition().lat());
        $('#longitude').val(marker.getPosition().lng());
    }); */
</script>
@endsection
<script>
    $(document).on('click','.panel-toggler',function(e){
        e.stopImmediatePropagation();
        $(e.target).closest('.panel-body').find('.table').toggle();
    })
    .on('click','#master-panel-toggler',function(){
        $('#clear-fluid .panel .table').toggle();
        if($(this).text() == "Hide all"){$(this).text("Show all")}
        else{$(this).text('Hide all')}
    })
    .on('click','#clears-table tbody tr',function(e){
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
    })
</script>