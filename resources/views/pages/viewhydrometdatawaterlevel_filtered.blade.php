
@foreach($waterData['data'] as $waterValue)
<tr>
<td class="hidden"><span data-value="{{$waterValue['id']}}">{{$waterValue['id']}}</span></td>
<td><span class="stat {{$waterValue['status']}}">{{$waterValue['status']}}</span></td>
<td>{{$waterValue['address']}}</td>
<td>{{$waterValue['sensortype']}}</td>
<td>{{$waterValue['current']}}</td>
<td>{{$waterValue['normal_val']}}</td>
<td>{{$waterValue['level1_val']}}</td>
<td>{{$waterValue['level2_val']}}</td>
<td>{{$waterValue['critical_val']}}</td>
<td>{{$waterValue['remarks']}}</td>
</tr>
@endforeach