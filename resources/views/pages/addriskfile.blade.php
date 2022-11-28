<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 href="#" >Upload new file </h4>
        </div>   
        <form id="saveRiskassess" method="post" action="{{action('RiskassessController@saveRiskassess')}}" enctype="multipart/form-data">   
          <div class="modal-body">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label for="text">File Name to Display:</label>
              <input type="text" name="filename" class="form-control" id="filename" required>
            </div>
            @if(Auth::user()->role_id <= 3)
            <div class="form-group">
              <label for="municipality_assessed">Assessed Municipality:</label>
              <select name="municipality" id="municipality_assessed" class="form-control" required>
                <option value="0">Select One</option>
                @foreach ($municipalities as $m)
                  <option value="{{$m->name}}">{{$m->name}}</option>
                @endforeach
              </select>
            </div>
            @endif
            <div class="form-group">
              <label for="assessment_date">Date of Assessment:</label>
              <input class="form-control" type="date" name="date" id="assessment_date" required>
            </div>		  
            <div class="form-group">
              <label for="fileUploadName"> File: <i class="fa fa-info-circle" text-align="right" aria-hidden="true" data-toggle="tooltip"  title="Note: You can only upload PDF files here." class="modal-title"></i></label>
              <input type="file" name="fileUploadName" id="fileUploadName" required accept=".pdf">
            </div>		  			  	
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-default btn-submitmodal">Upload</button>
            <a type="button" class="btn btn-danger" data-dismiss="modal">Cancel</a>        
          </div>
        </form>
      </div>
    </div>
  </div>