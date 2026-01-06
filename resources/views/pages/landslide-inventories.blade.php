@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Landslide Inventories</h1>
	</div>

	{{-- <form action="{{ action('LandslideController@destroymultipleLandslides') }}"> --}}
    <form action="#">
		<div class="col-xs-12">
			<p style="color:green"><?php echo Session::get('message'); ?></p>
			<div class="col-xs-12 ulpaginations np">
				{{-- <div class="col-xs-12 col-sm-8 np">
					<button disabled="disabled" type="submit" class="btn btn-deleteselected" title="Delete">
						<i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                    </button>
				</div> --}}

				<div class="col-xs-12 col-sm-4">
				<div class="col-xs-12 np text-right">
					<div class="input-group">				  
						  <input class="form-control" id="searchall" type="text" name="searchall" placeholder="Search">
						  <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
						</div>
		    	</div>
			</div>
			</div>

			<table class="table table-hover table-striped tblcontents tbl-landslides"  id="dashboardtables">
				<thead>
					<th class="no-sort"><input type="checkbox" class="headcheckbox"></th>
					<th class="desc">Location</th>	
					<th>Source</th>
					<th>Date</th>
				</thead>
				<tbody>
				@foreach($landslides as $landslide)
					<tr>						
						<td>
                            @if((Auth::user()->id == $landslide->created_by) || (Auth::user()->role_id <= 3))
                                <input class="chbox" name="chks[]" value="{{$landslide->id}}"  type="checkbox">
                            @else
                                <input  type="checkbox" disabled>
                            @endif

                            </td><td>

                            @if((Auth::user()->id == $landslide->created_by) || (Auth::user()->role_id <= 3))
                                <a class="desctitle" href="{{ route('landslide-inventories.show', $landslide->id) }}">
                                    {{ $landslide->location }}
                                </a>
                            @else
                                <a class="desctitle" href="{{ route('landslide-inventories.show', $landslide->id) }}">
                                    {{ $landslide->location }}
                                </a>
                            @endif						
                            |
                            @if (!empty($landslide->landslideInventoryValidation))
                                @if ($landslide->landslideInventoryValidation->id === 1)
                                    <span class="repstat text-success">{{ $landslide->landslideInventoryValidation->name }}</span>
                                @elseif ($landslide->landslideInventoryValidation->id === 2)
                                    <span class="repstat text-danger">{{ $landslide->landslideInventoryValidation->name }}</span>
                                @else
                                    <span class="repstat text-warning">{{ $landslide->landslideInventoryValidation->name }}</span>
                                @endif
                            @else
                                <span class="text-warning">Not yet validated</span>
                            @endif

                            <span class="defsp spactions">
                                <div class="inneractions">
                                    <a href="{{ route('landslide-inventories.edit', $landslide->id) }}">Edit</a> | 
                                    {{-- <a class="deletepost" href="#" id="{{$landslide->id}}" value="{{$landslide->id}}" title="Delete">Delete</a> | --}}
                                    <a href="{{ route('landslide-inventories.show', $landslide->id) }}">Preview</a> 
                                </div>								
                            </span>
						</td>						
						<td>{{ $landslide->created_by }}</td>
						<td>
						    <?php echo date("F j, Y g:i A", strtotime($landslide->date));?>
						</td>		
                    </tr>
					@endforeach
					@include('pages.deletedialoglandslide')
				</tbody>
			</table>
		</div>
	</form>
</div>

@stop