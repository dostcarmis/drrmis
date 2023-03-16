<style>
    #roles-content{
        height: calc(100vh - 230px);
        overflow-y: auto;
    }
</style>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="wrap">
            <div class="dashboardtitle"><h1>Role Management</h1></div>
            <hr>
            <div class="row">
                <div class="col-sm-6" id="roles-content">
                    @foreach ($roles as $r)
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="d-flex">
                                    {{$r->name}}
                                    <div class="ms-auto">
                                        <button class="btn btn-primary ms-auto r-edit-btn" rid = {{$r->id}} rdesc="{{$r->description}}" rname="{{$r->name}}"><i class="fa fa-pencil" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn btn-{{count($r->users) > 0 ? 'default': 'danger'}} ms-auto r-delete-btn" {{count($r->users) > 0 ? 'disabled': ''}} rid = {{$r->id}}><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="panel-body">{{$r->description}}<br>
                            <strong style="color:grey;">{{count($r->users)}} users have this role</strong>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-sm-6" id="role-forms">
                    <div id="create-role-div" style="display: none">
                        <form action="" id="create-role-form">
                            <h4>Create Role</h4>
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <input type="text" required name="name" class="form-control mt-3" placeholder="Role Name">
                                    <input type="text" required name="description" class="form-control mt-3" placeholder="Description">
                                    <button class="btn btn-primary float-end mt-3" id="r-save">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="edit-role-div"  style="display: none">
                        <form action="" id="edit-role-form">
                            <h4>Edit Role</h4>
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <input type="hidden" name="id">
                                    <input type="text" name="name" class="form-control mt-3" placeholder="Role Name">
                                    <input type="text" name="description" class="form-control mt-3" placeholder="Description">
                                    <button class="btn btn-primary float-end mt-3" id="r-edit-save">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-6">
                    <button class="btn btn-primary float-end" id="r-create-btn"><i class="fa fa-plus" aria-hidden="true"></i> Create</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document)
    .on('click','#r-create-btn',function(e){
        e.stopImmediatePropagation();

        $('#edit-role-div').hide(1,function(){
            $('#create-role-div').fadeIn();
        });
    })
    .on('click','.r-edit-btn',function(e){
        e.stopImmediatePropagation();
        let name = $(this).attr('rname');
        let desc = $(this).attr('rdesc');
        let id = $(this).attr('rid');
        $('#create-role-div').hide(1,function(){
            $('#edit-role-form').find('input[name="id"]').val(id)
            $('#edit-role-form').find('input[name="name"]').val(name)
            $('#edit-role-form').find('input[name="description"]').val(desc)
            $('#edit-role-div').fadeIn();
        });
    })
    .on('click','.r-delete-btn',function(e){
        if(confirm("Are you sure you want to delete this role?")){
            e.stopImmediatePropagation();
            let id = $(this).attr('rid');
            $.ajax({
                type:"POST",
                url:baseURL+"role-delete",
                data: {'id':id},
                success:function(response){
                    $(e.target).closest('.panel').remove();
                    fireToast(response.success,response.message);
                }
            })
        }
        
    })
    .on('submit','#create-role-form',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        let form = document.getElementById('create-role-form');
        let data = new FormData(form);
        $.ajax({
            type:"POST",
            url:baseURL+"role-save",
            data: data,
            processData: false,
            contentType: false,
            success:function(response){
                fireToast(response.success,response.message);
            }
        })
    })
    .on('submit','#edit-role-form',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        let form = document.getElementById('edit-role-form');
        let data = new FormData(form);
        $.ajax({
            type:"POST",
            url:baseURL+"role-update",
            data: data,
            processData: false,
            contentType: false,
            success:function(response){
                fireToast(response.success,response.message);
            }
        })
    })
</script>