@extends('layouts.masters.other-layouts')
@section('page-content')
<div class="container-fluid">
    <div class="row">
        <div id="dashboard" class="col-xs-12">
            <h1>Generate KML</h1>
        </div>
        <div class="col-xs-12">
        	<form  id="userform" action="{{ action('GenerateKmlController@postGenerate') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-xs-12 np">
                <input class ="btn btn-updatelocation"  type="submit" value="Generate">
            </div>
            </form>
        </div>
    </div>
</div>

@stop
