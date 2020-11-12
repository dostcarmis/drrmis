@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Add Incident Report</h1>
	</div>
</div>

@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach

<form id="userform" action="{{action('IncidentsController@saveIncident')}}" method="post"  enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" id="incidentimages" name="incidentimages" value="incidentimages[]">
	
	<div class="col-xs-12 col-sm-10 incident-leftpanel">
		<div class="col-xs-12 col-sm-12 np perinputwrap reqelement">
			<input type="text" data-placement="bottom" name="location" id="location" class="form-control" placeholder="Enter location">
		</div>
		<div class="col-xs-12 np perinputwrap">
			<textarea class="form-control" name="description" placeholder="Enter description" id="piw-textarea"></textarea>
		</div>
		<div class="col-xs-12 np perinputwrap">
			<h3>Source:</h3>
			<div class="inside reqelement">
				<input type="text" name="author" id="author" class="form-control" placeholder="Enter Source / Office" required>
			</div>
		</div>

		<div class="col-xs-12 np perinputwrap">
			<h3>Coordinates</h3>
			<div class="inside">
				<div class="col-xs-12 col-sm-6">
					<div id="addcoords" style="min-height: 300px;"></div>
				</div>
				<div class="col-xs-12 col-sm-6">
					<span class="title defsp">Drag Map marker to change Coordinates</span>
					<div class="col-xs-12 np reqelement">
						<label>Latitude:</label>
						<input type="text" name="latitude" id="latitude" class="form-control" value="17.351324" placeholder="Enter latitude">
					</div>
					<div class="col-xs-12 np reqelement">
						<label>Longitude:</label>
						<input type="text" name="longitude" id="longitude" class="form-control" value="121.17500399999994" placeholder="Enter longitude">
					</div>
				</div>
			</div>
		</div>

		<div class="col-xs-12 np perinputwrap">
			<h3>Upload Images</h3>
			<div class="inside">
				<div id="dZUpload" class="dropzone">
				      <div class="dz-default dz-message">Drop Images here or Click to upload Image</div>
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
						<option value="{{ $hazard->id }}">{{ $hazard->name }}</option>			
					@endforeach
				</select>		
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 np perinputwrap">
			<h3>Province</h3>			
			<div class="inside">
				@foreach($provinces as $province)	
					<div class="radio" id="radprovince">
				      <label><input type="radio"  name="optprovince" value="{{ $province->id }}">{{ $province->name }}</label>
				    </div>
				@endforeach
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 np perinputwrap dates">
			<h3>Date & Time</h3>
			<div class="inside reqelement">
				<input type="text" name="date" id="hiddendatepick" style="display: none;">
				<div class='input-group date' id="datein">
		        </div>
			</div>
		</div>

		<div class="col-xs-12 perinputwrap np">
				<div class="col-xs-12 text-center np">
					<input class ="btn btn-updatelocation"  type ="submit" value="Save">
					<a class="btn btn-cancel" href="{{ action("IncidentsController@viewIncidents") }}">Cancel</a> 
				</div>	
		</div>
	</div>			
</form>


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
        	var imagefile = baseUrl + '/files/1/Incident_Images/'+file["name"] +'-@';
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
	var map = new google.maps.Map(document.getElementById('addcoords'),{
		center:{
			lat:17.351324,
			lng:121.17500399999994
		},
		zoom:9
	});
	var marker = new google.maps.Marker({
		position:{
			lat:17.351324,
			lng:121.17500399999994
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