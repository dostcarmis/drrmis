@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header notifications-header">Your Notifications</h1>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 notifications-wrap">
		@foreach($notifications as $notification)
			@if(Auth::user()->id == $notification->user_id)
			@if($notification->is_read != 0)
				<div class="col-xs-12 notifications-row">
				@else
				<div class="col-xs-12 notifications-row unread">
				@endif		
					<span class="defsp spnotifmessage">
					<?php
						$icon = '';
					?>
						 <span>
						 	@foreach($allmunicipalities as $municipality)                                               
                                @if($municipality->id == $notification->municipality_id)
                                    {{$municipality->name}},
                                @endif
                            @endforeach
                            @foreach($allprovinces as $province)                                               
                                @if($province->id == $notification->province_id)
                                    {{$province->name}}
                                @endif
                            @endforeach
						 </span>

						@foreach($notificationcontents as $notificationcontent)
							@if($notificationcontent->id == $notification->nc_id)
								<span>{!!$notificationcontent->body!!}</span>
								<?php $icon = $notificationcontent->icon;?>
							@endif
						@endforeach	
						<span>
                            @foreach($thresholds as $threshold)
                                @if($threshold->address_id == $notification->sensor_id)
                                    {{$threshold->threshold_landslide}}
                                @endif
                            @endforeach
                        </span>
                        <span>
                            to <strong>{{$notification->value }}mm</strong>.
                        </span>
			
					</span>
					<span class="defsp spnotiftime">{!!$icon!!}
					 <?php echo date("F j Y", strtotime($notification->sent_at));?> at <?php echo date("g:i A", strtotime($notification->sent_at));?>
					 	
					 </span>
					
					
				</div>
			@endif
		@endforeach
	</div>
</div>
@stop