<div id="addfileModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 href="#" data-toggle="tooltip" class="modal-title">Upload new file</h4>
        </div>   
        <form id="saveFile" method="post" action="{{action('FileDownloadController@saveFile')}}" enctype="multipart/form-data">   
        <div class="modal-body">
  
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                      <label for="text">File Name to Display:</label>
                      <input type="text" name="filename" class="form-control" id="filename" required>
                    </div>
                    <div class="form-group">
                      <label for="pwd"><i class="fa fa-folder-open" aria-hidden="true"></i> File:</label>
                      <input type="file" name="fileUploadName" id="fileUploadName" required>
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