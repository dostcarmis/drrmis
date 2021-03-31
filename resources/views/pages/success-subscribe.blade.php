@extends('layouts.masters.sms-module')
@section('page-content')

<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <span class="fa fa-user-plus"></span> 
            Subscribe
        </h1>
    </div>
    <div id="user-id" class="hidden">{{Auth::user()->id}}</div>
</div>

<div id="frmmain">
    <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>
    <span> 
        <strong> Subscribing... </strong> 
    </span>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-success" role="dialog">
    <div class="modal-dialog">
  
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success">
                    <h3>
                        <strong>Success!</strong> You are now subscribed!
                    </h3>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-failed1" role="dialog">
    <div class="modal-dialog">
  
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h3>
                        <strong>Failed!</strong> "Please edit your contact number."
                    </h3>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-failed2" role="dialog">
    <div class="modal-dialog">
  
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h3>
                        <strong>Failed!</strong> "Unknown error occured."
                    </h3>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-failed3" role="dialog">
        <div class="modal-dialog">
      
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h3>
                            <strong>Failed!</strong> "You are already subscribed!"
                        </h3>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

@stop
@section('page-js-files')
    <script src="{!! url('assets/js/sms-subscribe.js') !!}"></script>
@stop