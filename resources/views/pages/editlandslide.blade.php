@extends('layouts.masters.backend-layout')
@section('page-content')
@if((Auth::user()->id == $landslides->created_by) || (Auth::user()->role_id <= 3))
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Edit Landslide Report</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach
<?php 
	if(!($landslides->incident_images)){
		$landslideimages = [];	
	}else{
		$landslideimages = unserialize($landslides->incident_images);
	}
?>

<p style="color:#00CA00"><?php echo Session::get('message'); ?></p>
<form id="userform" action="{{ action('LandslideController@updateLandslide') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" value="landslideimages[]" name="landslideimages" id="landslideimages" />
	<input type="hidden" name="id" value="<?= $landslides->id ?>">	
	
	<div class="col-xs-12 np">
			<div class="col-xs-12 col-sm-4 perinputwrap dates">
					<label>Date & Time</label>
					<div class='input-group date' id="date">
						<input type='text'  name="date" value="<?= $landslides->date ?>" placeholder="Date & Time" class="form-control" />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
					@if ($errors->has('date')) <span class="reqsymbol">*</span> @endif
				</div>

		<div class="col-xs-12 col-sm-4 perinputwrap">
			<label>Barangay/Sitio/Road Location:</label>
			<input type="text" name="road_location"  id="location" class="form-control" value="<?= $landslides->road_location ?>"  placeholder="Enter location" required>
		</div>

		<div class="col-xs-12 col-sm-4 perinputwrap">
			<label>Building Location:</label>
			<input type="text" name="house_location" id="house_location" class="form-control" value="<?= $landslides->house_location ?>"  placeholder="Enter location">
		</div>
		
		<div class="col-xs-12 col-sm-4 perinputwrap">
			<label>Province:</label>
			<select name="province_id" id="province_id" class="form-control">				
					<option>Select Province</option>
				@foreach($provinces as $province)
					@if($landslides->province_id == $province->id)				
						<option selected="selected" value="{{ $province->id }}">{{ $province->name }}</option>	
					@else
						<option value="{{ $province->id }}">{{ $province->name }}</option>
					@endif	
				@endforeach
			</select>
		</div>

		<div class="col-xs-12 col-sm-4 perinputwrap">
			<label>Municipality:</label>
		<select name="municipality_id" id="municipality_id" class="form-control">
				<option>Select Municipality</option>
			@foreach($municipalities as $municipality)
				@if($landslides->municipality == $municipality->id)	
					<option selected="selected" value="{{ $municipality->id }}">{{ $municipality->name }}</option>
				@else
					<option value="{{ $municipality->id }}">{{ $municipality->name }}</option>
				@endif
			@endforeach
		</select>
		</div>

		<div class="col-xs-12 col-sm-4 perinputwrap">
			<label>Land Cover:</label>
			<select name="landcover" id="landcover"  class="form-control">
				@if($landslides->landcover == "")
					<option value="Public Land/Forest">Public Land/Forest</option>
					<option value="National Park">National Park</option>
					<option value="Wooded Lands">Wooded Lands</option>
					<option value="Built-up Areas">Built-up Areas</option>
				@else
					<option selected="selected" value="<?= $landslides->landcover ?>">{{ $landslides->landcover }}</option>
					<option value="Public Land/Forest">Public Land/Forest</option>
					<option value="National Park">National Park</option>
					<option value="Wooded Lands">Wooded Lands</option>
					<option value="Built-up Areas">Built-up Areas</option>
				@endif
			</select>
		</div>
	</div>

	<div class="col-xs-12 col-sm-5 perinputwrap">
		<label>Prominent Landmark: </label>
		<input type="text" name="landmark" id="landmark" class="form-control" value="<?= $landslides->landmark ?>"  placeholder="Enter landmark">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Landslide Type:</label>
		<select name="landslidetype" id="landslidetype" class="form-control">
			<option selected="selected" value="<?= $landslides->landslidetype ?>">{{ $landslides->landslidetype }}</option>
			<option value="Fall">Fall</option>
			<option value="Slide">Slide</option>
			<option value="Flow">Flow</option>
			<option value="Creep">Creep</option>
			<option value="Subsidence">Subsidence</option>
			<option value="Complex">Complex</option>
		</select>
	</div>

	<div class="col-xs-12 col-sm-3 perinputwrap">
		<label>Recurring Landslide?</label>
		<select name="landslidereccuring" id="landslidereccuring" class="form-control">
			<option selected="selected" value="<?= $landslides->landslidereccuring ?>">{{ $landslides->landslidereccuring }}</option>
			<option value="No">No</option>
			<option value="Yes">Yes</option>
		</select>
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Landslide Length:</label>
		<input type="number" name="lelength" id="lelength" class="form-control" value="<?= $landslides->lelength ?>" placeholder="Meters (m)">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Landslide Width:</label>
		<input type="number" name="lewidth" id="lewidth" class="form-control" value="<?= $landslides->lewidth ?>" placeholder="Meters (m)">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Landslide Depth:</label>
		<input type="number" name="ledepth" id="ledepth" class="form-control" value="<?= $landslides->ledepth ?>" placeholder="Meters (m)">
	</div>

	<div class="col-xs-12 col-sm-2 perinputwrap">
		<label>No. of People Killed:</label>
		<input type="number"  name="idkilled" id="idkilled" value="<?= $landslides->idkilled ?>"  class="form-control">
	</div>

	<div class="col-xs-12 col-sm-2 perinputwrap">
		<label>No. of People Injured:</label>
		<input type="number"  name="idinjured" id="idinjured" value="<?= $landslides->idinjured ?>" class="form-control">
	</div>

	<div class="col-xs-12 col-sm-2 perinputwrap">
		<label>No. of People Missing:</label>
		<input type="number" name="idmissing" id="idmissing" value="<?= $landslides->idmissing ?>" class="form-control">
	</div>

	<div class="col-xs-12 col-sm-2 perinputwrap">
		<label>No. of Affected Infrastructure:</label>
		<input type="number" name="idaffectedinfra" id="idaffectedinfra" value="<?= $landslides->idaffectedinfra ?>" class="form-control">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label><br>Value of Affected Crops:</label>
		<input type="number" name="idaffectedcrops" id="idaffectedcrops" class="form-control" value="<?= $landslides->idaffectedcrops ?>" placeholder="Pesos (php)">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
			<label>Cause:</label>
			<select name="cause" id="cause" class="form-control">
					<option selected="selected" value="<?= $landslides->cause ?>">{{ $landslides->cause }}</option>
					<option value="Hydrometeorological">Hydrometeorological</option>
					<option value="Geological">Geological</option>
			</select>
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
			<label>Typhoon name: </label>
			<input type="text" name="typhoonname" id="typhoonname" class="form-control" value="<?= $landslides->typhoonname ?>" placeholder="Enter name">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Heavy rainfall?</label>
		<select name="heavyrainfall" id="heavyrainfall" class="form-control">
			<option selected="selected" value="<?= $landslides->heavyrainfall ?>">{{ $landslides->heavyrainfall }}</option>
			<option value="No">No</option>
			<option value="Yes">Yes</option>
		</select>
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Source of the report: </label>
		<input type="text" name="author" id="author" class="form-control" value="<?= $landslides->author ?>" placeholder="Enter name">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Name of Reporter: </label>
		<input type="text" name="reportedby" id="reportedby" class="form-control" value="<?= $landslides->reportedby ?>" placeholder="Enter name">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Position of the Reporter: </label>
		<input type="text" name="reporterpos" id="reporterpos" class="form-control" value="<?= $landslides->reporterpos ?>" placeholder="Enter position">
	</div>		

	<div class="col-xs-12 col-sm-8 perinputwrap">
		<div id="editcoords" style="min-height: 300px;"></div>
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<span class="title defsp">Drag Map marker to change Coordinates</span>
		<div class="col-xs-12 np">
			<label>Latitude:</label>
			<input type="text" name="latitude" id="latitude" class="form-control" value="<?= $landslides->latitude ?>" placeholder="Enter latitude">
		</div>
		<div class="col-xs-12 np">
			<label>Longitude:</label>
			<input type="text" name="longitude" id="longitude" class="form-control" value="<?= $landslides->longitude ?>" placeholder="Enter longitude">
		</div>
		<div class="col-xs-12 perinputwrap np">
				<div class="col-xs-12 text-center np">
						<input class="btn btn-updatelocation"  type="submit" value="Update Landslide">
						<a class="btn btn-cancel" href="{{ action("LandslideController@viewLandslides") }}">Cancel</a>
				</div>	
		</div>

	</div>
	<div class="col-xs-12 col-md-12 perinputwrap">
		<div class="inside">
			
			<div id="dZUpload" class="dropzone">
				  <div class="dz-default dz-message">Drop Additional File here or Click to upload additional Image</div>
				  @if(($landslides->incident_images != null) || ($landslides->incident_images != ""))
				@foreach($landslideimages as $key =>$landslideimage)
					<span class="mythumbs"><a href="{{$landslideimage}}"><img src="{{$landslideimage}}" id="{{$key}}" class="mres" /></a>
						<div class="col-xs-12 np text-center removeimagewrap"><a title="Remove Image" href="#" class="removeimage"><span class="glyphicon glyphicon-trash"></span></a></div>
					</span>				
				@endforeach
			@endif
			</div>
		</div>
	</div>
