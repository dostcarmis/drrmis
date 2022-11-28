@foreach($rainData['data'] as $rainValue)
<tr>
<td class="hidden"><span data-value="{{$rainValue['id']}}">{{$rainValue['id']}}</span></td>
<td><span class="stat {{$rainValue['status']}}">{{$rainValue['status']}}</span></td>
<td>{{$rainValue['address']}}</td>
<td>{{$rainValue['sensortype']}}</td>
<td>{{$rainValue['current']}}</td>
<td>{{$rainValue['cumulative']}}</td>
<td>{{$rainValue['past2days']}}</td>
<td>{{$rainValue['remarks']}}</td>
</tr>
@endforeach