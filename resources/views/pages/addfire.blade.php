@extends('layouts.masters.backend-layout')
@section('page-content')
    <style>
        .labelc{min-width: 100px !important; line-height: 1.5; padding-right: 0;}
        .form-control{max-width: 500px !important;}
        #dZUpload{max-height: 150px;}
    </style>
    <h3>Add Fire Report</h3><hr><br>
    @foreach ($errors->all() as $message)
        <p style="color:red">{{ $message }}</p>
    @endforeach
    <div style="color: red" id="errors"></div>
    <form action="{{route('savefire')}}" id="fire-form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="fireimages" name="fireimages" value="fireimages[]">
    <div class="row">
        <div class="col-sm-6">
            <div class="row mb-3">
                <div class="col-sm-2 labelc"><label class="mt-2" data-toggle="tooltip"  title="This is the date and time of occurence of the fire" for="fire-date">Date</label></div>
                <div class="col-sm-10">
                    <input form="fire-form" type='date' id="fire-date" name="date" placeholder="Date & Time" class="form-control" />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-2 labelc"><label class="mt-2" for="fire-municipality">Municipality</label></div>
                <div class="col-sm-10">
                    <select name="municipality" class="form-control" id="fire-municipality">
                        <option value="0">Select Municipality</option>
                        @foreach ($municipalities as $m)
                            <option value="{{$m->id}}" province_id="{{$m->province_id}}" province="{{$m->province->name}}">{{$m->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-2 labelc"><label class="mt-2" for="fire-province">Province</label></div>
                <div class="col-sm-10"><input form="fire-form" type="text" class="form-control" id="fire-province" name="province" readonly></div></div>
            <div class="row mb-3">
                <div class="col-sm-2 labelc"><label class="mt-2" for="fire-description">Description</label></div>
                <div class="col-sm-10"><textarea form="fire-form" class="form-control" id="fire-description" name="description"></textarea></div></div>
            <div class="row mb-3">
                <div class="col-sm-2 labelc"><label class="mt-2" for="fire-reported">Reported By</label></div>
                <div class="col-sm-10"><input form="fire-form" type="text" class="form-control" id="fire-reported" name="reportedby"></div></div>
            <div class="row mb-3">
                <div class="col-sm-2 labelc"><label class="mt-2" for="fire-casualties">Casualties</label></div>
                <div class="col-sm-10"><input form="fire-form" type="number" value="0" class="form-control" id="fire-casualties" name="casualties"></div></div>
            <div class="row mb-3">
                <div class="col-sm-2 labelc"><label class="mt-2" for="fire-damages">Damages</label></div>
                <div class="col-sm-10"><input form="fire-form" type="number" value="0"  step="0.01" class="form-control" id="fire-damages" name="damages" placeholder=""></div></div>
            <div class="row mb-3">
                <div class="col-sm-2 labelc"><label class="mt-2" for="fire-damages">Type</label></div>
                <div class="col-sm-10">
                    <input type="radio" name="type" id="fire-type-1" checked value="Building/Property"> <label for="fire-type-1">Building/Property</label>
                    <input type="radio" name="type" id="fire-type-2" value="Forest Fire"> <label for="fire-type-2">Forest Fire</label>
                </div></div>
            <div class="row mb-3">
                <div class="col-sm-2 labelc"><label class="mt-2" for="fire-images">Images</label></div>
                <div class="col-sm-10">
                    <div id="dZUpload" class="dropzone form-control pos-rel">
                        <div class="dz-default dz-message pos-a centered">Drop images here or click to upload image</div>
                    </div>
                </div></div>
        </div>
        <div class="col-sm-6">
            <div id="addcoords" style="min-height: 300px;"></div>
            <div class="">
                <span class="title defsp">Drag Map marker to change Coordinates</span>
                <div class="np">
                    <label>Latitude:</label>
                    <input form="fire-form" type="text" name="latitude" id="latitude" class="form-control" value="17.351324" placeholder="Enter latitude">
                </div>
                <div class="np">
                    <label>Longitude:</label>
                    <input form="fire-form" type="text" name="longitude" id="longitude" class="form-control" value="121.17500399999994" placeholder="Enter longitude">
                </div>
                <div class="perinputwrap np">
                    <div class="col-xs-12 text-center np">
                            <input form="fire-form" class="btn btn-updatelocation"  type="submit" value="Save Fire" style="width: 200px">
                    </div>	
                </div>
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
        url: "uploadfireimages",
        params: {
            _token: token
        },
        init: function() {
            this.on("error", function(file) {console.log("ooopppssss");}),
            this.on("success", function(file, response) { 
                var imagefile = baseUrl + '/files/1/Fire Images/'+file["name"] +'-@';
                images[counter] = imagefile;
                document.getElementById("fireimages").value = images;
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
    <script>
        $(document)
        .on("keyup change","#fire-municipality",function(e){
            var province = $(this).find(':selected').attr('province');
            $('#fire-province').val(province);
        })
        .on('submit','#fire-form',function(e){
            e.preventDefault();
            if($('#fire-municipality').val() == 0){
                $('#errors').append("<p>Municipality is required</p>");
                return false;
            }
            let form = $('#fire-form');
            let data = new FormData(this);
            let url = form.attr('action');
            $.ajax({
                type: "POST",
                data: data,
                url: url,
                contentType: false,
                processData: false,
                success:function(res){
                    if(res.success && $.isEmptyObject(res.error) && res.errors == null){
                        alert(res.msg)
                        $('#errors').empty();
                    }else if(res.errors!=null){
                        $('#errors').empty();
                        (res.errors).forEach(function(error){
                            $('#errors').append("<p>"+error+"</p>")
                        })
                        
                    }
                    
                }
            })
        })
	</script>
@endsection