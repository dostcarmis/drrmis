@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Edit Group</h1>
	</div>
</div>

@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach

<form id="editform" action="{{ action('UserController@updateGroup') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">	
	<input type="hidden" name="id" value="<?= $group->id ?>">	
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Group Name</label>
        <input type="text" name="group_name" id="group_name" class="form-control" 
               placeholder="Group Name" value="{{ $group->group_name }}">
		@if ($errors->has('group_name')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>SMS API Key</label>
        <input type="text" name="sms_api_key" id="sms_api_key" class="form-control" 
               placeholder="SMS API Key" value="{{ $group->sms_api_key }}">
		@if ($errors->has('sms_api_key')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 perinputwrap">
		<label>Description</label>
		<textarea name="description" id="description" class="form-control" 
				  rows="2" placeholder="Description">{{ $group->description }}</textarea>
		@if ($errors->has('description')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Created By</label>
        <input type="text" class="form-control" value="{{ $group->created_by }}" readonly>
	</div>
	
	<div class="col-xs-12 perinputwrap text-right">
        <a class ="btn btn-update" title="Update" data-toggle="modal" data-target="#mymodal">
            Update Group
        </a>
        <a class="btn btn-cancel" href="{{ action("UserController@viewGroups") }}">
            Cancel
        </a> 
        @include('pages.editgroupdialog')
	</div>
	
</form>
@stop