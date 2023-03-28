<table id="clears-table" class="table tbldashboard table-hover">
    <thead>
        <tr>
            <th class="text-center">Survey Date</th>
            <th class="text-center">Barangay</th>
            <th class="text-center">Municipality</th>
            <th class="text-center">Province</th>
            <th class="text-center">Uploaded by</th>
            <th class="text-center" data-toggle="tooltip" title="Slope Material">sR</th>
            <th class="text-center" data-toggle="tooltip" title="Vegetation">vF</th>
            <th class="text-center" data-toggle="tooltip" title="Frequency of slope failure">fF</th>
            <th class="text-center" data-toggle="tooltip" title="Presence of springs">sRed</th>
            <th class="text-center" data-toggle="tooltip" title="Condition of drainage/canal/culvert within the site/slope">dRed</th>
            <th class="text-center" data-toggle="tooltip" title="Amount of rainfall (mm) in 24 hours">Rain</th>
            <th class="text-center" data-toggle="tooltip" title="Land use">lF</th>
            <th class="text-center" data-toggle="tooltip" title="Slope rating">&alpha;Rating</th>
            <th class="text-center" data-toggle="tooltip" title="Factor of stability">Fs</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($res as $r)
            <tr long = "{{$r->survey_longitude}}" lat = "{{$r->survey_latitude}}" report-id="{{$r->id}}" upload-date = "<?php echo date('Y-m-d',strtotime($r->created_at)); ?>" image="{{$r->image}}">
                <td class="c-date-slot"><span class="c-date">{{date('Y-m-d',strtotime($r->survey_date))}}</span><br>
                    <span class="defsp spactions">
                        <div class="inneractions">
                            <a href="#" class="clears-v-btn" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a> | 
                            @if(Auth::user()->id == $r->user_id)
                            <a href="#" {{-- class="clears-e-btn" --}} title="Edit" data-toggle="modal" data-target="#clears-edit-modal"><i class="fa fa-pencil clears-e-btn" aria-hidden="true"></i></a> | 
                            <a class="deletepost clears-d-btn" href="#" data-toggle="modal" data-target="#clears-delete-modal" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            @endif
                            | 
                            <a href="#report-view-div" class="c-report" title="Report"><i class="fa fa-file-o" aria-hidden="true"></i></a>
                        </div>								
                    </span>
                </td>
                <td class="c-b-id" b_id="{{$r->barangay_id != null && $r->barangay_id != '' ? $r->barangay_id : 'empty'}}">{{$r->municipality->barangay($r->barangay_id) ? $r->municipality->barangay($r->barangay_id)->name : ''}}</td>
                <td class="c-m-id" m_id="{{$r->municipality_id}}">{{$r->municipality->name}}</td>
                <td class="c-p-id">{{$r->province->name == "Mountain Province" ? "Mt. Province":$r->province->name }}</td>
                <td>{{$r->user->first_name." ".$r->user->last_name}}</td>
                <td class="text-center c-material" data-toggle="tooltip" mid = "{{$r->material_id}}" title="{{$r->slopeMaterial($r->material_id)}}">{{$r->sRating}}</td>
                <td class="text-center c-vegetation" data-toggle="tooltip" title="{{$r->vegetation($r->vFactor)}}">{{$r->vFactor}}</td>
                <td class="text-center c-freq" data-toggle="tooltip" title="{{$r->frequency($r->frequency_id)}}" fid = {{$r->frequency_id}}>{{$r->fFactor}}</td>
                <td class="text-center c-spring" data-toggle="tooltip" title="{{$r->springs($r->sRed)}}">{{$r->sRed}}</td>
                <td class="text-center c-canal" did="{{$r->drain_id}}" data-toggle="tooltip" title="{{$r->canals($r->dRed)}}">{{$r->dRed}}</td>
                <td class="text-center c-rain" data-toggle="tooltip" title="{{$r->rain($r->rain)}}">{{$r->rain}}</td>
                <td class="text-center c-land" data-toggle="tooltip" lid="{{$r->land_id}}" title="{{$r->land($r->land_id)}}">{{$r->lFactor}}</td>
                <td class="text-center c-slope" data-toggle="tooltip" title="{{$r->slopeAngle($r->alphaRating)}}" >{{$r->alphaRating}}</td>
                <td class="text-center c-stability strong {{
                    ($r->Fs >= 1.2) ? "text-success" : 
                    (
                        ($r->Fs < 1.2 && $r->Fs >= 1) || ($r->Fs < 1 && $r->Fs >= 0.7) ? "text-warning" : 
                        (
                            ($r->Fs < 0.7) ? "text-danger" : ""
                        )
                    )}}" data-toggle="tooltip" title="{{$r->stability($r->Fs)}}">{{$r->Fs}}</td>
            </tr>                        
        @endforeach
    </tbody>
</table>