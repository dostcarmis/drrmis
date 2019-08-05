@extends('layouts.masters.other-layouts')
@section('page-content')
<div class="container-fluid">
    <div class="row">
        <div id="dashboard" class="col-xs-12">
            <h1 class="page-header">Notification</h1>
        </div>
        <div class="col-xs-12">
        	
        	<?php
        	$address = '';
        	$lat = '';
        	$long = '';
            $provname = '';
        	?>
        		@foreach($sensors as $sensor)
	        		@if($notifications->sensorsids == $sensor->id)
	        			<?php 
	        				$address = $sensor->address;
	        				$lat = $sensor->latitude;
	        				$long = $sensor->longitude;
	        			 ?>
	        		@endif
	        	@endforeach
                @foreach($provinces as $province)
                    @if($notifications->province_id === $province->id)
                        <?php $provname = $province->name; ?>
                    @endif
                @endforeach
                <span class="defsp spcritical">Critical rainfall amount recorded in </span>
	        <h2 class="notiftitle">

	        	{{ $address }}, {{$provname}}
	        	
        	</h2>
        	<span class="defsp spstats">
        		<span>Cummulative : {{$notifications->value}} mm </span>
        		<span>Threshold value : 
        		@foreach($thresholds as $threshold)
        			@if($threshold->address_id == $notifications->sensorsids)
                        {{$threshold->threshold_landslide}} mm
                    @endif
        		@endforeach
        		</span>
        		
        	</span>
        </div>  
    </div>      
    <div class="row">
        <div class="col-xs-12 otherlandslidewrap">
            <span class="defsp splandslide-results">Landslides recorded in {{$provname}} with similar accumulated rainfall amount.</span>
            <div class="col-xs-12 np otherlandslideswrap">
                
                <?php
                $counter = 0;

                ?>

                @foreach($incidents as $incident)                                
                    @if($incident->incident_type == 1)
                        @if($incident->province_id == $notifications->province_id)
                            @if($incident->pastrainvalue >= $notifications->value)
                            <?php $counter = 1; ?>
                            <div class="col-xs-12 np pernotifwrap">
                                <span class="defsp">Location: {{$incident->location}}</span>
                                <span class="defsp">Province: 
                                    @foreach($provinces as $province)
                                        @if($province->id == $incident->province_id)
                                            {{ $province->name }}
                                        @endif
                                    @endforeach
                                </span>
                                <span class="defsp">Date / Time: <?php echo date("F j Y g:i A", strtotime($incident->date));?>                               
                                </span>
                                <span class="defsp">
                                    Rainfall Value: {{$incident->pastrainvalue }} mm
                                </span>
                                <span class="defsp">
                                    Latitude: {{$incident->latitude}}
                                </span>
                                <span class="defsp">
                                    Longitude: {{$incident->longitude}}
                                </span>
                            </div>                        
                            @endif 
                        @endif 
                    @endif                    
                @endforeach
                @if($counter != 1)
                <div class="col-xs-12 np">
                    <p>Sorry no landslide posts match.</p> 
                </div>
                    
                @endif

                
                
                
                
            </div>
        </div>
    </div>
    </div>
</div>

@stop
@section('page-js')

<script src="{{ asset('assets/js/viewsensor.js') }}"></script>

@stop
