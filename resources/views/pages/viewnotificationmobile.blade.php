@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">Notifications</h1>
    </div>

<div class="col-xs-12 notificationmobile">
<ul>
<li>
    @foreach($allnotifications as $bynotification)
        @if($bynotification->user_id == Auth::user()->id)
            @if($bynotification->nc_id == 3)                                        
                @if($bynotification->is_read != 1)
                    <a href="<?php echo url('viewnotification'); ?>/<?php echo $bynotification->id; ?>" class="readnotifications unread">
                @else
                    <a href="<?php echo url('viewnotification'); ?>/<?php echo $bynotification->id; ?>" class="readnotifications">
                @endif  
                    <input type="hidden" value="{{$bynotification->id}}" id="notifid" name="notifid">
                    <div class="media">
                        <div class="media-body">
                                
                        <p class="notifcontents">                                                
                        <span>
                            <?php 
                                $ncbody = "";
                            ?>
                            @foreach($notitifcontent as $nc)                                               
                                @if($nc->id == $bynotification->nc_id)
                                    <?php $ncbody = explode("-@-", $nc->body);  ?>
                                @endif
                            @endforeach
                        </span>
                        <span>
                            <?php echo $ncbody[0];?>
                        </span>
                        <span class="sp-notiflocation">
                            @foreach($allmunicipalities as $municipality)                                               
                                @if($municipality->id == $bynotification->municipality_id)
                                    {{$municipality->name}},
                                @endif
                            @endforeach
                            @foreach($allprovinces as $province)                                               
                                @if($province->id == $bynotification->province_id)
                                    {{$province->name}}
                                @endif
                            @endforeach
                        </span>
                        <span>
                            <?php echo $ncbody[1];?>
                        </span>
                        <span>
                            <strong>{{$bynotification->value }}mm</strong>
                        </span>
                        <span>
                            <?php echo $ncbody[2];?>
                        </span>
                        <span>
                            @foreach($thresholds as $threshold)
                                @if($threshold->address_id == $bynotification->sensorsids)
                                    {{$threshold->threshold_landslide}}mm. 
                                @endif
                            @endforeach
                        </span>                                              
                                                                            
                   </p>    

                <p class="time"><i class="fa fa-clock-o"></i>
                {{  \Carbon\Carbon::createFromTimeStamp(strtotime($bynotification->created_at))->diffForHumans() }}</p>                                        
                            </div>
                        </div>
                    </a>
            @else
                @if($bynotification->is_read != 1)
                    <a href="<?php echo url('viewnotificationflood'); ?>/<?php echo $bynotification->id; ?>" class="readnotifications unread">
                @else
                    <a href="<?php echo url('viewnotificationflood'); ?>/<?php echo $bynotification->id; ?>" class="readnotifications">
                @endif  

<!--======================================================== notifflood ===========================================-->

                <input type="hidden" value="{{$bynotification->id}}" id="notifid" name="notifid">
                    <div class="media">
                        <div class="media-body">                                                        
                        <p class="notifcontents">                                                
                        <span>
                            <?php 
                                $ncbody = "";
                            ?>
                            @foreach($notitifcontent as $nc)                                               
                                @if($nc->id == $bynotification->nc_id)
                                    <?php $ncbody = explode("-@-", $nc->body);  ?>
                                @endif
                            @endforeach
                        </span>
                        <span>
                            <?php echo $ncbody[0];?>
                        </span>
                        <span class="sp-notiflocation">
                            <?php 
                                $sensornames = [];
                                $sensornamecount = 0;
                                $sensorname = '';
                                $sensorids = unserialize($bynotification->sensorsids);
                                if(count($sensorids) >= 2 ){
                                    foreach ($sensorids as $sensorid) {
                                        foreach ($sensorss as $sensor) {
                                            if ($sensorid == $sensor->id) {
                                                $sensornames[$sensornamecount] = ucfirst(strtolower($sensor->address));
                                            }
                                            $sensornamecount++;
                                        }
                                    }
                                    if (!empty($sensornames)) {
                                        $str = array_pop($sensornames);
                                        $str = implode(', ', $sensornames)." and ".$str;
                                        echo $str;
                                    }
                                }else{
                                    foreach ($sensorss as $sensor) {
                                        if ($sensorids[0] == $sensor->id) {
                                            $sensorname = $sensor->address;
                                        }
                                    }
                                }
                                echo ucfirst(strtolower($sensorname)).',';
                            ?>

                            @foreach($allprovinces as $province)                                               
                                @if($province->id == $bynotification->province_id)
                                    <?php echo strtoupper($province->name);?>
                                @endif
                            @endforeach
                        </span>
                        <span>
                            <?php echo $ncbody[1];?>
                        </span>
                        <span>
                           <?php 
                                $sensorvalues = [];
                                $sensorvaluescount = 0;
                                $sensorvalue = '';
                                $sensordatas = unserialize($bynotification->sensorvalues);

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
                        <span>
                            <?php echo $ncbody[2];?>
                        </span>
                        <span>
                            @foreach($floodthresholds as $floodthreshold)
                                @if($bynotification->floodthresholdid == $floodthreshold->id)
                                    <?php 
                                        $barangays = [];
                                        $barangaycounter = 0;


                                        $locationsatrisk = unserialize($floodthreshold->areas_affected); ?>

                                    @foreach($locationsatrisk as $locationatrisk )
                                        @foreach($proneareas as $pa)
                                            @if($pa->id == $locationatrisk)
                                                <?php $barangays[$barangaycounter++] = $pa->address; ?>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endif
                            @endforeach

                            <?php
                                if (count($barangays) >= 2) {
                                   if (!empty($barangays)) {
                                        $str = array_pop($barangays);
                                        $str = implode(', ', $barangays)." and ".$str;
                                        echo '<strong>'.$str.'</strong>.';
                                    }
                                }else{
                                    echo '<strong>'.$barangays[0].'</strong>.';
                                }
                                
                                
                            ?>
                        </span>

                        


                                                                             
                   </p>    



                <p class="time"><i class="fa fa-clock-o"></i>
                {{  \Carbon\Carbon::createFromTimeStamp(strtotime($bynotification->created_at))->diffForHumans() }}</p>                                        
                            </div>
                        </div>
                    </a>




            @endif  
        @endif
    @endforeach   
</li>                        
                        <li class="message-footer">
                            <a href="{{ action("SMSController@viewAllNotifications") }}" class="text-center">View all Notifications</a>
                        </li>
                    </ul>
                </div>
</div>
@endsection