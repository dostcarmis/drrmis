@extends('layouts.masters.homepagedesign-layout')
@section('page-content')
<div class="container">
	<style>
		.dataTables_wrapper .row:first-child{display: unset; color: white;}
		.dataTables_info{color:white;}
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
		<div class="row xs-d-none sm-d-none md-d-block">
			<div class="col-xs-12  col-sm-12 ">
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
							<td><span>{{$sitreps->name}}</span>
								<td><div class="btn-group pull-right" style="min-width: 200px">
									@if($sitreps->uploadedby == Auth::user()->id)
									<a class="delete btn btn-danger" onclick="$(this).delsitrep({{ $sitreps->id }});" >Delete</a>
									@endif
									<a class="btn btn-primary btn-success"  target="_self" href="{{ url($sitreps->fileurl) }}" download><span class="fa fa-cloud-download"></span>Download File</a>		
									</div></td>
						</tr>				
						@endforeach
					</tbody>
				</table>
			</div>
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
							<a class="delete btn btn-sm btn-danger" onclick="$(this).delsitrep({{ $s->id }});" >Delete</a>
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
@include('pages.successdeletesitrepmodal')
@endsection
@section('page-js-files')
	<script src="{{asset('assets/js/filemanagement.js')}}"></script>
	@if (!empty(session('success_delete')))
	<script> 
	$(function(){
		$("#modalSuccessDelSitrep").modal();
	});
	</script>
	@endif
@endsection