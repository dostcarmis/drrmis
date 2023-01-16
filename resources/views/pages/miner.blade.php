@extends('layouts.masters.other-layouts')
@section('page-content')
<div class="container-fluid">
    <div class="row">

        <div id="dashboard" class="col-xs-12">
            <h1>Day to Day Download</h1>
        </div>
    </div>
    
    <form  id="userform" action="{{ action('PagesController@saveMiner') }}" method="post">
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' name="datemonth" class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                {{-- <div>
                    <input class ="btn btn-updatelocation"  type ="submit" value="Download">
                </div> --}}
            </div>
        </div>
    </form>

    <div class="row mt-3">
        <div class="col-sm-6"> 
            <progress id="progressbar" style="display:none; padding:0 !important" class="form-control">
            </progress>
            <span style="font-weight:bolder; display: none" class="download-status"></span>
            <br>
            <button class="btn btn-updatelocation" id="test">Download</button>
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
    $(document).on('click',"#test",function(){
        var sensors;
        var failed = [];
        $.ajax({
            type:"POST",
            url:"{{route('getsensorlist')}}",
            data:{},
            success:function(res){
                sensors = res.sensors;
                let max = sensors.length;
                $('#progressbar').show().attr('max',max).val(0);
                for(let i = 0; i < max; i++){
                    downloadData(sensors[i]);
                }
                
            }
        });
    })

    function downloadData(id){
        $.ajax({
            type:"POST",
            url:"{{route('startmining')}}",
            data:{'id':id},
            success:function(res){
                if(res.success){
                    let fin = parseInt($('#progressbar').val());
                    let max = parseInt($('#progressbar').attr('max'));
                    $('#progressbar').val(++fin);
                    $('.download-status').show();
                    if($('#progressbar').val() == max){
                        $('.download-status').text("Download complete");
                    }else{
                        $('.download-status').text("Downloaded data for sensor #"+res.id);
                    }
                }else{
                    if(res.error){
                        console.log([res.error,('id:'+res.id)]);
                    }
                }
            }
        });
    }
</script>
@stop