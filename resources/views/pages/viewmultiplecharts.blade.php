<?php
use App\Http\Controllers\ChartController;
$counter = 0;

$provincefilter = '';
   if(isset($_GET['pfilter'])){
      $provincefilter = intval($_GET['pfilter']);
    }
?>
@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
        	<h1 class="page-header">Multiple Charts</h1>
        </div>
        <div class="col-xs-12 np">
            <form action="{{ action('ChartController@filterChart') }}">
            <div class="col-xs-12">
                <div class="col-xs-12 well per-inputhydrometfilter">
                    <div class="col-xs-12 col-sm-8">
                        <select name="pfilter" id="pfilter" class="form-control">
                            <option value="0">All Provinces</option>
                            @foreach($provinces as $province)
                                @if($province->id == $provincefilter)
                                <option selected="selected" value="{{ $province->id }}">{{ $province->name }}</option>
                                @else
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endif              
                            @endforeach
                        </select>
                    <input type="submit" class="btn btn-submit btn-filter" value="Filter" id="filter_table" name="filter_table">
                    </div>
                </div>
            </div>
        </form>         
        </div>
        <div class="col-xs-12 np chartwrap">

        	@foreach($sensors as $sensor)
        		<?php       			        			
        			$csvcontents[$counter++] = ChartController::getcsv($sensor->assoc_file,$sensor->dev_id);
        		?>
        	@endforeach  
            <?php 
                $fcsvcontents = array_values(array_filter($csvcontents));
                foreach ($sensors as $sensor) {
                    foreach ($fcsvcontents as $fcsvcontent) {
                        if ($fcsvcontent[0]['dev_id'] == $sensor->dev_id) { ?>
                                    <div id="perchart" class="col-xs-12 col-sm-6">
                                        <span class="mname">{{$sensor->address}}</span>
                                        <div id="persensorchart-{{$sensor->dev_id}}"></div>
                                    </div>
                          <?php                            
                        }                        
                    }
                }

             ?>      	
        </div>
    </div>
</div>
@stop
@section('page-js-files')
<script type="text/javascript">
    var csvcontents = {!! json_encode($fcsvcontents) !!}; 

</script>
<script src="{!! url('assets/js/multiplechart.js')!!}"></script>
@stop
