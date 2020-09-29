@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h2 class="page-header"><b>Users Activity</b></h2>			
		
<div class="col-xs-12  col-sm-12">
	<table class="table table-hover tbldashboard"  id="riskftable">
		<thead>
            <th>User ID</th>
            <th>User Full Name</th>
            <th>Link</th>
            <th>Method</th>
            <th>User Agent</th>
            <th>Municipality</th>
            <th>Province</th>
            <th>Activity Name</th>
            <th>Date Log</th>
				<th></th>                                                                                 
		</thead>
		<tbody>
			
                  @foreach($logs as $log)     
			<tr>
                <td>{{$log->userid ? $log->userid : 'Null'}}</td>
                <td>{{$log->userfullname ? $log->userfullname : 'Guest'}}</td>
                <td>{{$log->request}}</td>
                <td>{{$log->method}}</td>
                <td>{{$log->useragent}}</td>
                <td>{{$log['municipal']->municipal_name}}</td>
                <td>{{$log['province']->province_name}}</td>        
                <td>{{$log->remarks}}</td>
                <td>{{$log->logged_at}}</td>
			</tr>	
                  @endforeach


	</table>
</div>

	</div>
</div>

@endsection
