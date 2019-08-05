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
                <?php 
                $sensornames = [];
                $sensornamecount = 0;
                $sensorname = '';
                $sensorids = unserialize($notifications->sensorsids);
                if(count($sensorids) >= 2 ){
                    foreach ($sensorids as $sensorid) {
                        foreach ($sensors as $sensor) {
                            if ($sensorid == $sensor->id) {
                                $sensornames[$sensornamecount] = ucfirst(strtolower($sensor->address));
                            }
                            $sensornamecount++;
                        }
                    }
                $str = array_pop($sensornames);
                $str = implode(', ', $sensornames)." and ".$str;
                echo $str;
                }else{
                    foreach ($sensors as $sensor) {
                        if ($sensorids[0] == $sensor->id) {
                            $sensorname = $sensor->address;
                        }
                    }
                }
                echo ucfirst(strtolower($sensorname)).',';
            ?>
	        	{{$provname}}
	        	
        	</h2>
        	<span class="defsp spstats">
        		<span>Cummulative : 
                    <?php 
                        $sensorvalues = [];
                        $sensorvaluescount = 0;
                        $sensorvalue = '';
                        $sensordatas = unserialize($notifications->sensorvalues);

                        if(count($sensordatas) >= 2 ){
                            foreach ($sensordatas as $sensordata) {
                                $sensorvalues[$sensorvaluescount] = $sensordata.' m';
                                $sensorvaluescount++;
                            }
                            if (!empty($sensorvalues)) {
                                $str = array_pop($sensorvalues);
                                $str = implode(',', $sensorvalues)." and ".$str;
                                echo '<strong>'.$str.' </strong> respectively.';
                            }                          
                        }else{
                            $sensorvalue = $sensordatas[0];
                            echo '<strong>'.$sensorvalue .' m</strong>.';
                        }                        
                    ?>
                 </span>
        		<span>Threshold value set: 
        		@foreach($thresholdfloods as $thresholdflood)
                    @if($notifications->floodthresholdid == $thresholdflood->id)
                        <?php 
                            $valuesset = [];
                            $valuessetcount = 0;
                            $valueset = '';
                            $valuedatas = unserialize($thresholdflood->sensor_sources);

                            if(count($valuedatas) >= 2 ){
                                foreach ($valuedatas as $valuedata) {
                                    $valuesset[$valuessetcount] = $valuedata[1].' m';
                                    $valuessetcount++;
                                }
                                if(!empty($valuesset)){
                                    $str = array_pop($valuesset);
                                    $str = implode(',', $valuesset)." and ".$str;
                                    echo '<strong>'.$str.' </strong> respectively.'; 
                                }                            
                            }else{
                                $valueset = $valuedatas[0][1];
                                echo '<strong>'.$valueset .' m</strong>.';
                            }                        
                        ?>
                    @endif        			
        		@endforeach
        		</span>
                <span>Locations at Risk: 

                @foreach($thresholdfloods as $thresholdflood)
                    @if($notifications->floodthresholdid == $thresholdflood->id)
                        <?php 
                            $locationsatrisk = [];
                            $locationsatriskcount = 0;
                            $locationatrisk = '';
                            $areasaffected = unserialize($thresholdflood->areas_affected);

                            if(count($areasaffected) >= 2 ){
                                foreach ($areasaffected as $areaaffected) {
                                    foreach ($floodproneareas as $floodpronearea) {
                                        if ($floodpronearea->id == $areaaffected) {
                                            $locationsatrisk[$locationsatriskcount] = $floodpronearea->address;
                                            $locationsatriskcount++;
                                        }
                                    }                                 
                                }
                                if (!empty($locationsatrisk)) {
                                    $str = array_pop($locationsatrisk);
                                    $str = implode(', ', $locationsatrisk)." and ".$str;
                                    echo '<strong>'.$str.'</strong>.'; 
                                }                            
                            }else{
                                $locationatrisk = $areasaffected[0];
                                echo '<strong>'.$locationatrisk .'</strong>.';
                            }                        
                        ?>
                    @endif                  
                @endforeach

                </span>
        		
        	</span>
        </div>  
    </div>      
    <div class="row">
        <div class="col-xs-12 otherlandslidewrap">
            <span class="defsp splandslide-results">Floods recorded in {{$provname}} with similar waterlevel value.</span>
            <div class="col-xs-12 np otherlandslideswrap">
                
                <?php
                $counter = 0;

                ?>

                <!--******for flood******-->

                @foreach($floods as $flood)                                
                    @if($flood->province_id == $notifications->province_id)
                        @if($flood->pastrainvalue >= $notifications->value)
                        <?php $counter = 1; ?>
                        <div class="col-xs-12 np pernotifwrap">
                            <span class="defsp">Location: {{$flood->location}}</span>
                            <span class="defsp">Province: 
                                @foreach($provinces as $province)
                                    @if($province->id == $flood->province_id)
                                        {{ $province->name }}
                                    @endif
                                @endforeach
                            </span>
                            <span class="defsp">Date / Time: <?php echo date("F j Y g:i A", strtotime($flood->date));?>                               
                            </span>
                            <span class="defsp">
                                Rainfall Value: {{$flood->pastrainvalue }} m
                            </span>
                            <span class="defsp">
                                Latitude: {{$flood->latitude}}
                            </span>
                            <span class="defsp">
                                Longitude: {{$flood->longitude}}
                            </span>
                        </div>                        
                        @endif 
                    @endif                     
                @endforeach
                @if($counter != 1)
                <div class="col-xs-12 np">
                    <p>Sorry no floods posts match.</p> 
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
