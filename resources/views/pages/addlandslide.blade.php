@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Add Landslide Report</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach

<form id="userform" action="{{ action('LandslideController@saveLandslide') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" id="myimages" name="myimages" value="myimages[]">
	<div class="col-xs-12 col-sm-6 perinputwrap dates">
		<label>Date & Time</label>
		<div class='input-group date' id="date">
            <input type='text' name="date" placeholder="Date & Time" class="form-control" />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
        @if ($errors->has('date')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 np">
	<div class="col-xs-12 col-sm-9 perinputwrap">
		<label>Location:</label>
		<input type="text" name="location" id="location" class="form-control" placeholder="Enter location">
		@if ($errors->has('location')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 col-sm-3 perinputwrap">
		<label>Province:</label>
		<select name="province_id" id="province_id" class="form-control">				
			@foreach($provinces as $province)				
				<option value="{{ $province->id }}">{{ $province->name }}</option>			
			@endforeach
		</select>
	</div>
	</div>
	
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<div id="addcoords" style="min-height: 300px;"></div>
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<span class="title defsp">Drag Map marker to change Coordinates</span>
		<div class="col-xs-12 np">
			<label>Latitude:</label>
			<input type="text" name="latitude" id="latitude" class="form-control" value="17.351324" placeholder="Enter latitude">
		</div>
		<div class="col-xs-12 np">
			<label>Longitude:</label>
			<input type="text" name="longitude" id="longitude" class="form-control" value="121.17500399999994" placeholder="Enter longitude">
		</div>
	</div>
	<div class="col-xs-12 perinputwrap">
		<label>Source:</label>
		<input type="text" name="author" id="author" class="form-control" placeholder="Enter Source / Office">
		@if ($errors->has('author')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 perinputwrap">
		<label>Images:</label>
		<div id="dZUpload" class="dropzone">
		      <div class="dz-default dz-message">Drop Images here or Click to upload Image</div>
		</div>
	</div>
	<div class="col-xs-12 perinputwrap">
		<label>Description:</label>
		<textarea class="piw-textarea form-control" name="description" placeholder="Landslide Incident Details" id="piw-textarea"></textarea>
	</div>	
	<div class="col-xs-12 perinputwrap text-right">
	<input class ="btn btn-updatelocation"  type ="submit" value="Save">
	<a class="btn btn-cancel" href="{{ action("LandslideController@viewLandslides") }}">Cancel</a> 
	</div>

</form>

 @stop
 @section('page-js-files')
<script type="text/javascript" src="{!! url('assets/dropzone/dropzone.js') !!}"></script>
<script type="text/javascript">
var baseUrl = "{{ url('/') }}";
var token = "{{ Session::getToken() }}";
var images = []; 
var counter = 0;
Dropzone.autoDiscover = false;
 var myDropzone = new Dropzone("div#dZUpload", { 
     url: "uploadlandslideimage",
     params: {
        _token: token
      },
      init: function() {
        this.on("error", function(file) {
        	console.log("opapapaooooooooooooopsss");
        }),
        this.on("success", function(file, response) { 
        	var imagefile = baseUrl + '/files/1/Landslide Images/'+file["name"] +'-@';
            images[counter] = imagefile;
      		document.getElementById("myimages").value = images;
      		counter++;
      		console.log(images);
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