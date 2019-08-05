<div id="mymodal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirmation</h4>
      </div>      
      <div class="modal-body">
        <p>Are you sure you want to update 
          {{ $typhoontracks->typhoonName }}  ?
         </p>
      </div>       
      <div class="modal-footer">
        <input class ="btn btn-confirms"  type ="submit" value="Update">
        <a type="button"  class="btn btn-default" data-dismiss="modal">Cancel</a>
      </div>
    </div>
  </div>
</div>
