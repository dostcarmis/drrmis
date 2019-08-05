@extends('layouts.masters.backend-layout')
@section('page-content')
    
<h1>Uploading Image using dropzone.js and Laravel</h1>
{!! Form::open([ 'route' => [ 'image.store' ], 'files' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'book-image' ]) !!}
<div class="mymessages">
    
</div>
{!! Form::close() !!}

 @stop
@section('page-js-files')
<script type="text/javascript" src="{!! url('assets/dropzone/dropzone.js') !!}"></script>
<script type="text/javascript" src="{!! url('assets/js/dropzone-config.js') !!}"></script>
@stop