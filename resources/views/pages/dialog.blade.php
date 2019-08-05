<?php
$snsid='';
$title='';
   if((isset($_GET['snsid'])) || (isset($_GET['title']))){
      $snsid = intval($_GET['snsid']);
      $title = $_GET['title']; ?>
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
        <p>Are you sure you want to {{ $sensor->id }} 
          @foreach($sensors as $sensor)
            @if($snsid === $sensor->id)
            {{ $sensor->address }}
            @endif
          @endforeach
          from the list?
         </p>
      </div>
   
      
      <div class="modal-footer">
        <a type="button" href="<?php echo url('destroysensor'); ?>/<?php echo $snsid?>" class="btn btn-confirms">Delete</a>
        <a type="button"  class="btn btn-default" data-dismiss="modal">Cancel</a>
      </div>
    </div>
  </div>
</div>
