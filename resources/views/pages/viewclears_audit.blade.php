@foreach ($res as $r)
    <tr>
        <td>{{$r->user->first_name." ".$r->user->last_name}}</td>
        <td style="text-align: center">{{$r->clears_id}}</td>
        <td style="text-align: center">{{$r->request}}</td>
        <td>{{$r->remarks}}</td>
        <td style="text-align: center">{{$r->source}}</td>
        <td style="text-align: center">{{$r->created_at}}</td>
    </tr>
@endforeach