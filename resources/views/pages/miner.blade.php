@extends('layouts.masters.other-layouts')
@section('page-content')
<div class="container-fluid">
    <div class="row">

        <div id="dashboard" class="col-xs-12">
            <h1>Day to Day Download</h1>
        </div>
        <div class="col-xs-12">
        	<form  id="userform" action="{{ action('PagesController@saveMiner') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class='col-sm-6 np'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' name="datemonth" class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>


            <div class="col-xs-12 np">
                <input class ="btn btn-updatelocation"  type ="submit" value="Download">
            </div>
            </form>
        </div>
 
    </div>
</div>

@stop
@section('page-js')
<script type="text/javascript">
  jQuery(function($){
    var today = new Date();
    var mxdate = (today.getMonth()+1 )+'/'+today.getDate()+'/'+today.getFullYear();

    $('#datetimepicker1').datetimepicker({
      format: 'MM/DD/YYYY',
      maxDate: mxdate
    });
  });
</script>
@stop