<div id="addsitrepModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 href="#" data-toggle="tooltip" class="modal-title">Upload new Sitrep file</h4>
        </div>   
        <form id="saveFile" method="post" action="{{action('FileDownloadController@saveFile')}}" enctype="multipart/form-data">   
        
          <div class="modal-body">
            <div class="row">
              <div class="column">
                <div class="form-group">
                  <label for="radio">Select risk:</label>
                  <div class="row">
                  <input type="radio" name="hazard" value="Typhoon"> Typhoon<br>
                  <input type="radio" name="hazard" value="Earthquake"> Earthquake<br>
                  <input type="radio" name="hazard" value="male"> Volcanic Eruption<br>
                  <input type="radio" name="hazard" value="male"> Disease Outbreak<br> 
                  <input type="radio" name="hazard" value="male"> Drought<br>    
                  </div>
                </div>
              </div>

              <div class="column">
                  <label for="text">Typhoon Name:</label>
                  <input type="text" name="tyname" class="form-control" id="tyname_id" disabled>
                </div>
              </div>
              
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

