@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Upload Page</div>

                <div class="panel-body">
                    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
                    <textarea id="my-editor" name="content" class="form-control"></textarea>
                    <script>
                      CKEDITOR.replace( 'my-editor', {
                        filebrowserImageBrowseUrl: '{{ asset("laravel-filemanager?type=Images") }}',
                        filebrowserImageUploadUrl: '{{ asset("laravel-filemanager/upload?type=Images&_token=") }}{{csrf_token()}}',
                        filebrowserBrowseUrl: '{{ asset("laravel-filemanager?type=Files") }}',
                        filebrowserUploadUrl: '{{ asset("laravel-filemanager/upload?type=Files&_token=") }}{{csrf_token()}}'
                      });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
