{{-- @extends('layouts.masters.homepagedesign-layout')
@section('page-content') --}}
<div class="container">
	<style>
		.dataTables_wrapper .row:first-child{display: unset; /* color: white; */}
		/* .dataTables_info{color:white;} */
	</style>
	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<h1 class="page-header"><b>Download Situational Reports</b></h1>		
			<p style="color:green" class="xs-mt-3 sm-mt-3"><?php echo Session::get('success_upload'); ?></p>
				@foreach ($errors->all() as $message)
					<p style="color:red" class="sm-mt-3">{{ $message }}</p>
				@endforeach
			@include('pages.addsitrep')
		</div>
	</div>
	<div class="row" style="margin-top:1rem">
		<div class="col-xs-12">
			<div class="input-group xs-d-none sm-d-none" style="width: 50%; float:left">
				<div class="input-group-addon"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
				<form id="searchFileForm">
					<input type="text" class="form-control" placeholder="Search file" id="searchFileName" kind="sitrep">
				</form>
			</div>
			<a href="#" data-toggle="modal" data-target="#addsitrepModal" class="btn btn-viewupload" style="float: right;"><span class="md-d-inline">+ Add</span><span class="xs-d-none sm-d-none md-d-inline"> New Sitrep</span></a>
		</div>
	</div>
    
	<div id="fileslist">
		<div class="xs-d-none sm-d-none md-d-block">
			<table class=" table table-hover tblehead tbldashboard" id="sitrep_table">
				<thead>
					<tr>
						<th title="Sort by Filename">Filename</th>
						<th title="Sort by Risk Type">Risk Type</th>
						<th title="Sort by Typhoon">Typhoon</th>
						<th title="Sort by Level">Level</th>
						<th title="Sort by Uploader">Uploader</th>
						<th>#</th> 
					</tr>	                                                                                
				</thead>
				<tbody>
					@foreach($sitrep as $sitreps)
					<tr>
						<td><div class="text_holder"><a target="_blank" href="{{ url($sitreps->fileurl) }}">{{$sitreps->filename}}</a></div></td>
						<td><p><span>{{$sitreps->risk_type}}</span></p></td>
						<td><p><span>{{$sitreps->typhoon_name}}</span></p></td>
						<td><p><span>{{$sitreps->sitrep_level}}</span></p></td>
						<td><span>{{$sitreps->uploader->first_name." ".$sitreps->uploader->last_name}}</span>
							<td><div class="btn-group pull-right" style="min-width: 200px">
								@if($sitreps->uploadedby == Auth::user()->id)
								<a class="delete btn btn-danger sitrep-del-btn" sit-id="{{$sitreps->id}}" >Delete</a>
								@endif
								<a class="btn btn-primary btn-success"  target="_self" href="{{ url($sitreps->fileurl) }}" download>Download</a>		
								</div></td>
					</tr>				
					@endforeach
				</tbody>
			</table>
		</div>
	
		<div class="row xs-d-block sm-d-block md-d-none">
			<div class="col">
				@foreach ($sitrep as $s)
					<div class="panel panel-default">
						<div class="panel-heading">
							<a target="_blank" href="{{ url($s->fileurl) }}" class="">{{$s->filename}}</a>
						</div>
						<div class="panel-body">
							<strong>RiskType:</strong>{{$s->risk_type}}<br>
							<strong>Typhoon:</strong>{{$s->typhoon_name}}<br>
							<strong>Level:</strong>{{$s->sitrep_level}}<br>
							<strong>Uploader:</strong>{{$s->name}}<br>
						</div>
						<div class="panel-footer text-right bg-white border-none">
							@if($s->uploadedby == Auth::user()->id)
							<a class="delete btn btn-sm btn-danger sitrep-del-btn" sit-id="{{$s->id}}" >Delete</a>
							@endif
							<a class="btn btn-sm btn-success "  target="_self" href="{{ url($s->fileurl) }}" download><span class="fa fa-cloud-download"></span>Download<span class="xs-d-none sm-d-none md-d-block"> File</span></a>	
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
	
</div>
<div class="whiteblock md-d-none"></div>
<form id="delete-sitrep" method="POST" action="" url = {{url()->current()}}>
    {{ csrf_field() }}
</form>
<script>
	$('.sitrep-del-btn').on('click',function(){
		var r = confirm("Are you sure you want to delete this sitrep?");
		if (r == true){
			let id = $(this).attr('sit-id');
			let cur = $('#delete-sitrep').attr('url');
			if(cur.search("provincial") == -1 && cur.search('regional') == -1 && cur.search('municipal') == -1)
				var url = "sitreps/deletesitrep/" + id;
			else
				var url = "deletesitrep/" + id;
			$('#delete-sitrep').attr('action' , url).submit();
			//console.log(url);
		}
	})
	
</script>
@include('pages.successdeletesitrepmodal')
<script src="{{asset('assets/js/filemanagement.js')}}"></script>
{{-- @endsection --}}
@section('page-js-files')
	
	@if (!empty(session('success_delete')))
	<script> 
	$(function(){
		$("#modalSuccessDelSitrep").modal();
	});
	</script>
	@endif
@endsection