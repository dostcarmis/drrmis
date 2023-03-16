<div class="panel panel-info">
    <div class="panel-heading">
        List of Users with Access to {{$module->name}} | ID: {{$module->id}}
    </div>
    @if(count($user) > 0)
    <table class="table table-striped" style="font-size: 14px">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Role</th>
                <th>Role ID</th>
                <th>Access Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user as $u)
                <tr>
                    <td>{{$u->user->id}}</td>
                    <td>{{$u->user->first_name." ".$u->user->last_name}}</td>
                    <td>{{$u->user->username}}</td>
                    <td>{{$u->user->role->name}}</td>
                    <td>{{$u->user->role_id}}</td>
                    <td>{{$u->special == 1 ? "Special": "Default"}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="panel-body">
        No users have access to this module.
    </div>
    @endif
</div>