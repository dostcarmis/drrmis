@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Groups</h1>
	</div>

	<form action="{{ action("UserController@deleteMultipleGroups") }}">
        <div class="col-xs-12">
            <p style="color:red"><?php echo Session::get('message'); ?></p>
            <div class="col-xs-12 ulpaginations np">
                <div class="col-xs-12 col-sm-8 np">
                    <a id="btnadd-location" title="Add Group" class="btnadd-location btn" 
                    href="{{ action("UserController@viewCreateGroup") }}">
                        <span class="glyphicon glyphicon-plus"></span> Add Group
                    </a>
                    <button disabled="disabled" type="submit" class="btn btn-deleteselected" title="Delete">
                        <i class="fa fa-trash-o" aria-hidden="true"></i> 
                        Delete
                    </button>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="col-xs-12 np text-right">
                        <div class="input-group">				  
                            <input class="form-control" id="searchall" type="text" name="searchall" placeholder="Search">
                            <span class="input-group-addon" id="basic-addon1">
                                <span class="glyphicon glyphicon-search"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-hover tblusers" id="dashboardtables">
                <thead>
                    <th class="no-sort"><input type="checkbox" class="headcheckbox"></th>
                    <th>Group Name</th>
                    <th>SMS API Key</th>		
                    <th>Description</th>	
                </thead>
                <tbody>					
                    @foreach($groups as $group)
                    <tr>
                        <td><input class="chbox" name="chks[]" value="{{$group->grp_id}}" type="checkbox"></td>
                        <td>
                            <a class="desctitle" href="{{ url('viewupdategroup/' . $group->grp_id) }}">
                                {{ $group->group_name }}
                            </a>
                            <span class="defsp spactions">
                                <div class="inneractions">
                                    <a href="{{ url('viewupdategroup/' . $group->grp_id) }}">Edit</a> | 
                                    <a class="deletepost" href="#" id="{{$group->grp_id}}" value="{{$group->grp_id}}" title="Delete">Delete</a>
                                </div>								
                            </span>
                        </td>
                        <td>{{ $group->sms_api_key }}</td>	
                        <td>{{ $group->description }}</td>	
                    </tr>
                    @endforeach	
                    @include('pages.deletedialoggroup')
                </tbody>
            </table>
        </div>
    </form>
</div>

@stop
