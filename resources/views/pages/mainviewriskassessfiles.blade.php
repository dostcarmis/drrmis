<div id="selectProvmodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 href="#" data-toggle="tooltip"  title="Note: You can only upload and delete files in your own province. You can download files from other provinces." class="modal-title">Select Province <i class="fa fa-info-circle" text-align="right" aria-hidden="true"></i></h4>
        </div>
                    
        <div class="modal-body">
          <div class="dropdown">
             <button class="btn btn-primary btn-block dropdown-toggle" type="button" id="menu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Click here<span class="caret"></span>
                </button>
                    <div class="dropdown-menu" aria-labelledby="menu1">
                      <li>
                      <a class="dropdown-item" href="{{ url("riskassessmentfiles/abra") }}">Abra</a>
                      <a class="dropdown-item" href="{{ url("riskassessmentfiles/apayao") }}">Apayao</a>
                      <a class="dropdown-item" href="{{ url("riskassessmentfiles/benguet") }}">Benguet</a>
                      <a class="dropdown-item" href="{{ url("riskassessmentfiles/ifugao") }}">Ifugao</a>
                      <a class="dropdown-item" href="{{ url("riskassessmentfiles/kalinga") }}">Kalinga</a>
                      <a class="dropdown-item" href="{{ url("riskassessmentfiles/mountain") }}">Mt. Province</a>
                      </li>
                    </div>
              </div>
        </div> 
        <!--<div class="modal-footer">
          <a type="button" class="btn btn-danger" data-dismiss="modal">Cancel</a>-->        
        </div>
        </form>
      </div>
    </div>
  </div>


