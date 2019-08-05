@extends('layouts.masters.backend-layout')

@section('page-content')

@if(($currentUser->id == $floods->created_by) || ($currentUser->role_id <= 3))

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

	@if($currentUser->role_id != 5)

		<div class="col-xs-12 perinputwrap">

			<div class="col-xs-6 npl">

				<label>Report Status:</label>

					<select name="report_status" id="report_status" class="form-control">

						@if($floods->report_status === 'Published')

						<option value="Pending">Pending</option>

						<option selected="selected" value="Published">Published</option>

						@else

						<option selected="selected" value="Pending">Pending</option>

						<option  value="Published">Published</option>

						@endif

					</select>

			</div>

		</div>	

	@endif

	<div class="col-xs-12 col-sm-6 perinputwrap dates">

		<label>Date & Time</label>

		<div class='input-group date' id="date">

            <input type='text' value="<?= $floods->date ?>" name="date" placeholder="Date & Time" class="form-control" />

            <span class="input-group-addon">

                <span class="glyphicon glyphicon-calendar"></span>

            </span>

            @if ($errors->has('date')) <span class="reqsymbol">*</span> @endif

        </div>

	</div>

	<div class="col-xs-12 np">

		<div class="col-xs-12 col-sm-6 perinputwrap">

			<label>Location:</label>

			<input type="text" value="<?= $floods->location ?>" name="location" id="location" class="form-control" placeholder="Enter location">

			@if ($errors->has('location')) <span class="reqsymbol">*</span> @endif

		</div>

		<div class="col-xs-12 col-sm-6 perinputwrap">

			<label>Province:</label>

			<select name="province_id" id="province_id" class="form-control">

				@foreach($provinces as $province)				

					@if($floods->province_id == $province->id)

					<option selected="selected" value="{{ $province->id }}">{{ $province->name }}</option>

					@else

					<option value="{{ $province->id }}">{{ $province->name }}</option>

					@endif		

				@endforeach

			</select>

		</div>





	</div>

	<div class="col-xs-12 col-sm-6 perinputwrap">

			<div id="editcoords" style="min-height: 300px;"></div>

	</div>

	<div class="col-xs-12 col-sm-6 perinputwrap">

	<span class="title defsp">Drag Map marker to change Coordinates</span>

		<div class="col-xs-12 np">

			<label>Latitude:</label>

			<input type="text" value="<?= $floods->latitude ?>" name="latitude" id="latitude" class="form-control" placeholder="Enter latitude">

		</div>

		<div class="col-xs-12 np">

			<label>Longitude:</label>

			<input type="text" value="<?= $floods->longitude ?>" name="longitude" id="longitude" class="form-control" placeholder="Enter longitude">

		</div>

		

	</div>

	<div class="col-xs-12 perinputwrap">

		<label>Source:</label>

		<input type="text" value="<?= $floods->author ?>" name="author" id="author" class="form-control" placeholder="Enter Author / Office">

		@if ($errors->has('author')) <span class="reqsymbol">*</span> @endif

	</div>

	<div class="col-xs-12 perinputwrap">

		<label>Images:</label>

		<div class="col-xs-12 landslideimageswrap">

			@if(($floods->incident_images != null) || ($floods->incident_images != ""))

				@foreach($floodimages as $key => $floodimage)

					<span class="mythumbs"><a href="{{$floodimage}}"><img src="{{$floodimage}}" id="{{$key}}" class="mres" /></a>

						<div class="col-xs-12 np text-center removeimagewrap"><a title="Remove Image" href="#" class="removeimage"><span class="glyphicon glyphicon-trash"></span></a></div>

					</span>				

				@endforeach

			@endif

			<div id="dZUpload" class="dropzone">

			      <div class="dz-default dz-message">Drop File here or Click to upload Image</div>

			</div>

		</div>	

	</div>

	<div class="col-xs-12 perinputwrap">

		<label>Description:</label>

		<textarea class="piw-textarea form-control" name="description" placeholder="Enter description" id="piw-textarea"><?= $floods->description ?></textarea>

	</div>	

	<div class="col-xs-12 perinputwrap text-right">

		

		<a class ="btn btn-update" title="Update" data-toggle="modal" data-target="#mymodal">Update</a>

		<a class="btn btn-cancel" href="{{ action("FloodController@viewFloods") }}">Cancel</a> 

		<a class ="btn btn-preview" title="View Report" href="<?php echo url('viewperflood'); ?>/{{$floods->id}}">Preview</a>

	@include('pages.editdialogflood')

	</div>

</form>

@else

<h2>Insufficient Permission!!!</h2>

<span class="defsp"><img src="<?php echo url('assets/images/goodjob.gif');?>"></span>

@endif

 @endsection

 @section('page-js-files')

 @if(($currentUser->id == $floods->created_by) || ($currentUser->role_id <= 3))

<script type="text/javascript" src="{!! url('assets/dropzone/dropzone.js') !!}"></script>

<script type="text/javascript">

var baseUrl = "{{ url('/') }}";

var token = "{{ Session::getToken() }}";

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

@endif

@endsection