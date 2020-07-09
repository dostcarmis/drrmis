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

<form id="userform" action="{{ action('LandslideController@saveLandslide') }}" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" id="landslideimages" name="landslideimages" value="landslideimages[]">
	
	<div class="col-xs-12 np">
			<div class="col-xs-12 col-sm-4 perinputwrap dates">
					<label href="#" data-toggle="tooltip"  title="This is the date and time of occurence of the landslide.">Date & Time  <i class="fa fa-info-circle" text-align="right" aria-hidden="true"></i></label>
					<div class='input-group date' id="date">
						<input type='text'  name="date" placeholder="Date & Time" class="form-control" />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
					@if ($errors->has('date')) <span class="reqsymbol">*</span> @endif
				</div>

		<div class="col-xs-12 col-sm-4 perinputwrap">
			<label href="#" data-toggle="tooltip"  title="Name of the barangay or sitio where the landslide happened.">Barangay/Sitio/Road Location:<i class="fa fa-info-circle" text-align="right" aria-hidden="true"></i></label>
			<input type="text" name="road_location" id="road_location" class="form-control" placeholder="Enter location" required>
		</div>

		<div class="col-xs-12 col-sm-4 perinputwrap">
			<label  href="#" data-toggle="tooltip"  title="Building number if the landslide happened in urban setting">Building Location:<i class="fa fa-info-circle" text-align="right" aria-hidden="true"></i></label>
			<input type="text" name="house_location" id="house_location" class="form-control" placeholder="Enter location">
		</div>
		
		<div class="col-xs-12 col-sm-4 perinputwrap">
			<label href="#" data-toggle="tooltip"  title="Name of the province where the landslide happened">Province:<i class="fa fa-info-circle" text-align="right" aria-hidden="true"></i></label>
			<select name="province_id" id="province_id" class="form-control">				
					<option>Select Province</option>
				@foreach($provinces as $province)				
					<option value="{{ $province->id }}">{{ $province->name }}</option>			
				@endforeach
			</select>
		</div>

		<div class="col-xs-12 col-sm-4 perinputwrap">
			<label href="#" data-toggle="tooltip"  title="Name of the municipality where the landslide happened">Municipality:<i class="fa fa-info-circle" text-align="right" aria-hidden="true"></i></label>
			<select name="municipality_id" id="municipality_id" disabled="disabled" class="form-control">
				<option>Select Municipality</option>
			</select>
		</div>

		<div class="col-xs-12 col-sm-4 perinputwrap">
			<label href="#" data-toggle="tooltip"  title="Observed physical cover on the surface of the eroded area">Land Cover  <i class="fa fa-info-circle" text-align="right" aria-hidden="true"></i></label>
			<select name="landcover" id="landcover" class="form-control">
				<option value="Public Land/Forest">Public Land/Forest</option>
				<option value="National Park">National Park</option>
				<option value="Wooded Lands">Wooded Lands</option>
				<option value="Built-up Areas">Built-up Areas</option>
			</select>
		</div>
	</div>

	<div class="col-xs-12 col-sm-5 perinputwrap">
		<label href="#" data-toggle="tooltip"  title="Nearest noticeable landmark near the eroded area i.e sheds, school etc.">Prominent Landmark:  <i class="fa fa-info-circle" text-align="right" aria-hidden="true"></i></label>
		<input type="text" name="landmark" id="landmark" class="form-control" placeholder="Enter landmark">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label  href="#" data-toggle="tooltip"  title="Type of the landslide that occurred">Landslide Type: <i class="fa fa-info-circle" text-align="right" aria-hidden="true"></i></label>
		<select name="landslidetype" id="landslidetype" class="form-control">
			<option value="Fall">Fall</option>
			<option value="Slide">Slide</option>
			<option value="Flow">Flow</option>
			<option value="Creep">Creep</option>
			<option value="Subsidence">Subsidence</option>
			<option value="Complex">Complex</option>
		</select>
	</div>

	<div class="col-xs-12 col-sm-3 perinputwrap">
		<label  href="#" data-toggle="tooltip"  title="Is the landslide occurred is a repeating landslide?">Recurring Landslide? <i class="fa fa-info-circle" text-align="right" aria-hidden="true"></i></label>
		<select name="landslidereccuring" id="landslidereccuring" class="form-control">
			<option value="No">No</option>
			<option value="Yes">Yes</option>
		</select>
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label >Landslide Length:</label>
		<input type="number" name="lelength" id="lelength" class="form-control" placeholder="Meters (m)">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Landslide Width:</label>
		<input type="number" name="lewidth" id="lewidth" class="form-control" placeholder="Meters (m)">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Landslide Depth:</label>
		<input type="number" name="ledepth" id="ledepth" class="form-control" placeholder="Meters (m)">
	</div>

	<div class="col-xs-12 col-sm-2 perinputwrap" style="top: 28px">
		<label>No. of Deaths:</label>
		<input type="number" value="0" name="idkilled" id="idkilled" class="form-control">
	</div>

	<div class="col-xs-12 col-sm-2 perinputwrap" style="top: 28px">
		<label>No. of People Injured:</label>
		<input type="number" value="0" name="idinjured" id="idinjured" class="form-control">
	</div>

	<div class="col-xs-12 col-sm-2 perinputwrap" style="top: 28px">
		<label>No. of People Missing:</label>
		<input type="number" value="0" name="idmissing" id="idmissing" class="form-control">
	</div>

	<div class="col-xs-12 col-sm-2 perinputwrap">
		<label>No. of Affected Infrastructure:</label>
		<input type="number" value="0" name="idaffectedinfra" id="idaffectedinfra" class="form-control">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label><br>Value of Affected Crops:</label>
		<input type="number" name="idaffectedcrops" id="idaffectedcrops" class="form-control" placeholder="Pesos (php)">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
			<label>Cause:</label>
			<select name="cause" id="cause" class="form-control">
				<option value="hydrometeorological">Hydrometeorological</option>
				<option value="geological">Geological</option>
			</select>
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
			<label>Typhoon name: </label>
			<input type="text" name="typhoonname" id="typhoonname" class="form-control" placeholder="Enter name">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Heavy rainfall?</label>
		<select name="heavyrainfall" id="heavyrainfall" class="form-control">
			<option value="No">No</option>
			<option value="Yes">Yes</option>
		</select>
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Source of the report: </label>
		<input type="text" name="author" id="author" class="form-control" placeholder="Enter name">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Name of Reporter: </label>
		<input type="text" name="reportedby" id="reportedby" class="form-control" placeholder="Enter name">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Designation/Position of the Reporter: </label>
		<input type="text" name="reporterpos" id="reporterpos" class="form-control" placeholder="Enter position">
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
						<input class="btn btn-updatelocation"  type="submit" value="Save Landslide" style="width: 200px">
						<a class="btn btn-cancel" href="{{ action("LandslideController@viewLandslides") }}" style="width: 127px">Cancel</a>
				</div>	
		</div>

	</div>
	<div class="col-xs-12 col-md-12 perinputwrap">
			<label>Landslide Images:</label>
			<div id="dZUpload" class="dropzone">
				  <div class="dz-default dz-message">Drop Images here or Click to upload Image</div>
			</div>
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
