@extends('layouts.masters.sms-module')
@section('page-content')

<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <span class="fa fa-user-plus"></span> 
            Subscribe
        </h1>
    </div>
</div>

<div id="frmmain">      
    <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>
    <span> 
        <strong> Redirecting... </strong> 
    </span>
</div>

@stop
@section('page-js-files')
    <script type="text/javascript">
        window.location.href = "web-subscribe";
    </script>
@stop