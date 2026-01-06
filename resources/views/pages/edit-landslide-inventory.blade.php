@extends('layouts.masters.frontend-layouts')
@section('page-content')

<div class="row">   
    <div class="col-xs-12 text-center">
        <h1 class="pg-title page-header mb-2"> {!! $landslideInventory->location !!}</h1>
        <span class="defsp pagedate"><?php echo date("F j Y g:ia", strtotime($landslideInventory->date));?></span>
    </div>

    @if((Auth::user()->id == $landslideInventory->created_by) || (Auth::user()->role_id <= 3))
        <div class="col-xs-12 np text-right editlink">
            <a href="{{ route('landslide-inventories.show', $landslideInventory->id) }}">Cancel Edit</a> 
        </div>
    @endif

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12 pagedescription np">          
            <h3>Details</h3>
            <pre style="max-height: 400px; overflow-y: auto;">
            {!! !empty($landslideInventory->details_formatted) ? $landslideInventory->details_formatted : 'No details available.' !!}  
            </pre>  
        </div>

        <div class="col-xs-12 pagedescription np">          
            <h3>Analysis</h3>
            <pre style="max-height: 400px; overflow-y: auto;">
            {!! !empty($landslideInventory->analysis_formatted) ? $landslideInventory->analysis_formatted : 'No analysis available.' !!}  
            </pre>
        </div>

        <div class="col-xs-12 pagedescription np">          
            <h3>Remarks</h3>
            <pre style="max-height: 400px; overflow-y: auto;">
            {!! !empty($landslideInventory->remarks_formatted) ? $landslideInventory->remarks_formatted : 'No remarks available.' !!}  
            </pre>
        </div>
        
        <div class="col-xs-12 pagefoot np"> 
            <span class="defsp">This inventory is created and added to this system by: <span>
                @if(!empty($landslideInventory->user))
                    {{ $landslideInventory->user->last_name }}, {{ $landslideInventory->user->first_name }}
                @else
                    Unknown User
                @endif
            </span></span>      
        </div>
    </div>

    <div class="col-xs-12 col-sm-4">
        <div id="latvalue" style="display:none"><span>{{ $landslideInventory->latitude }}</span></div>
        <div id="longvalue" style="display:none"><span>{{ $landslideInventory->longitude }}</span></div>
        <div id="lfmap" style="height: 500px; width: 100%;"></div>
        
        {{-- Updated Validation Form --}}
        <div class="col-xs-12 np mt-2" style="background: #f9f9f9; padding: 15px; border: 1px solid #ddd; border-radius: 4px;">
            <form action="{{ route('landslide-inventories.update', $landslideInventory->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                
                <div class="form-group">
                    <label for="validation_status"><strong>Validation Status:</strong></label>
                    <select name="validation_status" id="validation_status" class="form-control">
                        <option value="">-- Select Status --</option>
                        @foreach($landslideInventoryValidations as $validation)
                            <option value="{{ $validation->id }}" 
                                {{ (isset($landslideInventory->landslideInventoryValidation) && $landslideInventory->landslideInventoryValidation->id == $validation->id) ? 'selected' : '' }}>
                                {{ $validation->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block btn-sm">Update Validation</button>
            </form>
            
            @if(session('success'))
                <div class="alert alert-success mt-2" style="padding: 5px 10px; font-size: 12px;">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>

    @if((Auth::user()->id == $landslideInventory->created_by) || (Auth::user()->role_id <= 3))
        <div class="col-xs-12 np text-right editlink" style="margin-top: 20px;">
            <a href="{{ route('landslide-inventories.index') }}">Go back to landslide inventory list</a> 
        </div>
    @endif
</div>
@stop

@section('page-js-files')
<script>
    jQuery(function($){
        $(document).ready(function(){
            $('.fancybox').fancybox();

            @php
                $analysisObj = is_string($landslideInventory->analysis) 
                    ? json_decode($landslideInventory->analysis) 
                    : $landslideInventory->analysis;
            @endphp
            
            var analysisData = @json($analysisObj);

            function initMap(){
                var latVal = $('#latvalue span').text().trim();
                var lngVal = $('#longvalue span').text().trim();
                var latitude = latVal ? parseFloat(latVal) : 0;
                var longitude = lngVal ? parseFloat(lngVal) : 0;

                if ((latitude === 0 || isNaN(latitude)) && analysisData && analysisData.candidates.length > 0) {
                    latitude = parseFloat(analysisData.candidates[0].centroid.lat);
                    longitude = parseFloat(analysisData.candidates[0].centroid.lon);
                }

                var myLatLng = {lat: latitude, lng: longitude};
                var map = new google.maps.Map(document.getElementById('lfmap'), {
                    zoom: 14,
                    center: myLatLng,
                    mapTypeId: 'satellite',
                });

                var landslideIcon = {
                    url: "{{ asset('assets/images/landslideicon.png') }}",
                    scaledSize: new google.maps.Size(20, 20)
                };

                if (analysisData && analysisData.candidates) {
                    analysisData.candidates.forEach(function(candidate) {
                        var marker = new google.maps.Marker({
                            position: {lat: parseFloat(candidate.centroid.lat), lng: parseFloat(candidate.centroid.lon)},
                            icon: landslideIcon,
                            map: map,
                            title: "Candidate #" + candidate.id
                        });
                        var infoWindow = new google.maps.InfoWindow({
                            content: "<strong>Candidate " + candidate.id + "</strong><br>Area: " + candidate.area_m2.toFixed(2) + " m²"
                        });
                        marker.addListener('click', function() { infoWindow.open(map, marker); });
                    });
                }
            }

            if (typeof google !== 'undefined') { initMap(); } else { window.onload = initMap; }
        }); 
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC058wNQG2iAeF7z0ysRHQw_0Gsqd6Xp5s"></script>
@stop