<div id="addfileModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 href="#" data-toggle="tooltip" class="modal-title">Upload new file</h4>
        </div>   
        <form id="saveFile" enctype="multipart/form-data">   
        <div class="modal-body">
  
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label for="text">File Name to Display:</label>
              <input type="text" name="filename" class="form-control" id="filename" required>
            </div>
            <span>File Category:</span>
            <div class="form-group">
              <select name="file-category" id="file-categ-select" class="form-control" required>
                @if (Auth::check() && Auth::user()->role_id <=2)
                  <option value="1">RDNA</option>
                @endif
                @if (Auth::check() && Auth::user()->role_id <=3)
                  <option value="2">PDNA</option>
                @endif
                <option value="3">Minutes of Meetings</option>
                <option value="4" selected>Other</option>
              </select>
            </div>
            <div class="form-group">
              <label for="pwd"><i class="fa fa-folder-open" aria-hidden="true"></i> File:</label>
              <input type="file" name="fileUploadName" id="fileUploadName" accept=".txt,.pdf,.docx,.pptx,.xlsx,.rar,.kml,.jpeg,.jpg" required>
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

  <script>
    $('#saveFile').off().on('submit',function(e){
      e.preventDefault();
      let form = document.getElementById('saveFile');
      let filename = $('#filename').val();
      let categ = $("#file-categ-select").val();
      let file = document.getElementById('fileUploadName').files[0];
      let data = new FormData(form);
      $.ajax({
        type: "POST",
        url: "{{route('km-savefiles')}}",
        data: data,
        processData: false,
        contentType: false,
        success: function(response){
          $('#addfileModal').modal('hide');
          $('.alert').hide();
          if(response.success){
            $('#alert-success').show();
            $('#alert-success .alert-content').text(response.message);
          }else{
            $('#alert-fail').show();
            $('#alert-fail .alert-content').text(response.message);
          }
        }
      })
    })
  </script>