  <div class="wrap accord">
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">	
       <!--Search Tab-->
     
       <div class="panel panel-default lookupinci active">
        <div class="panel-heading" role="tab" id="Search">
          <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#search" aria-expanded="false" aria-controls="Search">Search <i class="fa fa-caret-square-o-down" aria-hidden="true"> </i>
            </a>
          </h4>
        </div>
       </div>
      
        <!--    LANDSLIDE   -->
      <div class="panel panel-default pnl-landslides active">
        <div class="panel-heading" role="tab" id="Landslides">
          <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#landslides" aria-expanded="false" aria-controls="Landslides">
              Landslides <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
            </a>
          </h4>
        </div>
        <div id="landslides" class="panel-collapse collapse" role="tabpanel" aria-labelledby="Landslides">
          <div class="panel-body">
          <?php if(empty($landslides)) { ?>
            <span class="defsp">No Landslide reports.</span>
          <?php } else { 
            $landslidecount = 2;
            ?>
             @foreach($landslides as $landslide)
               <?php $landslidecount++; ?>
          <div class="col-xs-12 col-sm-12 col-sm-12 per-monitoring-home">
            <div class="col-xs-12 np monitoring-inner-wrap">
  
              <div class="col-xs-12 roadnetworks-title-home">
                <span class="defsp r-sptimeanddate">Date: <span><?php echo date("F j Y g:i A", strtotime($landslide->date));?></span></span>
              </div>
  
              <div class="col-xs-12 r-monitoringwrap-details">
                <span class="defsp r-splocation">{{ $landslide->location }}</span>					
              </div>
  
              <div class="col-xs-12 r-per-monitoring-blw">
                <span>Source: <span>{{ $landslide->author }}</span></span> | <span>Uploaded by: 
  
                @foreach($users as $user)
  
                  @if($landslide->user_id == $user->id)
                    {{$user->last_name}}
                  @endif
  
                @endforeach
                </span>
              </div>
  
              <div class="col-xs-12 r-links">
                <a href="#l-viewmap" class="l-viewmap" id="{{ $landslide->id }}">View on Map</a> | <a href="<?php echo url('incident'); ?>/<?php echo $landslide->slug?>">Read More</a>
              </div>
  
            </div>
          </div>
  
        <?php if($landslidecount >= 5){break;}?>
        
        @endforeach
  
        <?php if (Auth::check()) : ?>
          <!--<input type='text' id='date-range-input' class='form-control'>-->
          <div class="col-xs-12 r-links">
            <a href="#" id="l-viewmap" class="btn btn-default btn-block" onclick="$(this).toggleIconsL();">View all Landslides</a> 
          </div>
          <div class="col-xs-12 r-links">
              <a href="#" id="all-viewmap" class="btn btn-default btn-block" onclick="$(this).toggleIconsAll();">View all incidents </a> 
          </div>
          <div class="col-xs-12 np r-moreroadlink">
            <a href="{{ action("LandslideController@viewmultipleLandslides") }}" class="btn btn-primary">More Landslides</a>
          </div>   
  
        <?php endif;?>
  
          <?php } ?>
  
          </div>
        </div>
      </div>
  
  
  
      <div class="panel panel-default pnl-floods">
        <div class="panel-heading" role="tab" id="Floods">
          <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#floods" aria-expanded="false" aria-controls="Floods">
              Floods <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
            </a>
          </h4>
        </div>
        <div id="floods" class="panel-collapse collapse" role="tabpanel" aria-labelledby="Floods">
          <div class="panel-body">
  
            <?php if(empty($floods)) { ?>
  
            <span class="defsp">No Flood reports.</span>
  
            <?php } else { 
              $floodcount = 2;
  
            ?>
  
            @foreach($floods as $flood)
          <?php $floodcount++; ?>
          <div class="col-xs-12 col-sm-12 col-sm-12 per-monitoring-home">
            <div class="col-xs-12 np monitoring-inner-wrap">
              <div class="col-xs-12 roadnetworks-title-home">
                <span class="defsp r-sptimeanddate">Date: <span><?php echo date("F j Y g:i A", strtotime($flood->date));?></span></span>
              </div>
              <div class="col-xs-12 r-monitoringwrap-details">
                <span class="defsp r-splocation">{{ $flood->location }}</span>
          
              </div>
              <div class="col-xs-12 r-per-monitoring-blw">
                <span>Source: <span>{{ $flood->author }}</span></span> | <span>Uploaded by: 
                @foreach($users as $user)
  
                  @if($flood->user_id == $user->id)
                      {{$user->last_name}}
                  @endif
                @endforeach
                </span>
              </div>
  
              <div class="col-xs-12 r-links">
                <a href="#" id="{{$flood->id}}" class="f-viewmap" >View on Map</a> | <a href="<?php echo url('incident'); ?>/<?php echo $flood->slug?>">Read More</a>
              </div>
  
            </div>
          </div>
        <?php if($floodcount >= 5){break;}?>
        @endforeach
  
        <?php if (Auth::check()) { ?>
          
          <div class="col-xs-12 r-links">
              <a href="#" id="f-viewmap" class="btn btn-default btn-block" onclick="$(this).toggleIconsF();">View all Floods</a> 
            </div>
            <div class="col-xs-12 r-links">
                <a href="#all-viewmap" id="all-viewmap" class="btn btn-default btn-block" onclick="$(this).toggleIconsAll();">View all incidents </a> 
            </div>
          <div class="col-xs-12 np r-moreroadlink">
            <a href="{{ action("FloodController@viewmultipleFloods") }}" class="btn btn-primary">More Floods</a>
          </div>   
  
        <?php } ?>
  
        <?php } ?>
          </div>
        </div>
      </div>
    </div>
    </div><!--end accord-->

  
  <!--<nav id="navleftside" class="navbar navbar-inverse sidebar hidden-xs" role="navigation">
  <div class="nav-side-menu">
    <ul id="menu-content" class="menu-content collapse out">               
      </ul>
        <font color="white">Date:
          <script> document.write(new Date().toLocaleDateString()); </script>
        </font> -->
  
                          
  
             
   <!-- </nav>
  <button class="btn hidden-xs btnleftmenu"><i class="fa fa-bars fa-2x toggle-btn"></i></button>-->
  
  <!--<input type='text' id='date-range-input' class='form-control'>-->
  