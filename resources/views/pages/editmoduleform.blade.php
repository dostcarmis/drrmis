<form action="" id="m-edit-form" class="mt-3">
    <input type="hidden" value="{{$module->id}}" id="m-edit-id">
    <div class="panel panel-default">
        <div class="panel-heading">
            Basic Information
        </div>
        <div class="panel-body">
            <input type="text" value="{{$module->name}}" id="m-edit-name" class="form-control mb-3" name="name" required placeholder="Module Name">
            <input type="text"  value="{{$module->description}}" id="m-edit-description" class="form-control mb-3" name="description" required placeholder="Description">
            <textarea name="remarks"  id="m-edit-remarks" placeholder="Remarks" class="form-control">{{$module->remarks}}</textarea>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            Module Defaults
            <i class="fa fa-info-circle text-info float-end" aria-hidden="true" data-toggle="tooltip" title="Creating accounts with the selected roles will give them access to the module's selected actions." ></i>
        </div>
        <div class="panel-body">
            Select roles with access to this module:<br>
        </div>
        <table class="table table-striped" id="m-edit-table-defaults">
            <thead>
                <tr>
                    <th><input type="checkbox" id="m-edit-select-all"><i class="fa fa-level-down" aria-hidden="true"></i></th>
                    <th></th>
                    <th style="text-align: center">View</th>
                    <th style="text-align: center">Add</th>
                    <th style="text-align: center">Edit</th>
                    <th style="text-align: center">Delete</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($module->moduleDefaults as $md)
                <tr mdid={{$md->id}} class="updateable">
                    <td><input class="m-select-role" type="checkbox" value="{{$md->role_id}}" name="role" id="role-{{$md->role_id}}"
                        {{$md->read == 1 ||$md->create == 1 ||$md->update == 1 ||$md->delete == 1 ? "checked" : ''}}></td>
                    <td><label for="role-{{$md->role_id}}">{{$md->roles->name}}</label></td>
                    <td style="text-align: center"><input type="checkbox" class="action" name="read" {{$md->read == 1 ? 'checked':''}}></td>
                    <td style="text-align: center"><input type="checkbox" class="action" name="create" {{$md->create == 1 ? 'checked':''}}></td>
                    <td style="text-align: center"><input type="checkbox" class="action" name="update" {{$md->update == 1 ? 'checked':''}}></td>
                    <td style="text-align: center"><input type="checkbox" class="action" name="delete" {{$md->delete == 1 ? 'checked':''}}></td>
                    <td style="text-align: center">
                        <i class="fa fa-level-up" aria-hidden="true" style="transform: rotate(-90deg)"></i>
                        <input type="checkbox" class="m-select-all-actions">
                    </td>
                </tr>  
                @endforeach
                @foreach ($module->noAccess() as $mna)
                <tr class="createable">
                    <td><input class="m-select-role" type="checkbox" value="{{$mna->id}}" name="role" id="role-{{$mna->id}}"></td>
                    <td><label for="role-{{$mna->id}}">{{$mna->name}}</label></td>
                    <td style="text-align: center"><input type="checkbox" class="action" name="read" ></td>
                    <td style="text-align: center"><input type="checkbox" class="action" name="create" ></td>
                    <td style="text-align: center"><input type="checkbox" class="action" name="update" ></td>
                    <td style="text-align: center"><input type="checkbox" class="action" name="delete" ></td>
                    <td style="text-align: center">
                        <i class="fa fa-level-up" aria-hidden="true" style="transform: rotate(-90deg)"></i>
                        <input type="checkbox" class="m-select-all-actions">
                    </td>
                </tr>  
                @endforeach
            </tbody>
        </table>
        </div>
    <button class="btn btn-primary float-end" id="submit-m-edit-form">Save</button>
</form>