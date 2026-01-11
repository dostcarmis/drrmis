@extends('layouts.masters.backend-layout')
@section('page-content')

@if((Auth::user()->id == $landslideInventory->validator_id) || (Auth::user()->role_id <= 3))

<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">Edit Landslide Inventory</h1>
    </div>
</div>

@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach

<?php 
    if(!($landslideInventory->incident_images)){
        $landslideInventoryImages = [];  
    }else{
        $landslideInventoryImages = is_string($landslideInventory->incident_images) 
            ? json_decode($landslideInventory->incident_images, true) 
            : $landslideInventory->incident_images;
        if(!is_array($landslideInventoryImages)) {
            $landslideInventoryImages = [];
        }
    }
?>

<p style="color:#00CA00">{{ Session::get('message') }}</p>

<form id="candidateform" action="{{ route('landslide-inventories.update', $landslideInventory->id) }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT">

    <input type="hidden" value="candidateimages[]" name="candidateimages" id="candidateimages" />
    <input type="hidden" name="deleted_images" id="deleted_images" value="">
    
    <div class="col-xs-12 np">
        
        <!-- Candidate ID (Non-editable) -->
        <div class="col-xs-12 col-sm-4 perinputwrap">
            <label>Candidate ID:</label>
            <input type="text" name="candidate_id_display" class="form-control" value="{{ $landslideInventory->candidate_id }}" readonly>
            <input type="hidden" name="candidate_id" value="{{ $landslideInventory->candidate_id }}">
        </div>

        <!-- Validator (Non-editable) -->
        <div class="col-xs-12 col-sm-4 perinputwrap">
            <label>Validator:</label>
            <input type="text" name="validator_name" class="form-control" value="{{ $landslideInventory->validator->full_name }}" readonly>
            <input type="hidden" name="validator_id" value="{{ $landslideInventory->validator->id }}">
        </div>

        <!-- Date (Non-editable) -->
        <div class="col-xs-12 col-sm-4 perinputwrap">
            <label>Date (Best Date):</label>
            <input type="text" name="date_display" class="form-control" value="{{ date('F j, Y', strtotime($landslideInventory->date)) }}" readonly>
            <input type="hidden" name="date" value="{{ $landslideInventory->date }}">
            @if ($errors->has('date')) <span class="reqsymbol">*</span> @endif
        </div>

    </div>

    <div class="col-xs-12 np">

        <!-- Province -->
        <div class="col-xs-12 col-sm-4 perinputwrap">
            <label>Province:</label>
            <select name="province_id" id="province_id" class="form-control">                
                <option value="">Select Province</option>
                @foreach($provinces as $province)
                    @if(old('province_id', $landslideInventory->province_id) == $province->id)             
                        <option selected="selected" value="{{ $province->id }}">{{ $province->name }}</option> 
                    @else
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                    @endif  
                @endforeach
            </select>
            @if ($errors->has('province_id')) <span class="reqsymbol">*</span> @endif
        </div>

        <!-- Municipality -->
        <div class="col-xs-12 col-sm-4 perinputwrap">
            <label>Municipality:</label>
            <select name="municipality_id" id="municipality_id" class="form-control">
                <option value="">Select Municipality</option>
                @foreach($municipalities as $municipality)
                    @if(old('municipality_id', $landslideInventory->municipality_id) == $municipality->id)   
                        <option selected="selected" value="{{ $municipality->id }}">{{ $municipality->name }}</option>
                    @else
                        <option value="{{ $municipality->id }}">{{ $municipality->name }}</option>
                    @endif
                @endforeach
            </select>
            @if ($errors->has('municipality_id')) <span class="reqsymbol">*</span> @endif
        </div>

        <!-- Location -->
        <div class="col-xs-12 col-sm-4 perinputwrap">
            <label>Location:</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $landslideInventory->location) }}" placeholder="Enter location" required>
            @if ($errors->has('location')) <span class="reqsymbol">*</span> @endif
        </div>

    </div>

    <div class="col-xs-12 np">

        <!-- Area (m²) -->
        <div class="col-xs-12 col-sm-4 perinputwrap">
            <label>Area (m²):</label>
            <input type="number" step="any" name="area_m2" id="area_m2" class="form-control" value="{{ old('area_m2', $landslideInventory->area_m2) }}" placeholder="Square meters (m²)" required>
            @if ($errors->has('area_m2')) <span class="reqsymbol">*</span> @endif
        </div>

        <!-- Validation Status -->
        <div class="col-xs-12 col-sm-4 perinputwrap">
            <label>Validation Status:</label>
            <select name="validation_id" id="validation_id" class="form-control" required>
                <option value="">-- Select Validation Status --</option>
                @foreach($landslideInventoryValidations as $status)
                    <option value="{{ $status->id }}" {{ old('validation_id', $landslideInventory->validation_id) == $status->id ? 'selected' : '' }}>
                        {{ $status->name }}
                    </option>
                @endforeach
            </select>
            @if ($errors->has('validation_id')) <span class="reqsymbol">*</span> @endif
        </div>

    </div>

    <!-- Map and Coordinates Section -->
    <div class="col-xs-12 col-sm-8 perinputwrap">
        <div id="editcoords" style="min-height: 400px;"></div>
    </div>

    <div class="col-xs-12 col-sm-4 perinputwrap">
        <span class="title defsp">Drag Map marker to change Coordinates</span>
        <div class="col-xs-12 np">
            <label>Latitude:</label>
            <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude', $landslideInventory->latitude) }}" placeholder="Enter latitude" required>
            @if ($errors->has('latitude')) <span class="reqsymbol">*</span> @endif
        </div>
        <div class="col-xs-12 np">
            <label>Longitude:</label>
            <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude', $landslideInventory->longitude) }}" placeholder="Enter longitude" required>
            @if ($errors->has('longitude')) <span class="reqsymbol">*</span> @endif
        </div>
        <div class="col-xs-12 perinputwrap np">
            <div class="col-xs-12 text-center np">
                <input class="btn btn-updatelocation" type="submit" value="Update">
                <a class="btn btn-cancel" href="{{ route('landslide-inventories.show', $landslideInventory->id) }}">Cancel</a>
            </div>  
        </div>
    </div>

    <!-- Image Upload Section -->
    <div class="col-xs-12 col-md-12 perinputwrap">
        <div class="inside">
            <div id="dZUpload" class="dropzone">
                <div class="dz-default dz-message">Drop Additional File here or Click to upload additional Image</div>
                @if(!empty($landslideInventoryImages))
                    @foreach($landslideInventoryImages as $key => $landslideInventoryImage)
                        <span class="mythumbs">
                            <a href="{{ asset($landslideInventoryImage) }}">
                                <img src="{{ asset($landslideInventoryImage) }}" id="{{ $key }}" class="mres" />
                            </a>
                            <div class="col-xs-12 np text-center removeimagewrap">
                                <a title="Remove Image" href="#" class="removeimage">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </div>
                        </span>              
                    @endforeach
                @endif
            </div>
        </div>
    </div>

