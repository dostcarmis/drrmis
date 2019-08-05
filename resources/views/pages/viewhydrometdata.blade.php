@extends('layouts.masters.backend-layout')
@section('page-content')
    <div class="row">
        <div id="dashboard" class="col-xs-12">
            <h1 class="page-header">Hydromet Data (Rain Gauge)</h1>
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
        		<a href="{{ action('HydrometController@viewHydrometdatawaterlevel')}}" class="btn btn-sensorclick">Click to view Waterlevel</a>
        	</div>
        	<div class="col-xs-12 col-sm-4 searchhydro">
				<div class="input-group">				  
				  <input class="form-control" id="hydrometsearch" type="text" name="searchall" placeholder="Search">
				  <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
				</div>
			</div>
        </div>
        <form action="{{ action('HydrometController@Filterdata')}}">
        
	        <div class="col-xs-12  col-sm-12">
	         	<table class="table table-hover tbldashboard"  id="hydromettable">
    				<thead>	
                        <th class="hidden">ID</th>
                        <th class="sorting">Status</th>
                        <th class="sorting">Address</th>
                        <th class="sorting">Sensor Type</th>
                        <th>Current Reading</th>
                        <th>Cumulative</th>
                        <th>Past 2 days</th>
                        <th>Remarks</th>    				
    				</thead>
    				<tbody>	
    			         @foreach($rainData['data'] as $rainValue)
                         <tr>
                            <td class="hidden"><span data-value="{{$rainValue['id']}}">{{$rainValue['id']}}</span></td>
                            <td><span class="stat {{$rainValue['status']}}">{{$rainValue['status']}}</span></td>
                            <td>{{$rainValue['address']}}</td>
                            <td>{{$rainValue['sensortype']}}</td>
                            <td>{{$rainValue['current']}}</td>
                            <td>{{$rainValue['cumulative']}}</td>
                            <td>{{$rainValue['past2days']}}</td>
                            <td>{{$rainValue['remarks']}}</td>
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
