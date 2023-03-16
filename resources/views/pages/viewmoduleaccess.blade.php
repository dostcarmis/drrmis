<style>
    .table td, .table th {/* input[type=checkbox] */
        text-align: center;
        vertical-align: middle;
    }
    .fa.fa-trash.text-danger{cursor: pointer;}
</style>
<div id="page-wrapper">
    <div class="container-fluid" id="clear-fluid">
        <div class="wrap">
            <div class="dashboardtitle"><h1>User Module Access</h1></div>
            <hr>
            <form id="ma-search-form" class="w-25">
                <div class="input-group">
                    <input type="text" class="form-control" id="ma-search" name="ma-search" placeholder="Search user" aria-describedby="ma-search-icon">
                    <span class="input-group-addon py-0 px-3" id="ma-search-icon"><button type='submit' class="border-none"><i class="fa fa-search" aria-hidden="true"></i></button></span>
                </div>
            </form>
            <hr>
            <div id="the-ma-table" class="mt-3">
                
                
            </div>
        </div>
    </div>
</div>


<script>
    $(document)
    .on('submit','#ma-search-form',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        let search = $('#ma-search').val();
        $.ajax({
            type:"POST",
            url:"{{route('ma-search')}}",
            data:{'ma-search':search},
            success:function(res){
                $('#the-ma-table').html(res);
                $('[data-toggle="tooltip"]').tooltip();
            }
        })
    })
    .on('click','.ma-save',function(e){
        e.stopImmediatePropagation();
        let uid = $(this).closest('.panel').attr('uid');
        let panel = '.panel[uid='+uid+']';
        let accesses = $(panel+' .existing-access');
        let noaccess = $(panel+' .nonexisting-access');
        let data = {};
        data['uid'] = uid;
        data['update'] = [];
        data['create'] = [];
        accesses.each(function() {
            let id = $(this).attr('data-id');
            data['update'].push({
                id: id,
                'read': $(this).find('input[name=read]').is(':checked') ? 1 : 0,
                'create': $(this).find('input[name=create]').is(':checked') ? 1 : 0,
                'update': $(this).find('input[name=update]').is(':checked') ? 1 : 0,
                'delete': $(this).find('input[name=delete]').is(':checked') ? 1 : 0,
            });
        });
        noaccess.each(function() {
            let r = $(this).find('input[name=read]').is(':checked') ? 1 : 0;
            let c= $(this).find('input[name=create]').is(':checked') ? 1 : 0;
            let u= $(this).find('input[name=update]').is(':checked') ? 1 : 0;
            let d= $(this).find('input[name=delete]').is(':checked') ? 1 : 0;
            if(r == 0 && c == 0 && u == 0 && d == 0){ return;}
            else{
                let id = $(this).attr('data-module-id');
                data['create'].push({
                    'module_id': id,
                    'read': r,
                    'create': c,
                    'update': u,
                    'delete': d,
                })
            }
        });
        if(data['create'].length > 0){
            if(!confirm('Are you sure you want to give access to this user?')){
                fireToast('warning',"Action cancelled");
                return false;
            }
        }
        data = JSON.stringify(data);
        $.ajax({
            type:'POST',
            data: {'data': data},
            url: baseURL+"ma-save",
            dataType: 'json',
            success:function(res){
                if(res.success){
                    fireToast(res.success,res.message);
                    
                }
            }
        })
    })
    .on('change','.access-check', function(){
        if(!$(this).is('input[name=read]')){
            if($(this).is(':checked')){
                $(this).closest('tr').find('input[name=read]').attr('checked',true).prop('checked',true)
            }
        }
    })
</script>