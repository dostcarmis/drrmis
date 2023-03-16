<div class="panel panel-info">
    <table class="table table-striped" style="font-size: 14px">
        <thead>
            <tr>
                <th>ID</th>
                <th>Module</th>
                <th>Remarks</th>
                <th style="text-align: center">Users with access</th>
                <th style="text-align: center">Default Roles with access</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['modules'] as $m)
                <tr>
                    <td>{{$m->id}}</td>
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

<div class="mt-3" id="m-user-list">
    
</div>