@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Add Accident Report</h1>
	</div>
</div>

        <div id="dZUpload" class="dropzone">
            <div class="dz-default dz-message">Drop File here or Click to upload Image</div>
        </div>
@stop
@section('page-js-files')
<script type="text/javascript" src="{!! url('assets/dropzone/dropzone.js') !!}"></script>
<script type="text/javascript">
            var baseUrl = "{{ url('/') }}";
            var token = "{{ Session::token() }}";
            Dropzone.autoDiscover = false;
             var myDropzone = new Dropzone("div#dZUpload", { 
                 url: "upload-2",
                 params: {
                    _token: token
                  }
             });
             Dropzone.options.myAwesomeDropzone = {
                paramName: "file", // The name that will be used to transfer the file
                maxFilesize: 2, // MB
                addRemoveLinks: true,
                accept: function(file, done) {
                  
                },
              };
         </script>
@stop