</form>

@else
<h2>Insufficient Permission!!!</h2>
<span class="defsp"><img src="<?php echo url('assets/images/goodjob.gif');?>"></span>
@endif
@endsection
 @section('page-js-files')
@if((Auth::user()->id == $landslides->created_by) || (Auth::user()->role_id <= 3))
<script type="text/javascript" src="{!! url('assets/dropzone/dropzone.js') !!}"></script>
<script type="text/javascript">
var baseUrl = "{{ url('/') }}";
var token = "{{ Session::token() }}";
var images = [];
var counter = 0;
var mainimages = [];
var checkifnull = {!! json_encode($landslideimages) !!};
if(checkifnull != ''){
	images = checkifnull;
	counter = images.length;
	for (var i = 0; i < images.length; i++) {
		images[i] = images[i] + '-@'; 
	}
}else{
	images = [];
	counter = 0;
}



document.getElementById("landslideimages").value = images;
Dropzone.autoDiscover = false;
 var myDropzone = new Dropzone("div#dZUpload", { 
     url: "{{$landslides->id}}/edituploadlandslideimage",
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
            images.sort();
      		document.getElementById("landslideimages").value = images;
      		console.log(images);
      		counter++;
        })
    }
 });

 Dropzone.options.myAwesomeDropzone = {
    paramName: "file", 
    maxFilesize: 2, 
    addRemoveLinks: true,    
  };

  $('.removeimage').on('click',function(e){
  	e.preventDefault();
  	var removefromarrayindex = $(this).parent().parent().find('img').attr('id');
  	$(this).parent().parent().remove();
  	images.splice(removefromarrayindex, 1);
  	images.sort();
  	document.getElementById("landslideimages").value = images;
  });
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
			lat:{{$landslides->latitude}},
			lng:{{$landslides->longitude}}
		},
		zoom:9
	});

	var marker = new google.maps.Marker({
		position:{
			lat:{{$landslides->latitude}},
			lng:{{$landslides->longitude}}
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
@endif
@endsection