@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Flood Threshold</h1>
	</div>
	<form action="{{action('ThresholdFlood@destroymultipleThresholdFlood') }}">
	<div class="col-xs-12">
		<p style="color:red"><?php echo Session::get('message'); ?></p>
		<div class="col-xs-12 ulpaginations np">
			<div class="col-xs-8 np">
				<a id="btnadd-location" title="Add Threshold" class="btnadd-location btn" href="{{action('ThresholdFlood@viewaddThresholdFlood')}}"><span class="glyphicon glyphicon-plus"></span> Add Threshold</a>

<button disabled="disabled" type="submit" class="btn btn-deleteselected" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>			
			</div>
			<div class="col-xs-4 text-right np">
				<div class="col-xs-12 col-sm-10 col-sm-offset-2 text-right">
					<div class="input-group">				  
					  <input type="text" class="form-control" placeholder="Search" id="searchall" name="searchall" >
					  <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
					</div>
			    </div>
			</div>
		</div>
		
		<table class="table table-hover tblthreshold"  id="dashboardtables">
			<thead>
				<th class="no-sort"><input type="checkbox" class="headcheckbox"></th>
				<th class="desc">Locations at Risk</th>
				<th>Sensor Sources</th>
				<th>Flood Values</th>
				<th>Date</th>
			</thead>
			<tbody>					
				@foreach($thresholdfloods as $thval)
					<?php 
						$affectedareas = unserialize($thval->areas_affected); 
						$sourcesensors = unserialize($thval->sensor_sources); 
					?>
				<tr>
					<td><input class="chbox" name="chks[]" value="{{$thval->id}}" type="checkbox"></td>					
					<td>
					<a class="desctitle" href="<?php echo url('editthresholdflood'); ?>/<?php echo $thval->id?>">	
						<?php $resultstr = array(); ?>
						@foreach($affectedareas as $affectedarea)
							@foreach($floodproneareas as $floodpronearea)
								@if($affectedarea == $floodpronearea->id)
									<?php $resultstr[] =  $floodpronearea->address ?>
								@endif
							@endforeach
						@endforeach
						<?php echo implode(", ",$resultstr); ?>
					</a>
					<span class="defsp spactions">
						<div class="inneractions">
							<a href="<?php echo url('editthresholdflood'); ?>/<?php echo $thval->id; ?>">Edit</a> | 
							<a class="deletepost" href="#" id="{{$thval->id}}" value="{{$thval->id}}" title="Delete">Delete</a>
						</div>								
					</span>
					
					</td>
					<td>
						<?php $sensorname = array(); ?>
						@foreach($sourcesensors as $sourcesensor)
							@foreach($sensors as $sensor)
								@if($sourcesensor[0] == $sensor->id)
									<?php $sensorname[] = $sensor->address ?>
								@endif
							@endforeach
						@endforeach
						<?php 
						echo implode(" - ",$sensorname);
						?>
					</td>
					<td>		
						<?php 
						$resultstr = array();

						foreach ($sourcesensors as $sourcesensor) {
						  $resultstr[] = $sourcesensor[1].'mm';
						}

						echo implode(" - ",$resultstr);

						?>
					

					</td>
					<td><?php echo date("F j, Y g:i A", strtotime($thval->created_at));?></td>	
				</tr>
				@endforeach		

				@include('pages.deletethresholdflood')
			</tbody>
		</table>
	</div>
	</form>
</div>

 @stop