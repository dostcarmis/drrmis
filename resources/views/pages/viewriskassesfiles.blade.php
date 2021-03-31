@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h2 class="page-header"><b>Upload & Download Risk Assesment Files</b></h2>			
		<div class="col-xs-12 np"><a href="#" data-toggle="modal" data-target="#addModal" class="btn btn-viewupload">+ Add New File</a></div>
					
		<p style="color:green"><?php echo Session::get('message'); ?></p>
			@foreach ($errors->all() as $message)
				<p style="color:red">{{ $message }}</p>
			@endforeach
					@include('pages.addriskfile')
<div class="col-xs-12  col-sm-12">
	<table class="table table-hover tbldashboard"  id="riskftable">
		<thead>
				<th>Filename</th>
				<th>Filetype</th>
				<th>Uploader</th>
				<th></th>                                                                                 
		</thead>
		<tbody>
			@foreach($riskfile as $riskf)
			<tr>
				<td><div class="text_holder"><a target="_blank" href="{{ url($riskf->fileurl) }}">{{$riskf->filename}}</a></div></td>
				<td><p><span>{{$riskf->filetype}}</span></p></td>
				<td><span>{{$riskf->name}}</span>
					<td><div class="btn-group pull-right">
						@if($riskf->uploadedby == Auth::user()->id)
						<a class="delete btn btn-danger" onclick="$(this).filedel({{ $riskf->id }});">Delete</a>
						@endif
						<a class="btn btn-primary btn-success"  target="_self" href="{{ url($riskf->fileurl) }}" download><span class="fa fa-cloud-download"></span>Download File</a>		
					 	</div></td>
			</tr>				
			@endforeach
	</table>
</div>

	</div>
</div>


<form id="file-delete" method="POST" action="">
    {{ csrf_field() }}
</form>
@endsection