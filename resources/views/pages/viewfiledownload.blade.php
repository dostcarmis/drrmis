
<div class="container">
	<style>
		.dataTables_wrapper .row:first-child{display: unset; /* color: white; */}
		/* .dataTables_info{color:white;} */
	</style>
	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<h1 class="page-header"><b>Download DRRM related Files</b></h1>
		</div>
	</div>
	<div class="row" style="margin-top:1rem">
		<div class="col-xs-12">
			{{-- <div class="input-group" style="width: 50%; float:left">
				<div class="input-group-addon"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
				<form id="searchFileForm">
					<input type="text" class="form-control" placeholder="Search file" id="searchFileName" kind="filerepo">
				</form>
			</div> --}}
			<a href="#" data-toggle="modal" data-target="#addfileModal" class="btn btn-viewupload" style="float: right;">+ Add<span class="xs-d-none sm-d-none md-d-inline"> New File</span></a>
		</div>
	</div>
		<div id="alert-success" style="display: none" class="alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class=" alert-close close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<span class="alert-content"></span>
		</div>
		<div id="alert-fail" style="display: none" class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close alert-close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<span class="alert-content"></span>
		</div>
		@foreach ($errors->all() as $message)
			<p style="color:red" class="sm-mt-3">{{ $message }}</p>
		@endforeach
	@include('pages.adddrrmfile')
	<table class="table tbldashboard table-hover rounded xs-medium-text sm-medium-text md-regular-text" id="files-repo-table">
		<thead style="cursor: pointer">
			<tr>
				<th title="Sort by File Name">Filename</th>
				<th title="Sort by File Type">Filetype</th>
				<th title="Sort by Uploader">Uploader</th>
				<th width="20%">#</th> 
			</tr>	                                                                                
		</thead>
		<tbody>
			@foreach($files as $file)
			<tr>
				<td><div class="text_holder"><a target="_blank" href="{{ url($file->fileurl) }}">{{$file->filename}}</a></div></td>
				<td><p><span>{{$file->filetype}}</span></p></td>
				<td><span>{{$file->name}}</span>
				<td>
					<div class="btn-group pull-right">
						@if($file->uploadedby == Auth::user()->id)
							<a class="delete btn btn-danger xs-px-2 sm-px-2 md-p-2" onclick="$(this).deleteFile({{ $file->id }});" title="Delete File">
								<i class="fa fa-trash md-d-none" aria-hidden="true"></i>
								<span class="xs-d-none sm-d-none md-d-block">Delete</span>
							</a>
						@endif
						<a class="btn btn-success xs-px-2 sm-px-2 md-p-2"  target="_self" href="{{ url($file->fileurl) }}" download title="Download File">
							<span class="fa fa-cloud-download md-d-none"></span>
							<span class="xs-d-none sm-d-none md-d-block">Download</span>
						</a>		
					</div>
				</td>
			</tr>				
			@endforeach
	</table>
		
</div>
<div class="whiteblock md-d-none"></div>
<form id="delete-file" method="POST" action="">
    {{ csrf_field() }}
</form>

@include('pages.successdeletefilemodal')


@section('page-js-files')
	<script src="{{asset('assets/js/filemanagement.js')}}"></script>
	@if (!empty(session('success_delete')))
	<script> 
	$(function(){
		$("#modalSuccess").modal();
	});
	</script>
	@endif
@endsection



