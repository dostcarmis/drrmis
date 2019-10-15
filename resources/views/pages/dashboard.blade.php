@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="wrap">
    <div class="row">
        <div class="col-xs-12 dashboardtitle">
            <h1>
                Dashboard
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-12 dashboardpanel">
                <h2>Welcome {{$currentUser->first_name}} {{$currentUser->last_name}}</h2>
                <div class="col-xs-12 np">
                    <div class="col-xs-12 col-sm-4 dashboard-3-column">
                        <h3>Get Started</h3>
                        <div class="col-xs-12 np">
                            <a href="{{action('HydrometController@viewHydrometdata')}}" class="btn btn-primary btn-getstarted">Monitor Sensors</a>
                        </div>
                        <div class="col-xs-12 np">
                            <span class="defsp spviewsite">or <a href="{{action('PagesController@home')}}"><i class="fa fa-eye" aria-hidden="true"></i> View map</a> </span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 dashboard-3-column">
                        <h3>Quick Links</h3>
                        <ul>
                            <li><a href="{{action('LandslideController@viewaddLandslide')}}"><span class="glyphicon glyphicon-plus-sign"></span> Add Landslide Report</a></li>
                            <li><a href="{{action('FloodController@viewaddFlood')}}"><span class="glyphicon glyphicon-plus-sign"></span> Add Flood Report</a></li>
                            <li><a href="{{action('RoadController@viewaddRoadnetwork')}}"><span class="glyphicon glyphicon-plus-sign"></span> Add Road Network Report</a></li>
                            <li><a href="{{action('ReportController@showReport')}}"><span class="fa fa-download"></span> Download Sensors Data</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-4 dashboard-3-column">
                        <h3>Other DRRM Websites</h3>
                        <ul class="drrmlinks">
                            <li><a href="http://www.pagasa.dost.gov.ph/" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> PAGASA</a></li>
                            <li><a href="http://www.phivolcs.dost.gov.ph/" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> PHIVOLCS</a></li>
                            <li><a href="http://fmon.asti.dost.gov.ph/" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> PREDICT</a></li>
                            <li><a href="http://climatex.dost.gov.ph/" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> ClimateX</a></li>
                            <li><a href="http://noah.dost.gov.ph/" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> NOAH</a></li>
                            <li><a href="https://dream.upd.edu.ph/" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> DREAM</a></li>   
                            <li><a href="https://lipad.dream.upd.edu.ph/" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> LIPAD</a></li> 
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- /.row -->
<div class="row">
     <div class="col-xs-12 col-sm-4 col-lg-4 dshboacol">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="demo-icon"></i> Critical Sensor Readings</h3>
            </div>
            <div class="panel-body">
                <div id="morris-donut-chart"></div>
                <div class="text-right">
                    <a href="{{action('HydrometController@viewHydrometdata')}}">View Details <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-lg-4 dshboacol">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list-ul" aria-hidden="true"></i> Latest Updates</h3>
            </div>
            <div class="panel-body"> 
            <?php
                    $x = 0 ;
                    $y = 0;
                    $z = 0;
                    ?>  
                <span class="defsp rpublished">Recently Published</span>
                <span class="defsp perpublished">
                    <span class="defsp perpublishedtitle">Road Networks</span>                    
                    <ul>
                        @foreach($roadnetworks as $roadnetwork)
                            @if($x < 2)
                                <div class="col-xs-12 np perpublished-wrap">
                                    <span class="perpublished-rtime"><?php echo date("F j Y g:ia", strtotime($roadnetwork->date));?></span>
                                    <span class="perpublished-rname">{{$roadnetwork->location}}</span>
                                    <span class="perpublished-status">{{$roadnetwork->status}}</span>
                                </div>
                            @endif
                        <?php $x++; ?>
                        @endforeach
                    </ul>
                </span>
                <span class="defsp perpublished">
                    <span class="defsp perpublishedtitle">Landslides</span>                    
                    <ul>
                        @foreach($landslides as $landslide)
                            @if($y < 2)
                                <div class="col-xs-12 np perpublished-wrap">
                                    <span class="perpublished-ltime"><?php echo date("F j Y g:ia", strtotime($landslide->date));?></span>
                                    <span class="perpublished-lname"><a href="<?php echo('viewperlandslide');?>/{{$landslide->id}}" title="{{$landslide->road_location}}">{{$landslide->road_location}}</a></span>
                                </div>
                            @endif
                        <?php $y++; ?>
                        @endforeach
                    </ul>
                </span>
                <span class="defsp perpublished">
                    <span class="defsp perpublishedtitle">Floods</span>                    
                    <ul> 
                        @foreach($floods as $flood)
                            @if($z < 2)
                                <div class="col-xs-12 np perpublished-wrap">
                                    <span class="perpublished-ltime"><?php echo date("F j Y g:ia", strtotime($flood->date));?></span>
                                    <span class="perpublished-lname"><a href="<?php echo('viewperflood');?>/{{$flood->id}}" title="{{$flood->road_location}}">{{$flood->road_location}}</a></span>
                                </div>
                            @endif
                        <?php $z++; ?>
                        @endforeach
                    </ul>
                </span>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-4 col-lg-4 dshboacol">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">At a Glance</h3>
            </div>
            <div class="panel-body">               
                <div class="col-xs-12 np ataglance">
                    <ul>
                        <li><i class="fa fa-road" aria-hidden="true"></i> <a href="{{action('RoadController@viewRoadnetworks')}}"><?php echo count($roadnetworks); ?> Roadnetworks</a></li>
                        <li><i class="fa fa-files-o" aria-hidden="true"></i> <a href="{{action('LandslideController@viewLandslides')}}"><?php echo count($landslides); ?> Landslide Reports</a></li>
                        <li><i class="fa fa-files-o" aria-hidden="true"></i> <a href="{{action('FloodController@viewFloods')}}"><?php echo count($floods); ?> Flood Reports</a></li>   
                        <li><i class="fa fa-users" aria-hidden="true"></i> <a href="{{action('UserController@viewusers')}}"><?php echo count($users);?> Users</a></li>
                        <li><i class="demo-icon"></i> <a href="{{action('HydrometController@viewHydrometdata')}}"><?php echo count($sensors); ?> Total Sensors</a></li>
                        
                        <!--<?php  $nonworking = 0; ?>

                        @foreach($mainarray as $arr)
                            @if($arr['filestatus'] == 'no_data')
                                <?php $nonworking++; ?>
                            @endif
                        @endforeach
                        @if($nonworking > 0)
                        <li><i class="demo-icon" style="color:#ff0000;"></i> <a href="<?php echo url('filterdata?provincefilter=0&categorytitle=0&statustitle=2&filter_table=Filter&searchall="'); ?>"><?php echo $nonworking; ?> Not Working Sensors</a></li>
                        @endif-->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@stop 
@section('page-js-files')
<script src="{!! url('assets/js/dashboarddata.js') !!}"></script>
@stop