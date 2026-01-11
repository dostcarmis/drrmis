@extends('layouts.masters.frontend-layouts')
@section('page-content')
    
<div class="row">   
    <div class="col-xs-12 text-center">
        <h1 class="pg-title page-header mb-2"> {!! $landslideInventory->location !!}</h1>
        <span class="defsp pagedate">{{ date("F j Y g:ia", strtotime($landslideInventory->date)) }}</span>
    </div>

    @if((Auth::user()->id == $landslideInventory->created_by) || (Auth::user()->role_id <= 3))
        <div class="col-xs-12 np text-right editlink">
            <a href="{{ route('landslide-inventories.show', $landslideInventory->id) }}">Back</a>
        </div>
    @endif

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12 pagedescription np">          
            <h3>Details</h3>
            <pre style="max-height: 400px; overflow-y: auto;">{!! !empty($landslideInventory->details_formatted) ? $landslideInventory->details_formatted : 'No details available.' !!}</pre>  
        </div>

        <div class="col-xs-12 pagedescription np">          
            <h3>Analysis</h3>
            <pre style="max-height: 400px; overflow-y: auto;">{!! !empty($landslideInventory->analysis_formatted) ? $landslideInventory->analysis_formatted : 'No analysis available.' !!}</pre>
        </div>

        <div class="col-xs-12 pagedescription np">          
            <h3>Remarks</h3>
            <pre style="max-height: 400px; overflow-y: auto;">{!! !empty($landslideInventory->remarks_formatted) ? $landslideInventory->remarks_formatted : 'No remarks available.' !!}  </pre>
        </div>
        
        <div class="col-xs-12 pagefoot np"> 
            <span class="defsp">This inventory is created and added to this system by: <span>
                @if(!empty($landslideInventory->validator))
                    {{ $landslideInventory->validator->full_name }}
                @else
                    Unknown User
                @endif
            </span></span>      
        </div>
    </div>

    <div class="col-xs-12 col-sm-4">
        {{-- Hidden fields to store the main coordinates if you still need them for centering --}}
        <div id="latvalue" style="display:none"><span>{{ $landslideInventory->latitude }}</span></div>
        <div id="longvalue" style="display:none"><span>{{ $landslideInventory->longitude }}</span></div>
        <div id="lfmap" style="height: 500px; width: 100%;"></div>
    </div>

    @if((Auth::user()->id == $landslideInventory->created_by) || (Auth::user()->role_id <= 3))
        <div class="col-xs-12 np text-right editlink">
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

            // Safely parse the analysis JSON
            // If it's a string in the DB, we decode it first so JSON can format it for JS
            @php
                $analysisObj = is_string($landslideInventory->analysis) 
                    ? json_decode($landslideInventory->analysis) 
                    : $landslideInventory->analysis;
            @endphp
            
            var analysisData = @json($analysisObj);

            function initMap(){
                // Get main coordinates from the view
                var latVal = $('#latvalue span').text().trim();
                var lngVal = $('#longvalue span').text().trim();
                
                var latitude = latVal ? parseFloat(latVal) : 0;
                var longitude = lngVal ? parseFloat(lngVal) : 0;

                // Fallback: If main coordinates are missing, center on the first candidate
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

                // Define your custom icon
                var landslideIcon = {
                    url: "{{ asset('assets/images/landslideicon.png') }}",
                    scaledSize: new google.maps.Size(20, 20) // Adjust size as needed
                };

                // Plot all candidates from the analysis attribute
                if (analysisData && analysisData.candidates) {
                    analysisData.candidates.forEach(function(candidate) {
                        var pos = {
                            lat: parseFloat(candidate.centroid.lat),
                            lng: parseFloat(candidate.centroid.lon)
                        };

                        var marker = new google.maps.Marker({
                            position: pos,
                            icon: landslideIcon, // Using your requested icon
                            map: map,
                            title: "Candidate #" + candidate.id
                        });

                        // Optional: Add info window to show area details
                        var infoWindow = new google.maps.InfoWindow({
                            content: "<strong>Candidate " + candidate.id + "</strong><br>" +
                                     "Area: " + candidate.area_m2.toFixed(2) + " m²"
                        });

                        marker.addListener('click', function() {
                            infoWindow.open(map, marker);
                        });
                    });
                }
            }

            // Ensure Google Maps is loaded before calling init
            if (typeof google !== 'undefined') {
                initMap();
            } else {
                window.onload = initMap;
            }
        }); 
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC058wNQG2iAeF7z0ysRHQw_0Gsqd6Xp5s"></script>
@stop