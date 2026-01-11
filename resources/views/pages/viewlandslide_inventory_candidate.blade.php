@extends('layouts.masters.frontend-layouts')
@section('page-content')
    
<div class="row">   
    <div class="col-xs-12 text-center">
        <h1 class="pg-title page-header mb-2"> {!! $landslideInventory->location ?? "No Location - Update Required" !!}</h1>
        <span class="defsp pagedate">{{ date("F j, Y", strtotime($landslideInventory->date)) }}</span>
    </div>

    @if((Auth::user()->id == $landslideInventory->validator_id) || (Auth::user()->role_id <= 3))
        <div class="col-xs-12 np text-right editlink">
            <a href="{{ route('landslide-inventories.index') }}">Back</a> |
            <a href="{{ route('landslide-inventories.show', [
                'id' => $landslideInventory->id,
                'view-all' => '1'
            ]) }}">View All</a> |
            <a href="{{ route('landslide-inventories.edit', $landslideInventory->id) }}" style="margin-right:5px">Edit This Landslide Inventory</a> 
        </div>
    @endif

    <div class="col-xs-12 col-sm-8">
        <div class="col-xs-12 pagedescription np">          
            <h3>Analysis</h3>
            <pre style="max-height: 400px; overflow-y: auto;">{!! !empty($landslideInventory->analysis_formatted) ? $landslideInventory->analysis_formatted : 'No analysis available.' !!}</pre>
        </div>

        <div class="col-xs-12 pagedescription np">          
            <h3>Remarks</h3>
            <pre style="max-height: 400px; overflow-y: auto;">{!! !empty($landslideInventory->remarks_formatted) ? $landslideInventory->remarks_formatted : 'No remarks available.' !!}</pre>
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
		
		{{-- Show validation status --}}
		<div class="col-xs-12 np mt-2">
			<strong>Validation Status:</strong>
			@if(!empty($landslideInventory->landslideInventoryValidation))
				{{ $landslideInventory->landslideInventoryValidation->name }}
			@else
				Not Validated
			@endif
		</div>
    </div>

    @if((Auth::user()->id == $landslideInventory->validator_id) || (Auth::user()->role_id <= 3))
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

            function initMap(){
                //  Get coordinates directly from PHP to avoid DOM scraping
                var latitude = parseFloat("{{ $landslideInventory->latitude }}");
                var longitude = parseFloat("{{ $landslideInventory->longitude }}");

                // Fallback if coordinates are empty
                if (isNaN(latitude) || isNaN(longitude)) {
                    console.error("Invalid coordinates provided.");
                    return;
                }

                var myLatLng = {lat: latitude, lng: longitude};
                
                // Initialize the Map
                var map = new google.maps.Map(document.getElementById('lfmap'), {
                    zoom: 16,
                    center: myLatLng,
                    mapTypeId: 'satellite',
                });

                // Define the custom icon
                var landslideIcon = {
                    url: "{{ asset('assets/images/landslideicon.png') }}",
                    scaledSize: new google.maps.Size(30, 30) 
                };

                // Create the single marker
                var marker = new google.maps.Marker({
                    position: myLatLng,
                    icon: landslideIcon,
                    map: map,
                    title: "{{ $landslideInventory->location }}",
                    animation: google.maps.Animation.DROP
                });

                // Add InfoWindow for details
                var infoWindow = new google.maps.InfoWindow({
                    content: "<strong>Location:</strong> {{ $landslideInventory->location }}<br>" +
                            "<strong>Lat:</strong> " + latitude + "<br>" +
                            "<strong>Lng:</strong> " + longitude
                });

                marker.addListener('click', function() {
                    infoWindow.open(map, marker);
                });
            }

            // Handle Google Maps loading states
            if (typeof google !== 'undefined') {
                initMap();
            } else {
                // If the script is loaded asynchronously
                window.initMap = initMap; 
            }
        }); 
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC058wNQG2iAeF7z0ysRHQw_0Gsqd6Xp5s"></script>
@stop