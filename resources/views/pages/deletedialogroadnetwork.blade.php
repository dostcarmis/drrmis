<?php
$snsid='';
$title='';
$oid='';
   if((isset($_GET['snsid'])) || (isset($_GET['title'])) || (isset($_GET['oid']))){
      $snsid = intval($_GET['snsid']);
      $title = $_GET['title']; 
      $oid = $_GET['oid'];
      ?>
       @section('page-js-files')
       <script type="text/javascript">
          $(document).ready(function(){
             $('#mymodal').modal('show');
          });
      </script>
       @stop
<?php }
?>
<div id="mymodal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirmation</h4>
      </div>
      
      <div class="modal-body">
        <p>Are you sure you want to {{ $title }} 
          @foreach($roadnetworks as $roadnetwork)
            @if($snsid === $roadnetwork->id)
            {{ $roadnetwork->location }}
            @endif
          @endforeach
          from the list?
         </p>
      </div>
   
      
      <div class="modal-footer">
        <a type="button" href="<?php echo url('destroyroadnetwork'); ?>/<?php echo $oid?>" class="btn btn-confirms">Delete</a>
        <a type="button"  class="btn btn-default" data-dismiss="modal">Cancel</a>
      </div>
    </div>
  </div>
</div>
