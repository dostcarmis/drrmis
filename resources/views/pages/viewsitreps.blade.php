@extends('layouts.masters.homepagedesign-layout')
@section('page-content')
<div class="container">
<div class="col-xs-12">
		<h1 class="page-header"><b>Download Situational Reports</b></h1>			
		<div class="col-xs-12 np"><a  data-toggle="modal" data-target="#addsitrepModal" class="btn btn-viewupload">+ Add New Sitrep</a></div>
				 	
		<p style="color:green"><?php echo Session::get('success_upload'); ?></p>
			@foreach ($errors->all() as $message)
				<p style="color:red">{{ $message }}</p>
			@endforeach
        @include('pages.addsitrep')

        
        
<div class="col-xs-12  col-sm-12 ">
	<table class=" table table-hover tblehead">
		<thead>
			<tr>
				<th>Filename</th>
                <th>Risk Type</th>
                <th>Typhoon</th>
                <th>Level</th>
				<th>Uploader</th>
				<th></th> 
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
					<td><div class="btn-group pull-right">
						@if($sitreps->uploadedby == $currentUser->id)
						<a class="delete btn btn-danger" onclick="$(this).delsitrep({{ $sitreps->id }});" >Delete</a>
						@endif
						<a class="btn btn-primary btn-success"  target="_self" href="{{ url($sitreps->fileurl) }}" download><span class="fa fa-cloud-download"></span>Download File</a>		
					 	</div></td>
			</tr>				
			@endforeach
	</table>
</div>

	</div>
</div>
</div>
<form id="delete-sitrep" method="POST" action="">
    {{ csrf_field() }}
</form>
@include('pages.successdeletesitrepmodal')
@endsection
@section('page-js-files')
	@if (!empty(session('success_delete')))
	<script> 
	$(function(){
		$("#modalSuccessDelSitrep").modal();
	});
	</script>
	@endif
@endsection