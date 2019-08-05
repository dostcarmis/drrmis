@extends('layouts.masters.homepagedesign-layout')
@section('page-content')
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h1 class="page-header">Preparedness</h1>			
			<div class="col-xs-12 np"><a href="#" data-toggle="modal" data-target="#addModal" class="btn btn-viewupload">+ Add Report</a></div>

			<p style="color:green"><?php echo Session::get('message'); ?></p>

			@foreach ($errors->all() as $message)
			    <p style="color:red">{{ $message }}</p>
			@endforeach

			@include('pages.addpreparedness')

			<div class="displayfiletodownload">


				<ol class="list-group list_of_items" id="downloadlist">



					@foreach($preparedness as $prepared)
						<li class="list-group-item">

							<div class="text_holder">Filename : <a href="{{$prepared->fileurl}}/{{$prepared->file}}">{{$prepared->filename}}</a>	
								<div class="btn-group pull-right">

									@if($prepared->uploadedby == $currentUser->id)									
									<a class="delete btn btn-danger" href="<?php echo url('deletepreparedness'); ?>/<?php echo $prepared->id?>">Delete</a>
									@endif

									<a class="edit btn btn-primary" href="{{$prepared->fileurl}}/{{$prepared->file}}">Download</a>
								</div>

								<p>Filetype: <span>({{$prepared->filetype}})</span></p>	

							</div>
						</li>
					@endforeach
					
				</ol>


			</div>
		</div>
	</div>
</div>
@endsection
