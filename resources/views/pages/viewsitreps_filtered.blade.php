
{{--  --}}

<div class="row xs-d-none sm-d-none">
	<div class="col-xs-12  col-sm-12 ">
		<table class=" table table-hover tblehead" id="sitrep_table">
			<thead>
				<tr>
					<th>Filename {{Auth::user()->role_id}}</th>
					<th>Risk Type</th>
					<th>Typhoon</th>
					<th>Level</th>
					<th>Uploader</th>
					<th></th> 
				</tr>	                                                                                
			</thead>
			<tbody>
				@foreach($filtered as $sitreps)
				<tr>
					<td><div class="text_holder"><a target="_blank" href="{{ url($sitreps->fileurl) }}">{{$sitreps->filename}}</a></div></td>
					<td><p><span>{{$sitreps->risk_type}}</span></p></td>
					<td><p><span>{{$sitreps->typhoon_name}}</span></p></td>
					<td><p><span>{{$sitreps->sitrep_level}}</span></p></td>
					<td><span>{{$sitreps->user_name($sitreps->uploadedby)}}</span>
						<td><div class="btn-group pull-right" style="min-width: 200px">
							@if($sitreps->uploadedby == Auth::user()->id)
							<a class="delete btn btn-danger" onclick="$(this).delsitrep({{ $sitreps->id }});" >Delete</a>
							@endif
							<a class="btn btn-primary btn-success"  target="_self" href="{{ url($sitreps->fileurl) }}" download><span class="fa fa-cloud-download"></span>Download File</a>		
							</div></td>
				</tr>				
				@endforeach
		</table>
	</div>
</div>

<div class="row xs-d-block sm-d-block md-d-none">
	<div class="col">
		@foreach ($filtered as $sitreps)
			<div class="panel panel-default">
				<div class="panel-heading">
					<a target="_blank" href="{{ url($sitreps->fileurl) }}" class="">{{$sitreps->filename}}</a>
				</div>
				<div class="panel-body">
					<strong>RiskType:</strong>{{$sitreps->risk_type}}<br>
					<strong>Typhoon:</strong>{{$sitreps->typhoon_name}}<br>
					<strong>Level:</strong>{{$sitreps->sitrep_level}}<br>
					<strong>Uploader:</strong>{{$sitreps->user_name($sitreps->uploadedby)}}<br>
				</div>
				<div class="panel-footer text-right bg-white border-none">
					@if($sitreps->uploadedby == Auth::user()->id)
					<a class="delete btn btn-sm btn-danger" onclick="$(this).delsitrep({{ $sitreps->id }});" >Delete</a>
					@endif
					<a class="btn btn-sm btn-success "  target="_self" href="{{ url($sitreps->fileurl) }}" download><span class="fa fa-cloud-download"></span>Download<span class="xs-d-none sm-d-none"> File</span></a>	
				</div>
			</div>
		@endforeach
	</div>
</div>