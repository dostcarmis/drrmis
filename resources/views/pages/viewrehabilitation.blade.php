@extends('layouts.masters.homepagedesign-layout')
@section('page-content')
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h1 class="page-header">Response</h1>
		</div>
	</div>
	<div class="row" style="margin-top:1rem">
		<div class="col-xs-12">				
			<a href="#" data-toggle="modal" data-target="#addModal" class="btn btn-viewupload" style="float: right;">+ Add<span class="xs-d-none sm-d-none md-d-inline"> Report</span></a>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12">

			<p style="color:green"><?php echo Session::get('message'); ?></p>

			@foreach ($errors->all() as $message)
			    <p style="color:red">{{ $message }}</p>
			@endforeach

			@include('pages.addrehabilitation')
			<div class="displayfiletodownload">
				<ol class="list-group list_of_items" id="downloadlist">
					@foreach($rehabilitation as $rehab)
						<li class="list-group-item">
							<div class="text_holder">Filename : <a href="{{$rehab->fileurl}}/{{$rehab->file}}">{{$rehab->filename}}</a>	
								<div class="btn-group pull-right">
									@if($rehab->uploadedby == Auth::user()->id)

									
									<a class="delete btn btn-danger" href="<?php echo url('deleterehab'); ?>/<?php echo $rehab->id?>">Delete</a>
									@endif
									<a class="edit btn btn-primary" href="{{$rehab->fileurl}}/{{$rehab->file}}">Download</a>
								</div>
								<p>Filetype: <span>({{$rehab->filetype}})</span></p>	
							</div>
						</li>
					@endforeach
					
				</ol>
			</div>
		</div>
	</div>
</div>
@endsection
