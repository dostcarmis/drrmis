<style>
    .m-remarks{
        text-overflow: ellipsis;
        max-width: 300px; 
        /* width: 300px; */
        overflow: hidden;
        white-space: nowrap;
        max-width: ;
    }
    .m-toggle{
        text-decoration: none; color: black;
    }
    #modules-content{
        height: calc(100vh - 220px);
        overflow-y: auto;
    }
</style>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="wrap">
            <div class="dashboardtitle"><h1>Module Management</h1></div>
            <hr>
            <div class="row">
                <div class="col-sm-2">
                    {{-- <div class="list-group">
                        <button type="button" class="list-group-item">View modules</button>
                        <button type="button" class="list-group-item">Create module</button>
                        <button type="button" class="list-group-item">Edit module</button>
                        <button type="button" class="list-group-item">Delete module</button>
                    </div> --}}
                    <ul class="nav nav-pills w-100">
                        <li role="presentation" data-type="view" id="m-view-toggle" class="m-toggle active w-100"><a href="#">View modules</a></li>
                        <li role="presentation" data-type="add" id="m-add-toggle" class="m-toggle  w-100"><a href="#">Create module</a></li>
                        <li role="presentation" data-type="edit" id="m-edit-toggle" class="m-toggle  w-100"><a href="#">Edit module</a></li>
                        <li role="presentation" data-type="delete" id="m-delete-toggle" class="m-toggle  w-100"><a href="#">Delete module</a></li>
                        <li role="presentation" data-type="info" id="m-info-toggle" class="m-toggle  w-100"><a href="#">Implementation</a></li>
                    </ul>
                </div>
                <div class="col-sm-10" id="modules-content" >
                    <div class="panel panel-info">
                        <table class="table table-striped" style="font-size: 14px">
                            <thead>
                                <tr>
                                    <th>Module</th>
                                    <th>Remarks</th>
                                    <th style="text-align: center">Users with access</th>
                                    <th style="text-align: center">Default Roles with access</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modules as $m)
                                    <tr>
                                        <td title="{{$m->description}}" data-toggle="tooltip">{{$m->name}}</td>
                                        <td class="m-remarks" title="{{$m->remarks}}" data-toggle="tooltip"><span>{{$m->remarks ? $m->remarks : "None"}}</span></td>
                                        <td style="text-align: center; cursor: pointer;" class="m-user-count" module="{{$m->id}}">{{count($m->roleModules(true))}}</td>
                                        <td>
                                            @foreach ($m->moduleDefaults as $r)
                                                {{$r->roles->name }},
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>
</div>
<script>
    $(document)
    .on('click','.nav-pills li:not(.active).m-toggle',function(e){
        e.stopImmediatePropagation();
        $('.nav-pills li.active').removeClass('active');
        $(this).addClass('active');
        let type = $(this).attr('data-type');
        let url = baseURL + "modules-crud";
        $.ajax({
            type:"POST",
            data:{type:type},
            url: url,
            success:function(response){
                $('#modules-content').html(response);
                $('[data-toggle="tooltip"]').tooltip();
            }
        })
    })
    //VIEW EVENTS
    .unbind('click','.m-user-count').on('click','.m-user-count',function(e){
        e.stopImmediatePropagation();
        let module_id = $(this).attr('module');
        $.ajax({
            type: "POST",
            url: baseURL+"modules-userlist",
            data:{module_id:module_id},
            success:function(r){
                $('#m-user-list').html(r);
            }
        })
    })
    //ADD EVENTS
    .unbind('click','#m-select-all').on('click','#m-select-all',function(e){
        e.stopImmediatePropagation();
        if($(this).is(':checked')){
            $('#m-new-table-defaults input[type=checkbox][name=role], #m-new-table-defaults input[type=checkbox][name=read]').attr('checked','true').prop('checked',true);
        }else{
            $('#m-new-table-defaults input[type=checkbox][name=role], #m-new-table-defaults .action, .m-select-all-actions').removeAttr('checked').removeProp('checked');
        }
    })
    .unbind('click','.m-select-all-actions').on('click','.m-select-all-actions',function(e){
        e.stopImmediatePropagation();
        let row = $(this).closest('tr');
        if($(this).is(':checked')){
            row.find('.m-select-role, .action').attr('checked','true').prop('checked',true);
        }else{
            row.find('.m-select-role, .action').removeAttr('checked').removeProp('checked');
            $('#m-select-all').removeAttr('checked').removeProp('checked');
        }
    })
    .unbind('click','.m-select-role').on('click','.m-select-role',function(e){
        e.stopImmediatePropagation();
        let row = $(this).closest('tr');
        if($(this).is(':checked')){
            row.find('.action[name=read]').attr('checked','true').prop('checked',true);
        }else{
            row.find('.action').removeAttr('checked').removeProp('checked');
            $('#m-select-all').removeAttr('checked').removeProp('checked');
        }
    })
    .unbind('change','#m-new-table-defaults .action').on('change','#m-new-table-defaults .action',function(e){
        e.stopImmediatePropagation();
        
        let row = $(this).closest('tr');
        if(!$(this).is(':checked')){
            let actions = row.find('.action:checked').length;
            if(actions<4){
                if(actions==0){
                    row.find('.m-select-role').removeAttr('checked').removeProp('checked');
                    $('#m-select-all').removeAttr('checked').removeProp('checked');
                }
                row.find('.m-select-all-actions').removeAttr('checked').removeProp('checked');
            }
            
        }else{
            if(!$(this).is('input[name=read]')){
                row.find('input[name=read]').attr('checked',true).prop('checked',true);
            }else{

            }
        }
    })
    .unbind('submit','#m-new-form').on('submit','#m-new-form', function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        let cnt = $('.m-select-role:checked').length;
        if(cnt == 0){alert("No roles selected")}
        else{
            data = {};
            data['name'] = ($('#m-new-name').val()).trim();
            data['description'] = ($('#m-new-description').val()).trim();
            data['remarks'] = ($('#m-new-remarks').val()).trim();
            data['existing'] = $('#m-for-existing').is(':checked') ? 1: 0;
            data['module-defaults'] = [];
            let rows = $('.m-select-role:checked').closest('tr');
            rows.each(function(){
                let module_default = {
                    role_id: $(this).find('.m-select-role').val(),
                    'read': $(this).find('input[name=read]').is(':checked') ? 1: 0,
                    'create': $(this).find('input[name=create]').is(':checked') ? 1: 0,
                    'update': $(this).find('input[name=update]').is(':checked') ? 1: 0,
                    'delete': $(this).find('input[name=delete]').is(':checked') ? 1: 0,
                };
                data['module-defaults'].push(module_default);
            });
            $.ajax({
                type:"POST",
                url:baseURL+"save-module",
                data:data,
                beforeSend:function(){
                    fireToast('info','Generating module')
                },
                success:function(res){
                    fireToast(res.success, res.message)
                }
            })
        }
    })
    //EDIT EVENTS
    .unbind('click','.m-edit-btn').on('click','.m-edit-btn',function(e){
        let mid = $(this).attr('mid');
        let url = baseURL+'modules-edit';
        let data = {id:mid}
        let el = $(this)
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(res){
                $('#m-edit-form').remove();
                el.closest(".panel").find('.edit-module-container').html(res);
                $('data-toggle[tooltip]').tooltip();
            }
        })
    })
    .unbind('click','#m-edit-select-all').on('click','#m-edit-select-all',function(e){
        e.stopImmediatePropagation();
        if($(this).is(':checked')){
            $('#m-edit-table-defaults input[type=checkbox][name=role], #m-edit-table-defaults input[type=checkbox][name=read]').attr('checked','true').prop('checked',true);
        }else{
            $('#m-edit-table-defaults input[type=checkbox][name=role], #m-edit-table-defaults .action, .m-select-all-actions').removeAttr('checked').removeProp('checked');
        }
    })
    .unbind('submit','#m-edit-form').on('submit','#m-edit-form', function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        let cnt = $('.m-select-role:checked').length;
        var old = $('#m-edit-name').attr('value');
        if(cnt == 0){alert("No roles selected"); return false;}
        else{
            data = {};
            data['name'] = ($('#m-edit-name').val()).trim();
            data['description'] = ($('#m-edit-description').val()).trim();
            data['remarks'] = ($('#m-edit-remarks').val()).trim();
            data['module_id'] = $('#m-edit-id').val();
            data['updateable'] = [];
            data['createable'] = [];
            let createable = $('.createable');
            createable.each(function(){
                let module_default = {
                    role_id: $(this).find('.m-select-role').val(),
                    'read': $(this).find('input[name=read]').is(':checked') ? 1: 0,
                    'create': $(this).find('input[name=create]').is(':checked') ? 1: 0,
                    'update': $(this).find('input[name=update]').is(':checked') ? 1: 0,
                    'delete': $(this).find('input[name=delete]').is(':checked') ? 1: 0,
                };
                data['createable'].push(module_default);
            });
            let updateable = $('.updateable');
            updateable.each(function(){
                let module_default = {
                    id: $(this).attr('mdid'),
                    role_id: $(this).find('.m-select-role').val(),
                    'read': $(this).find('input[name=read]').is(':checked') ? 1: 0,
                    'create': $(this).find('input[name=create]').is(':checked') ? 1: 0,
                    'update': $(this).find('input[name=update]').is(':checked') ? 1: 0,
                    'delete': $(this).find('input[name=delete]').is(':checked') ? 1: 0,
                };
                data['updateable'].push(module_default);
            });
            $.ajax({
                type:"POST",
                url:baseURL+"modules-update",
                data:data,
                beforeSend:function(){
                    fireToast('info','Updating module')
                },
                success:function(res){
                    $('.nav-module').each(function(item){
                        if($(this).text() == old)
                        $(this).text(data['name'])
                    })
                    fireToast(res.success, res.message)
                }
            })
        }
    })
</script>