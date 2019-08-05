<div id="addModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload new file</h4>
      </div>   
      <form id="saveRehab" method="post" action="{{action('PreparednessController@savePreparedness')}}" enctype="multipart/form-data">   
      <div class="modal-body">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    			  <div class="form-group">
    			    <label for="text">File Name to Display:</label>
    			    <input type="text" name="filename" class="form-control" id="filename">
    			  </div>
    			  <div class="form-group">
    			    <label for="pwd">File:</label>
    			    <input type="file" name="fileToUpload" id="fileToUpload">
    			  </div>		  			  				   
      </div>       
      <div class="modal-footer">
        <button type="submit" class="btn btn-default btn-submitmodal">Submit</button>
        <a type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>        
      </div>
      </form>
    </div>
  </div>
</div>
