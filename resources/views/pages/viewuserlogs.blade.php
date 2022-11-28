@extends('layouts.masters.backend-layout')
@section('page-content')
<style>
      .dataTables_wrapper .row:first-child{display: unset;}
</style>
<div class="row">
	<div class="col-xs-12">
		<h2 class="page-header"><b>Users Activity</b></h2>
            <table class="table table-hover tbldashboard"  id="riskftable">
                  <thead>
                        <tr>
                              <th>User ID</th>
                              <th>User Full Name</th>
                              <th>Link</th>
                              <th>Method</th>
                              <th>User Agent</th>
                              <th>Municipality</th>
                              <th>Province</th>
                              <th>Activity Name</th>
                              <th>Date Log</th>
                        </tr>                                                         
                  </thead>
                  <tbody>
                        @foreach($logs as $log)     
                        <tr>
                              <td>{{$log->userid ? $log->userid : 'Guest'}}</td>
                              <td>{{$log->userfullname ? $log->userfullname : 'Guest'}}</td>
                              <td>{{$log->request}}</td>
                              <td>{{$log->method}}</td>
                              <td>{{$log->useragent}}</td>
                              <td>{{$log['province'] ? json_decode($log['province'])->name : ''}}</td>
                              <td>{{$log['municipal'] ? json_decode($log['municipal'])->name : ''}}</td>        
                              <td>{{$log->remarks}}</td>
                              <td>{{$log->logged_at}}</td>
                        </tr>	
                        @endforeach
                  </tbody>
            </table>
      
	</div>
</div>
@endsection
@section('page-js-files')
<script>
      $(document).ready(function(){
            $('#riskftable').DataTable({
                  lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'All'],
                  ],
                  "columns": [
                        { "searchable": false },
                        null,
                        { "searchable": false },
                        { "searchable": false },
                        { "searchable": false },
                        { "searchable": false },
                        { "searchable": false },
                        { "searchable": false },
                        { "searchable": false }
                  ]
            });
      })
      
</script>

@endsection
