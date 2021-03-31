@extends('layouts.masters.backend-layout')
@section('page-content')
@if((Auth::user()->id == $incidents->created_by) || (Auth::user()->role_id <= 3))
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Edit Incident Report</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach

<?php 
	if(!($incidents->incident_images)){
		$incident_images = [];	
	}else{
		$incident_images = unserialize($incidents->incident_images);
	}
?>

<form id="editincident" action="{{action('IncidentsController@updateIncident')}}" method="post"  enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" id="incidentimages" name="incidentimages" value="incidentimages[]">
	<input type="hidden" name="id" value="<?= $incidents->id ?>">	

	<div class="col-xs-12 col-sm-10 incident-leftpanel">
		<div class="col-xs-12 col-sm-12 np perinputwrap reqelement">
			<input type="text" name="location" id="location" class="form-control" value="<?= $incidents->location ?>" placeholder="Enter location">
		</div>
		<div class="col-xs-12 np perinputwrap">
			<textarea class="form-control" name="description" placeholder="Enter description" id="piw-textarea">{{ $incidents->description }}</textarea>
		</div>	
		<div class="col-xs-12 np perinputwrap">
			<h3>Source:</h3>
			<div class="inside reqelement">
				<input type="text" name="author" id="author" value="<?= $incidents->author ?>"  class="form-control" placeholder="Enter Source / Office">
			</div>
		</div>
		<div class="col-xs-12 np perinputwrap">
			<h3>Coordinates</h3>
			<div class="inside">
				<div class="col-xs-12 col-sm-6">
					<div id="editcoords" style="min-height: 300px;"></div>
				</div>
				<div class="col-xs-12 col-sm-6">
					<span class="title defsp">Drag Map marker to change Coordinates</span>
					<div class="col-xs-12 np reqelement">
						<label>Latitude:</label>
						<input type="text" name="latitude" id="latitude" class="form-control" value="<?= $incidents->latitude ?>" placeholder="Enter latitude">
					</div>
					<div class="col-xs-12 np reqelement">
						<label>Longitude:</label>
						<input type="text" name="longitude" id="longitude" class="form-control" value="<?= $incidents->longitude ?>"  placeholder="Enter longitude">
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 np perinputwrap">
			<h3>Images:</h3>
			<div class="inside">
				@if(($incidents->incident_images != null) || ($incidents->incident_images != ""))
					@foreach($incident_images as $key =>$incident_image)
						<span class="mythumbs"><a href="{{$incident_image}}"><img src="{{$incident_image}}" id="{{$key}}" class="mres" /></a>
							<div class="col-xs-12 np text-center removeimagewrap"><a title="Remove Image" href="#" class="removeimage"><span class="glyphicon glyphicon-trash"></span></a></div>
						</span>				
					@endforeach
				@endif
				<div id="dZUpload" class="dropzone">
				      <div class="dz-default dz-message">Drop File here or Click to upload Image</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-2 incident-rightpanel">
		<div class="col-xs-12 col-sm-12 np perinputwrap">
			<h3>Incident Type</h3>			
			<div class="inside">				
			    <select name="hazard_id" id="hazard_id" class="form-control">				
					@foreach($hazards as $hazard)				
						@if($hazard->id == $incidents->incident_type)
						<option selected="selected" value="{{ $hazard->id }}">{{ $hazard->name }}</option>
						@else
						<option value="{{ $hazard->id }}">{{ $hazard->name }}</option>
						@endif		
					@endforeach
				</select>		

			</div>
		</div>
		<div class="col-xs-12 col-sm-12 np perinputwrap">
			<h3>Province</h3>			
			<div class="inside">
				@foreach($provinces as $province)	
					@if($incidents->province_id == $province->id)
					<div class="radio">
				      <label><input type="radio" name="optprovince" checked="checked" value="{{ $province->id }}">{{ $province->name }}</label>
				    </div>
					@else
					<div class="radio">
				      <label><input type="radio" name="optprovince" value="{{ $province->id }}">{{ $province->name }}</label>
				    </div>
					@endif
					
				@endforeach
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 np perinputwrap dates">
			<h3>Date & Time</h3>
			<div class="inside">
				
				<input type="hidden" name="date" id="hiddendatepick" value="<?= $incidents->date ?>">
				<!-- <div class='input-group date' id="date-in">
		        </div> -->
		        <input type="text" class="form-control" name="date" id="datein" value="<?= $incidents->date ?>" />
		        @if ($errors->has('date')) <span class="reqsymbol">*</span> @endif
			</div>
		</div>
		<div class="col-xs-12 perinputwrap np">
				<div class="col-xs-12 text-center np">
					<a class="btn btn-update" title="Update" data-toggle="modal" data-target="#mymodal">Update</a>
					<a class="btn btn-cancel" href="{{ action("IncidentsController@viewIncidents") }}">Cancel</a> 
					@include('pages.editdialogincidents')
				</div>	

		</div>
	</div>			

</form>

@else
<h2>Insufficient Permission!!!</h2>
@endif
 @endsection
@section('page-js-files')
<script type="text/javascript" src="{!! url('assets/dropzone/dropzone.js') !!}"></script>
<script type="text/javascript">
var baseUrl = "{{ url('/') }}";
var token = "{{ Session::token() }}";
var images = []; 
var counter = 0;
Dropzone.autoDiscover = false;
 var myDropzone = new Dropzone("div#dZUpload", { 
     url: "uploadincidentimage",
     params: {
        _token: token
      },
      init: function() {
        this.on("error", function(file) {
        	console.log("ooopppssss");
        }),
        this.on("success", function(file, response) { 
        	var imagefile = baseUrl + '/files/1/Incident Images/'+file["name"] +'-@';
            images[counter] = imagefile;
      		document.getElementById("incidentimages").value = images;
      		counter++;
  
        })
    }
 });
 Dropzone.options.myAwesomeDropzone = {
    paramName: "file", 
    maxFilesize: 2, 
    addRemoveLinks: true,    
  };
  
</script>
<script>
  CKEDITOR.replace( 'piw-textarea', {
    filebrowserImageBrowseUrl: '{{ asset("laravel-filemanager?type=Images") }}',
    filebrowserImageUploadUrl: '{{ asset("laravel-filemanager/upload?type=Images&_token=") }}{{csrf_token()}}',
    filebrowserBrowseUrl: '{{ asset("laravel-filemanager?type=Files") }}',
    filebrowserUploadUrl: '{{ asset("laravel-filemanager/upload?type=Files&_token=") }}{{csrf_token()}}'
  });
</script>
<script type="text/javascript">
	var map = new google.maps.Map(document.getElementById('editcoords'),{
		center:{
			lat:{{ $incidents->latitude}},
			lng:{{ $incidents->longitude}}
		},
		zoom:9
	});
	var marker = new google.maps.Marker({
		position:{
			lat:{{ $incidents->latitude }},
			lng:{{ $incidents->longitude }}
		},
		map:map,
		draggable:true
	});
	google.maps.event.addListener(marker,'dragend',function(){
		$('#latitude').val(marker.getPosition().lat());
		$('#longitude').val(marker.getPosition().lng());
	});

</script>
@endsection