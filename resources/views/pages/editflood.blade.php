@extends('layouts.masters.backend-layout')
@section('page-content')
@if((Auth::user()->id == $floods->created_by) || (Auth::user()->role_id <= 3))
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Edit Flood Report</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach
<?php 
	if(!($floods->incident_images)){
		$floodimages = [];	
	}else{
		$floodimages = unserialize($floods->incident_images);
	}
?>

<p style="color:#00CA00"><?php echo Session::get('message'); ?></p>
<form id="userform" action="{{ action('FloodController@updateFlood') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" value="floodimages[]" name="floodimages" id="floodimages" />
	<input type="hidden" name="id" value="<?= $floods->id ?>">	

	<div class="col-xs-12 np">
		<div class="col-xs-12 col-sm-4 perinputwrap dates">
				<label href="#" data-toggle="tooltip" title="This is the date and time of occurence of the flood">
					Date & Time  <i class="fa fa-info-circle" text-align="right" aria-hidden="true"></i>
				</label>
				<div class='input-group date' id="date">
					<input type='text'  name="date" value="<?= $floods->date ?>" 
						   placeholder="Date & Time" class="form-control">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
				@if ($errors->has('date')) <span class="reqsymbol">*</span> @endif
			</div>

		<div class="col-xs-12 col-sm-4 perinputwrap">
			<label>Barangay/Sitio/Road Location:</label>
			<input type="text" name="road_location" id="road_location" 
				   class="form-control" value="{{ $floods->road_location }}" 
				   placeholder="Enter location" required>
		</div>

		<div class="col-xs-12 col-sm-4 perinputwrap">
			<label>Province:</label>
			<select name="province_id" id="province_id" class="form-control">				
					<option>Select Province</option>
					@foreach($provinces as $province)
					@if($floods->province_id == $province->id)				
						<option selected="selected" value="{{ $province->id }}">{{ $province->name }}</option>	
					@else
						<option value="{{ $province->id }}">{{ $province->name }}</option>
					@endif	
				@endforeach
			</select>
		</div>

		<div class="col-xs-12 col-sm-2 perinputwrap">
			<label>Municipality:</label>
			<select name="municipality_id" id="municipality_id" class="form-control">
				<option>Select Municipality</option>
					@foreach($municipalities as $municipality)
						@if ($municipality->province_id == $floods->province_id)
				<option value="{{ $municipality->id }}" {{ ($municipality->id == $floods->municipality) ? ' selected': '' }}>
					{{ $municipality->name }}
				</option>
						@endif
					@endforeach
			</select>
		</div>

		<div class="col-xs-12 col-sm-2 perinputwrap">
			<label>River System:</label>
			<input type="text" name="river_system" id="river_system" value="<?= $floods->river_system ?>" class="form-control" placeholder="Enter river basin" required>
		</div>

		<div class="col-xs-12 col-sm-3 perinputwrap">
			<label>Flood Type:</label>
			<select name="flood_type" id="flood_type" class="form-control">
				@if($floods->flood_type == "")
					<option value="River Flooding">River Flooding</option>
					<option value="Flash Flooding">Flash Flooding</option>
					<option value="Groundwater Flood">Groundwater Flood</option>
					<option value="Drain and Sewer Flooding">Drain and Sewer Flooding</option>
				@else
					<option selected="selected" value="<?= $floods->flood_type ?>">{{ $floods->flood_type }}</option>
					<option value="River Flooding">River Flooding</option>
					<option value="Flash Flooding">Flash Flooding</option>
					<option value="Groundwater Flood">Groundwater Flood</option>
					<option value="Drain and Sewer Flooding">Drain and Sewer Flooding</option>
				@endif	
			</select>
		</div>

		<div class="col-xs-12 col-sm-3 perinputwrap" >
			<label>Flood Water Level:</label>
			<input type="number"s name="flood_waterlvl"  id="flood_waterlvl" value="<?= $floods->flood_waterlvl ?>" class="form-control">
		</div>

		<div class="col-xs-12 col-sm-2 perinputwrap">
			<label>Measured at:</label>
			<input type="text" name="measuredat" id="measuredat" class="form-control" value="<?= $floods->measuredat ?>" placeholder="Enter description">
		</div>

		<div class="col-xs-12 col-sm-2 perinputwrap">
			<label>Recurring Flood?</label>
			<select name="flood_reccuring" id="flood_reccuring" class="form-control">
				<option selected="selected" value="<?= $floods->flood_reccuring ?>">{{ $floods->flood_reccuring }}</option>
				<option value="No">No</option>
				<option value="Yes">Yes</option>
			</select>
		</div>

		<div class="col-xs-12 col-sm-2 perinputwrap" style="top: 28px">
			<label>No. of Killed:</label>
			<input type="number" name="flood_killed" id="flood_killed" value="<?= $floods->flood_killed ?>" class="form-control">
		</div>
	
		<div class="col-xs-12 col-sm-3 perinputwrap" style="top: 28px">
			<label>No. of People Injured:</label>
			<input type="number" name="flood_injured" id="flood_injured" value="<?= $floods->flood_injured ?>" class="form-control">
		</div>
	
		<div class="col-xs-12 col-sm-3 perinputwrap" style="top: 28px">
			<label>No. of People Missing:</label>
			<input type="number" name="flood_missing" id="flood_missing" value="<?= $floods->flood_missing ?>" class="form-control">
		</div>

		<div class="col-xs-12 col-sm-2 perinputwrap">
			<label>No. of Affected Infrastructure:</label>
			<input type="number" name="flood_affectedinfra" id="flood_affectedinfra" value="<?= $floods->flood_affectedinfra ?>" class="form-control">
		</div>

		<div class="col-xs-12 col-sm-3 perinputwrap" style="top: -26px">
			<label><br>Value of Affected Crops:</label>
			<input type="number" name="flood_affectedcrops" id="flood_affectedcrops" value="<?= $floods->flood_affectedcrops ?>" class="form-control" placeholder="Pesos (php)">
		</div>
	
		<div class="col-xs-12 col-sm-3 perinputwrap">
				<label>Cause:</label>
				<select name="cause" id="cause" class="form-control">
					<option selected="selected" value="<?= $floods->cause ?>">{{ $floods->cause }}</option>
					<option value="hydrometeorological">Hydrometeorological</option>
					<option value="geological">Geological</option>
					<option value="others">Others</option>
				</select>
		</div>
	
		<div class="col-xs-12 col-sm-3 perinputwrap">
				<label>Typhoon name: </label>
				<input type="text" name="typhoon_name" id="typhoon_name" value="<?= $floods->typhoon_name ?>" class="form-control" placeholder="Enter name">
		</div>
	
		<div class="col-xs-12 col-sm-3 perinputwrap">
			<label>Heavy rainfall?</label>
			<select name="heavy_rainfall" id="heavy_rainfall" class="form-control">
				<option selected="selected" value="<?= $floods->heavy_rainfall ?>">{{ $floods->heavy_rainfall }}</option>
				<option value="No">No</option>
				<option value="Yes">Yes</option>
			</select>
		</div>
	
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Source of the report: </label>
		<input type="text" name="author" id="author" value="<?= $floods->author ?>" class="form-control" placeholder="Enter name">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<label>Name of Reporter: </label>
		<input type="text" name="reported_by" id="reported_by" value="<?= $floods->reported_by ?>" class="form-control" placeholder="Enter name">
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap" style="top: -29px">
		<label>Designation/Position of the Reporter: </label>
		<input type="text" name="reporter_pos" id="reporter_pos" value="<?= $floods->reporter_pos ?>" class="form-control" placeholder="Enter position">
	</div>		

	<div class="col-xs-12 col-sm-8 perinputwrap">
		<div id="editcoords" style="min-height: 300px;"></div>
	</div>

	<div class="col-xs-12 col-sm-4 perinputwrap">
		<span class="title defsp">Drag Map marker to change Coordinates</span>
		<div class="col-xs-12 np">
			<label>Latitude:</label>
			<input type="text" name="latitude" id="latitude" class="form-control" value="<?= $floods->latitude ?>"  placeholder="Enter latitude">
		</div>
		<div class="col-xs-12 np">
			<label>Longitude:</label>
			<input type="text" name="longitude" id="longitude" class="form-control" value="<?= $floods->longitude ?>"  placeholder="Enter longitude">
		</div>
		<div class="col-xs-12 perinputwrap np">
				<div class="col-xs-12 text-center np">
						<input class="btn btn-updatelocation"  type="submit" value="Save Flood" style="width: 200px">
						<a class="btn btn-cancel" href="{{ action("FloodController@viewFloods") }}" style="width: 127px">Cancel</a>
				</div>	
		</div>
	</div>
	<div class="col-xs-12 col-md-12 perinputwrap">
		<div class="inside">
			<div id="dZUpload" class="dropzone">
				  <div class="dz-default dz-message">Drop Additional File here or Click to upload additional Image</div>
				  @if(($floods->incident_images != null) || ($floods->incident_images != ""))
				@foreach($floodimages as $key =>$floodimage)
					<span class="mythumbs"><a href="{{$floodimage}}"><img src="{{$floodimage}}" id="{{$key}}" class="mres" /></a>
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
 @if((Auth::user()->id == $floods->created_by) || (Auth::user()->role_id <= 3))
<script type="text/javascript" src="{!! url('assets/dropzone/dropzone.js') !!}"></script>
<script type="text/javascript">
var baseUrl = "{{ url('/') }}";
var token = "{{ Session::token() }}";
var images = [];
var counter = 0;
var mainimages = [];
var checkifnull = {!! json_encode($floodimages) !!};
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

document.getElementById("floodimages").value = images;
Dropzone.autoDiscover = false;
 var myDropzone = new Dropzone("div#dZUpload", { 
     url: "{{$floods->id}}/edituploadfloodimage",
     params: {
        _token: token
      },

      init: function() {
        this.on("error", function(file) {
        	console.log("opapapaooooooooooooopsss");
        }),

        this.on("success", function(file, response) { 
        	var imagefile = baseUrl + '/files/1/Flood Images/'+file["name"] +'-@';
            images[counter] = imagefile;
            images.sort();
      		document.getElementById("floodimages").value = images;
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
  	document.getElementById("floodimages").value = images;
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
			lat:{{$floods->latitude}},
			lng:{{$floods->longitude}}
		},
		zoom:9
	});

	var marker = new google.maps.Marker({
		position:{
			lat:{{$floods->latitude}},
			lng:{{$floods->longitude}}
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