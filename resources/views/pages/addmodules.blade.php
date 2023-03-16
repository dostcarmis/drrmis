<style>
    #m-loading{
        display: flex;
        vertical-align: middle;
    }
    #m-circle{
        border-radius: 50%;
        border: 3px solid blue;
        border-top: 3px solid white;
        animation: spin 1s infinite;
        width: 20px;
        height: 20px;
    }
    @keyframes spin{
        from{transform: rotate(0deg)}
        to{transform: rotate(360deg)}
    }
</style>
<div class="row">
    <div class="col-sm-6">
        <form action="" id="m-new-form">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Basic Information
                </div>
                <div class="panel-body">
                    <input type="text" id="m-new-name" class="form-control mb-3" name="name" required placeholder="Module Name">
                    <input type="text" id="m-new-description" class="form-control mb-3" name="description" required placeholder="Description">
                    <textarea name="remarks" id="m-new-remarks" placeholder="Remarks" class="form-control"></textarea>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    Module Defaults
                    <i class="fa fa-info-circle text-info float-end" aria-hidden="true" data-toggle="tooltip" title="Creating accounts with the selected roles will give them access to the module's selected actions." ></i>
                </div>
                <div class="panel-body">
                    Select roles with access to this module:<br>
                </div>
                <table class="table table-striped" id="m-new-table-defaults">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="m-select-all"><i class="fa fa-level-down" aria-hidden="true"></i></th>
                            <th></th>
                            <th style="text-align: center">View</th>
                            <th style="text-align: center">Add</th>
                            <th style="text-align: center">Edit</th>
                            <th style="text-align: center">Delete</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['roles'] as $r)
                        <tr>
                            <td><input class="m-select-role" type="checkbox" value="{{$r->id}}" name="role" id="role-{{$r->id}}"></td>
                            <td><label for="role-{{$r->id}}">{{$r->name}}</label></td>
                            <td style="text-align: center"><input type="checkbox" class="action" name="read"></td>
                            <td style="text-align: center"><input type="checkbox" class="action" name="create"></td>
                            <td style="text-align: center"><input type="checkbox" class="action" name="update"></td>
                            <td style="text-align: center"><input type="checkbox" class="action" name="delete"></td>
                            <td style="text-align: center">
                                <i class="fa fa-level-up" aria-hidden="true" style="transform: rotate(-90deg)"></i>
                                <input type="checkbox" class="m-select-all-actions">
                            </td>
                        </tr>     
                        @endforeach
                    </tbody>
                </table>
                </div>
            <button class="btn btn-primary float-end" id="submit-m-new-form">Save</button>
        </form>
    </div>
    <div class="col-sm-6">
        <div id="m-loading" style="display: none"><div id="m-circle"></div><div class="ms-3">Creating module and accesses</div></div>
    </div>
</div>
