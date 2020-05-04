<div id="addsitrepModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 href="#" data-toggle="tooltip" class="modal-title">Upload new Sitrep file</h4>
        </div>   
        <form id="savesitrepfile" method="post" action="{{action('SitrepController@savesitrepfile')}}" enctype="multipart/form-data">   
        
          <div class="modal-body">
            <div class="row">
              <div class="column">
                <div class="form-group">
                  <label for="radio">Select risk:</label>
                  <div class="row">
                  <input type="radio" id="risk_type" name="risk" value="Typhoon"> Typhoon<br>
                  <input type="radio" id="risk_type" name="risk"  value="Earthquake"> Earthquake<br>
                  <input type="radio" id="risk_type" name="risk"  value="Volcanic Eruption"> Volcanic Eruption<br>
                  <input type="radio" id="risk_type" name="risk"  value="Disease Outbreak"> Disease Outbreak<br> 
                  <input type="radio" id="risk_type" name="risk"  value="Drought"> Drought<br>    
                  </div>
                </div>
              </div>

              <div class="column">
                  <label for="text">Typhoon Name:</label>
                  <input type="text" name="typhoon_name" class="form-control" id="typhoon_name" disabled>
                </div>
              </div>
              
            <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
              <div class="form-group">
                <label for="text">File Name to Display:</label>
                <input type="text" name="filename" class="form-control" id="filename" required>
              </div>
              <div class="form-group">
                <label for="pwd"><i class="fa fa-folder-open" aria-hidden="true"></i> File:</label>
                <input type="file" name="sitreptoupload" id="sitreptoupload" required>
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

