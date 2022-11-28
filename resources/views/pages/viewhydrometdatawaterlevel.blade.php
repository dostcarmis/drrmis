@extends('layouts.masters.backend-layout')
@section('page-content')
    <div class="row">
        <div id="dashboard" class="col-xs-12">
            <h1 class="page-header">Hydromet Data (Waterlevel)</h1>
        </div>
        <div class="col-xs-12 filtersection" style="margin-bottom:10px;">
        	<div class="col-xs-12 col-sm-2 filtertable np">
        		<select class="form-control" id="filterstatus">
        			<option value="">All Status</option>
        			<option value="with_data">Working</option>
        			<option value="no_data">Not Working</option>
        		</select>
        	</div>
        	<div class="col-xs-12 col-sm-2 filtersensor">
        		<a href="{{ action('HydrometController@viewHydrometdata')}}" class="btn btn-sensorclick">Click to view Rain Gauge</a>
        	</div>
        	<div class="col-xs-12 col-sm-4 searchhydro">
				<div class="input-group">				  
                    <form action="" id="hydrometsearchform">
                        <input class="form-control" id="hydrometsearch" type="text" name="searchall" placeholder="Search">
                    </form>
                    <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
				</div>
			</div>
        </div>
        <form>        
	        <div class="col-xs-12  col-sm-12">
	         	<table class="table table-hover tbldashboard"  id="hydromettable">
    				<thead>	
                        <th class="hidden">ID</th>
                        <th class="sorting">Status</th>
                        <th class="sorting">Address</th>
                        <th class="sorting">Sensor Type</th>
                        <th>Current Reading (Meters)</th>
                        <th>Normal Value</th>
                        <th>Level 1</th>
                        <th>Level 2</th> 
                        <th>Critical</th> 
                        <th>Remarks</th>   				
    				</thead>
    				<tbody>	    			         
                         @foreach($waterData['data'] as $waterValue)
                         <tr>
                            <td class="hidden"><span data-value="{{$waterValue['id']}}">{{$waterValue['id']}}</span></td>
                            <td><span class="stat {{$waterValue['status']}}">{{$waterValue['status']}}</span></td>
                            <td>{{$waterValue['address']}}</td>
                            <td>{{$waterValue['sensortype']}}</td>
                            <td>{{$waterValue['current']}}</td>
                            <td>{{$waterValue['normal_val']}}</td>
                            <td>{{$waterValue['level1_val']}}</td>
                            <td>{{$waterValue['level2_val']}}</td>
                            <td>{{$waterValue['critical_val']}}</td>
                            <td>{{$waterValue['remarks']}}</td>
                         </tr>
                         @endforeach
                         
    				</tbody>
    			</table>
	        </div>
        </form>
    </div>
@stop
@section('page-js-files')
<script src="{{ asset('assets/js/viewsensor.js') }}"></script>
@stop
