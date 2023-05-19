<div id="mymodal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirmation</h4>
      </div>
      
      <div class="modal-body">
        <p>Are you sure you want to update 
{{ $users->first_name }} {{ $users->last_name }}
          ? Password will be reset.
         </p>
      </div>
   
      
      <div class="modal-footer">
        <input class="btn btn-primary" type="submit" value="Update" />
        <button  class="btn btn-secondary" type="button"  data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


