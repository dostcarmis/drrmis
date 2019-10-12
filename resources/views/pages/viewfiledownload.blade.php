@extends('layouts.masters.homepagedesign-layout')
@section('page-content')
<div class="container">
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header"><b>Download DRRM related Files</b></h1>			
		<div class="col-xs-12 np"><a href="#" data-toggle="modal" data-target="#addModal" class="btn btn-viewupload">+ Add New File</a></div>
				 	
		<p style="color:green"><?php echo Session::get('success_upload'); ?></p>
			@foreach ($errors->all() as $message)
				<p style="color:red">{{ $message }}</p>
			@endforeach
		@include('pages.adddrrmfile')

<div class="col-xs-12  col-sm-12 ">
	<table class=" table table-hover tblehead">
		<thead>
			<tr>
				<th>Filename</th>
				<th>Filetype</th>
				<th>Uploader</th>
				<th></th> 
			</tr>	                                                                                
		</thead>
		<tbody>
			@foreach($files as $file)
			<tr>
				<td><div class="text_holder"><a target="_blank" href="{{ url($file->fileurl) }}">{{$file->filename}}</a></div></td>
				<td><p><span>{{$file->filetype}}</span></p></td>
				<td><span>{{$file->name}}</span>
					<td><div class="btn-group pull-right">
						@if($file->uploadedby == $currentUser->id)
						<a class="delete btn btn-danger" onclick="$(this).delfile({{ $file->id }});">Delete</a>
						@endif
						<a class="btn btn-primary btn-success"  target="_self" href="{{ url($file->fileurl) }}" download><span class="fa fa-cloud-download"></span>Download File</a>		
					 	</div></td>
			</tr>				
			@endforeach
	</table>
</div>

	</div>
</div>
</div>

<form id="delete-file" method="POST" action="">
    {{ csrf_field() }}
</form>

@include('pages.successdeletefilemodal')
@endsection
@section('page-js-files')
	@if (!empty(session('success_delete')))
	<script> 
	$(function(){
		$("#modalSuccess").modal();
	});
	</script>
	@endif
@endsection



