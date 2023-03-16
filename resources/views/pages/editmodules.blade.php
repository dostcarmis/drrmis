@foreach ($data['modules'] as $m)
<div class="row">
    <div class="col-sm-8">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="d-flex">
                    {{$m->name}}
                    <button class="btn btn-primary ms-auto m-edit-btn" mid="{{$m->id}}"><i class="fa fa-pencil float-end" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="panel-body">
                {{$m->description}}<br>
                <i><strong style="color:grey">{{count($m->roleModules(true))}} users have access to this module.</strong></i><br>
                <div class="edit-module-container"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">

    </div>
</div>
    
@endforeach