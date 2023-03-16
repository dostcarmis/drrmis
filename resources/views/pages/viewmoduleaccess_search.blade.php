
@if (count($users) >= 1)
    

    @foreach ($users as $u)
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default" uid="{{$u->id}}" >
                    <div class="panel-heading ma-panel-heading">{{$u->id}} {{$u->first_name." ".$u->last_name}} | {{$u->role->name}}<i class="fa fa-fw fa-caret-down float-end"></i></div>
                    {{-- <div class="panel-body" style="display: none"> --}}
                        <table class="table table-striped" style="display: none">
                            <thead>
                                <th>Module</th>
                                <th>View</th>
                                <th>Add</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($u->access as $access)
                                <tr data-id="{{$access->id}}" class="existing-access">
                                    <td data-toggle="tooltip" title="{{$access->module->description}}">{{$access->module->name}}</td>
                                    <td><input class="access-check" type="checkbox" name="read" value="{{$access->read}}" {{$access->read ? "checked":''}}></td>
                                    <td><input class="access-check" type="checkbox" name="create" value="{{$access->create}}" {{$access->create ? "checked":''}}></td>
                                    <td><input class="access-check" type="checkbox" name="update" value="{{$access->update}}" {{$access->update ? "checked":''}}></td>
                                    <td><input class="access-check" type="checkbox" name="delete" value="{{$access->delete}}" {{$access->delete ? "checked":''}}></td>
                                    <td class="clear-access"><i class="fa fa-trash text-danger" aria-hidden="true" data-toggle="tooltip" title="Remove access"></i></a>
                                </tr>
                                @endforeach
                                @foreach ($u->noAccess() as $item)
                                <tr data-module-id={{$item->id}} class="nonexisting-access">
                                    <td data-toggle="tooltip" title="{{$item->description}}">{{$item->name}}</td>
                                    <td><input class="access-check" type="checkbox" name="read" value=0></td>
                                    <td><input class="access-check" type="checkbox" name="create" value=0></td>
                                    <td><input class="access-check" type="checkbox" name="update" value=0></td>
                                    <td><input class="access-check" type="checkbox" name="delete" value=0></td>
                                    <td><i class="fa fa-info-circle text-info" aria-hidden="true" data-toggle="tooltip" title="These modules are not included in this role's access"></i></a>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6">
                                        <button class="btn btn-sm btn-primary float-end ma-save" >Save Changes</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                            
                        
                    {{-- </div> --}}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6"></div>
        </div>
        
    @endforeach
@else
    No user found.
@endif

<script>
    $(document)
    
    .on('click','.ma-panel-heading',function(e){
        e.stopImmediatePropagation();
        $(this).next('.table').toggle();
        $(this).parent().find('.panel-footer').toggle();
    })
    .on('click','.clear-access', function(){
        $(this).parent().find('input[type=checkbox]').removeAttr('checked').val(0);
    })
</script>