</form>

@else
<h2>Insufficient Permission!!!</h2>
<span class="defsp"><img src="{{ url('assets/images/goodjob.gif') }}"></span>
@endif

@endsection

@section('page-js-files')
@if((Auth::user()->id == $landslideInventory->validator_id) || (Auth::user()->role_id <= 3))

<script type="text/javascript" src="{{ url('assets/dropzone/dropzone.js') }}"></script>
<script type="text/javascript">
var baseUrl = "{{ url('/') }}";
var token = "{{ csrf_token() }}";
var images = [];
var counter = 0;
var mainimages = [];
var checkifnull = {!! json_encode($landslideInventoryImages) !!};

if(checkifnull != '' && checkifnull != null){
    images = checkifnull;
    counter = images.length;
    for (var i = 0; i < images.length; i++) {
        images[i] = images[i] + '-@'; 
    }
}else{
    images = [];
    counter = 0;
}

document.getElementById("candidateimages").value = images;

Dropzone.autoDiscover = false;
var myDropzone = new Dropzone("div#dZUpload", { 
    url: "{{ route('landslide-inventories.uploadimage', $landslideInventory->id) }}",
    params: {
        _token: token
    },
    init: function() {
        this.on("error", function(file, errorMessage) {
            console.log("Upload error:", errorMessage);
        });

        this.on("success", function(file, response) { 
            if(response.success) {
                var imagefile = response.path + '-@';
                images[counter] = imagefile;
                images.sort();
                document.getElementById("candidateimages").value = images;
                console.log(images);
                counter++;
            }
        });
    }
});

Dropzone.options.myAwesomeDropzone = {
    paramName: "file", 
    maxFilesize: 5, 
    addRemoveLinks: true,
    acceptedFiles: "image/*"
};

