@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Add Flood Report</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach

<form id="userform" action="{{ action('FloodController@saveFlood') }}" method="post"  enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" id="floodimages" name="floodimages" value="floodimages[]">
	
	<div class="col-xs-12 np">
		<div class="col-xs-12 col-sm-4 perinputwrap dates">
				<label href="#" data-toggle="tooltip"  title="This is the date and time of occurence of the flood">Date & Time  <i class="fa fa-info-circle" text-align="right" aria-hidden="true"></i></label>
				<div class='input-group date' id="date">
					<input type='text'  name="date" placeholder="Date & Time" class="form-control" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
				@if ($errors->has('date')) <span class="reqsymbol">*</span> @endif
			</div>

		<div class="col-xs-12 col-sm-4 perinputwrap">
			<label>Barangay/Sitio/Road Location:</label>
			<input type="text" name="road_location" id="road_location" class="form-control" placeholder="Enter location" required>
		</div>

		<div class="col-xs-12 col-sm-4 perinputwrap">
			<label>Province:</label>
			<select name="province_id" id="province_id" class="form-control">				
					<option>Select Province</option>
				@foreach($provinces as $province)				
					<option value="{{ $province->id }}">{{ $province->name }}</option>			
				@endforeach
			</select>
		</div>

		<div class="col-xs-12 col-sm-2 perinputwrap">
			<label>Municipality:</label>
			<select name="municipality_id" id="municipality_id" disabled="disabled"  class="form-control">
				<option></option>
			</select>
		</div>

		<div class="col-xs-12 col-sm-2 perinputwrap">
			<label>River System:</label>
			<input type="text" name="river_system" id="river_system" class="form-control" placeholder="Enter river basin" required>
		</div>

		<div class="col-xs-12 col-sm-3 perinputwrap">
			<label>Flood Type:</label>
			<select name="flood_type" id="flood_type" class="form-control">
				<option value="River Flooding">River Flooding</option>
				<option value="Flash Flooding">Flash Flooding</option>
				<option value="Groundwater Flood">Groundwater Flood</option>
				<option value="Drain and Sewer Flooding">Drain and Sewer Flooding</option>
			</select>
		</div>

		<div class="col-xs-12 col-sm-3 perinputwrap" >
			<label>Flood Water Level:</label>
			<input type="number" value="0" name="flood_waterlvl" id="flood_waterlvl" class="form-control">
		</div>

		<div class="col-xs-12 col-sm-2 perinputwrap">
			<label>Measured at:</label>
			<input type="text" name="measuredat" id="measuredat" class="form-control" placeholder="Enter description">
		</div>

		<div class="col-xs-12 col-sm-2 perinputwrap">
			<label>Recurring Flood?</label>
			<select name="flood_reccuring" id="flood_reccuring" class="form-control">
				<option value="No">No</option>
				<option value="Yes">Yes</option>
			</select>
		</div>

		<div class="col-xs-12 col-sm-2 perinputwrap" style="top: 28px">
			<label>No. of Casualty:</label>
			<input type="number" value="0" name="flood_killed" id="flood_killed" class="form-control">
		</div>
	
		<div class="col-xs-12 col-sm-3 perinputwrap" style="top: 28px">
			<label>No. of People Injured:</label>
			<input type="number" value="0" name="flood_injured" id="flood_injured" class="form-control">
		</div>
	
		<div class="col-xs-12 col-sm-3 perinputwrap" style="top: 28px">
			<label>No. of People Missing:</label>
			<input type="number" value="0" name="flood_missing" id="flood_missing" class="form-control">
		</div>

		<div class="col-xs-12 col-sm-2 perinputwrap">
			<label>No. of Affected Infrastructure:</label>
			<input type="number" value="0" name="flood_affectedinfra" id="flood_affectedinfra" class="form-control">
		</div>

		<div class="col-xs-12 col-sm-3 perinputwrap" style="top: -26px">
			<label><br>Value of Affected Crops:</label>
			<input type="number" name="flood_affectedcrops" id="flood_affectedcrops" class="form-control" placeholder="Pesos (php)">
		</div>
	
		<div class="col-xs-12 col-sm-3 perinputwrap">
				<label>Cause:</label>
				<select name="cause" id="cause" class="form-control">
					<option value="hydrometeorological">Hydrometeorological</option>
					<option value="geological">Geological</option>
					<option value="others">Others</option>
				</select>
		</div>
	
		<div class="col-xs-12 col-sm-3 perinputwrap">
				<label>Typhoon name: </label>
				<input type="text" name="typhoon_name" id="typhoon_name" class="form-control" placeholder="Enter name">
		</div>
	
		<div class="col-xs-12 col-sm-3 perinputwrap">
			<label>Heavy rainfall?</label>
			<select name="heavy_rainfall" id="heavy_rainfall" class="form-control">
				<option value="No">No</option>
				<option value="Yes">Yes</option>
			</select>
		</div>
	
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Source of the report: </label>
		<input type="text" name="author" id="author" class="form-control" placeholder="Enter name">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Name of Reporter: </label>
		<input type="text" name="reported_by" id="reported_by" class="form-control" placeholder="Enter name">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap" style="top: -29px">
		<label>Designation/Position of the Reporter: </label>
		<input type="text" name="reporter_pos" id="reporter_pos" class="form-control" placeholder="Enter position">
	</div>		

	<div class="col-xs-12 col-sm-8 perinputwrap">
		<div id="addcoords" style="min-height: 300px;"></div>
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<span class="title defsp">Drag Map marker to change Coordinates</span>
		<div class="col-xs-12 np">
			<label>Latitude:</label>
			<input type="text" name="latitude" id="latitude" class="form-control" value="17.351324" placeholder="Enter latitude">
		</div>
		<div class="col-xs-12 np">
			<label>Longitude:</label>
			<input type="text" name="longitude" id="longitude" class="form-control" value="121.17500399999994" placeholder="Enter longitude">
		</div>
		<div class="col-xs-12 perinputwrap np">
				<div class="col-xs-12 text-center np">
						<input class="btn btn-updatelocation"  type="submit" value="Save Flood" style="width: 200px">
						<a class="btn btn-cancel" href="{{ action("FloodController@viewFloods") }}" style="width: 127px">Cancel</a>
				</div>	
		</div>
	</div>
	<div class="col-xs-12 col-md-12 perinputwrap">
			<label>Flood Images:</label>
			<div id="dZUpload" class="dropzone">
				  <div class="dz-default dz-message">Drop Images here or Click to upload Image</div>
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
     url: "uploadfloodimages",
     params: {
        _token: token
      },
      init: function() {
        this.on("error", function(file) {
        	console.log("ooopppssss");
        }),
        this.on("success", function(file, response) { 
        	var imagefile = baseUrl + '/files/1/Flood Images/'+file["name"] +'-@';
            images[counter] = imagefile;
      		document.getElementById("floodimages").value = images;
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
<script>
	$(function() {
		$('#province_id').bind("keyup change", function(e){
		var cat_id = e.target.value;
		$('#municipality_id').removeAttr('disabled');
			$.ajax({
				type: 'GET',
				url: 'province-show?cat_id=' + cat_id,
				success:function(municipalities){
					var item = $('#municipality_id');
					item.empty();
					$.each(municipalities, function(i, municipality){
						item.append("<option value='"+municipality.id+"'>" +municipality.name+"</option>");
					});
				}
			});
	});
	
	});
	</script>
@endsection