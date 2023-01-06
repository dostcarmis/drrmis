<div id="addsitrepModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 href="#" data-toggle="tooltip" class="modal-title">Upload new Sitrep file</h4>
        </div>   
        <form id="savesitrepfile" method="post" action="{{action('SitrepController@savesitrepfile')}}" enctype="multipart/form-data">   
        
          <div class="modal-body">
            <div class="form-group">
              <label>Select risk:</label><br>
              <input type="checkbox" id="risk_type1" name="risk_check" value="Typhoon"> <label for="risk_type1">Typhoon</label><br>
              <div id="typhoon_hidden" style="display: none" class="ms-3 w-50">
                <input type="text" name="typhoon_name" class="form-control" id="typhoon_name" placeholder="Typhoon name" disabled>
              </div>
              <input type="checkbox" id="risk_type2" name="risk_check" value="Earthquake"> <label for="risk_type2">Earthquake</label><br>
              <div id="earthquake_hidden" style="display: none" class="ms-3 w-50">
                <input type="number" step="0.1" max="11" min="0.1" name="magnitude" class="form-control" id="magnitude" placeholder="Magnitude" disabled>
              </div>
              <input type="checkbox" id="risk_type3" name="risk_check" value="Volcanic Eruption"> <label for="risk_type3">Volcanic Eruption</label><br>
              <input type="checkbox" id="risk_type4" name="risk_check" value="Disease Outbreak"> <label for="risk_type4">Disease Outbreak</label><br> 
              <input type="checkbox" id="risk_type5" name="risk_check" value="Drought"> <label for="risk_type5">Drought</label><br>
              <input type="checkbox" id="risk_type6" name="risk_check" value="Fire"> <label for="risk_type6">Fire</label><br>
              <input type="checkbox" id="risk_type7" name="risk_check" value="Vehicular"> <label for="risk_type7">Vehicular</label><br>
              <input type="checkbox" id="risk_type8" name="risk_check" value="Other"> <label for="risk_type8">Other</label><br>
              <div id="other_hidden" style="display: none" class="ms-3 w-50">
                <input type="text" name="other_risk" class="form-control" id="other_risk" placeholder="Risk Type" disabled>
              </div>
            </div>
            <input type="hidden" name="risk" id="risk_">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
              <div class="form-group">
                <label for="text">File Name to Display:</label>
                <input type="text" name="filename" class="form-control" id="filename" required>
              </div>
              <div class="form-group">
                <label for="pwd"><i class="fa fa-folder-open" aria-hidden="true"></i> File:</label>
                <input type="file" name="sitreptoupload" id="sitreptoupload" required accept=".pdf,.docx,.jpg,.doc,.png">
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