var deletedImages = [];
$('.removeimage').on('click', function(e){
    e.preventDefault();
    
    if(confirm('Are you sure you want to remove this image?')) {
        var removefromarrayindex = $(this).parent().parent().find('img').attr('id');
        $(this).parent().parent().remove();
        
        // Track deleted images
        deletedImages.push(removefromarrayindex);
        $('#deleted_images').val(JSON.stringify(deletedImages));
        
        // Remove from images array
        images.splice(removefromarrayindex, 1);
        images.sort();
        document.getElementById("candidateimages").value = images;
    }
});
</script>

<script type="text/javascript">
    var latitude = parseFloat("{{ $landslideInventory->latitude }}") || 16.0;
    var longitude = parseFloat("{{ $landslideInventory->longitude }}") || 120.5;

    var map = new google.maps.Map(document.getElementById('editcoords'),{
        center:{
            lat: latitude,
            lng: longitude
        },
        zoom: 15,
        mapTypeId: 'satellite'
    });

    var landslideIcon = {
        url: "{{ asset('assets/images/landslideicon.png') }}",
        scaledSize: new google.maps.Size(30, 30) 
    };

    var marker = new google.maps.Marker({
        position:{
            lat: latitude,
            lng: longitude
        },
        map: map,
        draggable: true,
        icon: landslideIcon
    });

    google.maps.event.addListener(marker, 'dragend', function(){
        $('#latitude').val(marker.getPosition().lat());
        $('#longitude').val(marker.getPosition().lng());
    });

    // Update marker when coordinates are manually changed
    $('#latitude, #longitude').on('change', function() {
        var newLat = parseFloat($('#latitude').val());
        var newLng = parseFloat($('#longitude').val());
        
        if (!isNaN(newLat) && !isNaN(newLng)) {
            var newPos = new google.maps.LatLng(newLat, newLng);
            marker.setPosition(newPos);
            map.setCenter(newPos);
        }
    });
</script>

<script>
    $(function() {
        $('#province_id').bind("keyup change", function(e){
            var cat_id = e.target.value;
            $('#municipality_id').removeAttr('disabled');
            $.ajax({
                type: 'GET',
                url: '{{ url("province-show") }}?cat_id=' + cat_id,
                success:function(municipalities){
                    var item = $('#municipality_id');
                    item.empty();
                    item.append("<option value=''>Select Municipality</option>");
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

@section('page-css-files')
<style>
    .perinputwrap {
        margin-bottom: 15px;
    }
    
    .perinputwrap label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }
    
    .reqsymbol {
        color: red;
        font-size: 16px;
        margin-left: 5px;
    }
    
    .np {
        padding: 0;
    }
    
    .inside {
        padding: 10px;
    }
    
    .mythumbs {
        display: inline-block;
        margin: 5px;
        position: relative;
    }
    
    .mythumbs img.mres {
        max-width: 150px;
        max-height: 150px;
        border: 2px solid #ddd;
        border-radius: 4px;
    }
    
    .removeimagewrap {
        margin-top: 5px;
    }
    
    .removeimage {
        color: #d9534f;
        cursor: pointer;
    }
    
    .removeimage:hover {
        color: #c9302c;
    }
    
    .dropzone {
        border: 2px dashed #0087F7;
        border-radius: 5px;
        background: white;
        min-height: 150px;
        padding: 20px;
    }
    
    .dropzone .dz-message {
        text-align: center;
        margin: 2em 0;
        font-weight: bold;
        color: #999;
    }
    
    .btn-updatelocation {
        background-color: #5cb85c;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 4px;
        margin: 10px 5px;
    }
    
    .btn-updatelocation:hover {
        background-color: #449d44;
    }
    
    .btn-cancel {
        background-color: #d9534f;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 4px;
        margin: 10px 5px;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-cancel:hover {
        background-color: #c9302c;
        color: white;
        text-decoration: none;
    }
    
    #editcoords {
        border: 2px solid #ddd;
        border-radius: 4px;
    }
    
    .title.defsp {
        display: block;
        font-weight: bold;
        margin-bottom: 10px;
        font-size: 14px;
    }
    
    /* Mobile Responsive Styles */
    @media (max-width: 767px) {
        .col-xs-12.col-sm-4,
        .col-xs-12.col-sm-8 {
            margin-bottom: 15px;
        }
        
        #editcoords {
            min-height: 300px !important;
        }
        
        .btn-updatelocation,
        .btn-cancel {
            width: 100%;
            margin: 5px 0;
        }
        
        .mythumbs img.mres {
            max-width: 120px;
            max-height: 120px;
        }
    }
    
    @media (max-width: 480px) {
        .perinputwrap {
            padding: 0 5px;
        }
        
        #editcoords {
            min-height: 250px !important;
        }
    }
</style>
@endsection