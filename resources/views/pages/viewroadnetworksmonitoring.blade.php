@extends('layouts.masters.frontend-layouts')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<div class="col-xs-12 np col-sm-8"><h1>Road Networks </h1></div>
		<div class="col-xs-12 col-sm-4 searchright">
			<div class="input-group">
				<div class="input-group-btn search-panel">
                    <button type="button" class="btn btn-default btn-filtersearch dropdown-toggle" data-toggle="dropdown">
                    	<span id="search_concept">Filter by</span> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#recent">Recent</a></li>
                      <li><a href="#old">Old</a></li>
                    </ul>
                </div>				  
			  <input class="form-control" id="searchroadnetwork" type="text" name="searchroadnetwork" placeholder="Search">
			  <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
			</div>
		</div>
	</div>
<div class="allwrap">
	<div class="panel-group pnlroadreports" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Recent Road Reports <span class="caret"></span>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
      <?php $counter = 0; ?>
        @foreach($roadnetworks as $roadnetwork)
          <?php
            $class = $roadnetwork->status;
            $class  = strtolower(str_replace(' & ', '-', $class));
            $class  = strtolower(str_replace(' ', '-', $class));
            $classother = $roadnetwork->latest_status;
            $classother  = strtolower(str_replace(' & ', '-', $classother));
            $classother  = strtolower(str_replace(' ', '-', $classother));
            
          ?>
          @if($roadnetwork->latest_status == '')
          <?php $counter = 1; ?>
          <div class="col-xs-12 col-sm-12 col-sm-12 np per-monitoring">
            <div class="col-xs-12 np per-monitoringwrap">
              <div class="col-xs-12 per-monitoringwrap-title">
                <div class="col-xs-6 np"><span class="defsp spstatus {{$class}}">{{ $roadnetwork->status }}</span>  </div>
                <div class="col-xs-6 np"><span class="defsp sptimeanddate"><?php echo date("F j Y g:i A", strtotime($roadnetwork->date));?></span></div>
              </div>
              <div class="col-xs-12 per-monitoringwrap-details">
                <span class="defsp splocation">{{ $roadnetwork->location }}</span>
                <span class="defsp spdesc">{!! $roadnetwork->description !!}</span>           
              </div>
              <div class="col-xs-12 per-monitoring-blw">
                <span>Source: <span>{{ $roadnetwork->author }}</span></span> | <span>Uploaded by: 
                @foreach($users as $user)
                  @if($roadnetwork->user_id === $user->id)
                    <span>{{$user->last_name}}</span>
                  @endif
                @endforeach
                </span>
              </div>              
            </div>
          </div>
          
          @endif    
        @endforeach
        @if($counter == 0)
        <span  class="defsp" style="margin-top: 15px;">No current road reports.</span>
        @endif




      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Old Road Reports <span class="caret"></span>
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        @foreach($roadnetworks as $roadnetwork)
          <?php
            $class = $roadnetwork->status;
            $class  = strtolower(str_replace(' & ', '-', $class));
            $class  = strtolower(str_replace(' ', '-', $class));
            $classother = $roadnetwork->latest_status;
            $classother  = strtolower(str_replace(' & ', '-', $classother));
            $classother  = strtolower(str_replace(' ', '-', $classother));
          ?>
          @if($roadnetwork->latest_status != '')
          <div class="col-xs-12 col-sm-12 col-sm-12 np per-monitoring">
            <div class="col-xs-12 np per-monitoringwrap">
              <div class="col-xs-12 per-monitoringwrap-title">
                <div class="col-xs-6 np"><span class="defsp spstatus {{$classother}}">{{ $roadnetwork->latest_status }}</span>  </div>
                <div class="col-xs-6 np"><span class="defsp sptimeanddate"><?php echo date("F j Y g:i A", strtotime($roadnetwork->recent_date));?></span></div>
              </div>
              <div class="col-xs-12 per-monitoringwrap-details">
                <span class="defsp splocation">{{ $roadnetwork->location }}</span>
                <span class="defsp spdesc">{!! $roadnetwork->description !!}</span>           
              </div>
              <div class="col-xs-12 per-monitoring-blw">
                <span>Source: <span>{{ $roadnetwork->author }}</span></span> | <span>Uploaded by: 
                @foreach($users as $user)
                  @if($roadnetwork->user_id === $user->id)
                    <span>{{$user->last_name}}</span>
                  @endif
                @endforeach
                </span>
              </div>
              <div class="col-xs-12 per-monitoring-blw">
                <span class="defsp">Old Status: <span>{{ $roadnetwork->status }}</span></span>
                <span class="defsp">Date: <span><?php echo date("F j Y g:i A", strtotime($roadnetwork->date));?></span></span>
              </div>
              <div class="col-xs-12 per-monitoring-blw">
                <span>Source: <span>{{ $roadnetwork->author }}</span></span> | <span>Uploaded by: 
                @foreach($users as $user)
                  @if($roadnetwork->user_id === $user->id)
                    <span>{{$user->last_name}}</span>
                  @endif
                @endforeach
                </span>
              </div>
              
            </div>
          </div>
          @endif    
        @endforeach





        
      </div>
    </div>
  </div>
</div>
</div>
	
</div>
 @stop
