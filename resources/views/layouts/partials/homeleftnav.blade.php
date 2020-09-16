<nav id="navleftside" class="navbar navbar-inverse sidebar closednavbar" role="navigation">
<span class="defsp sptitleleftmenu">Maps</span>
<div class="nav-side-menu">
  <div class="menu-list">
    <ul id="menu-content" class="menu-content collapse out">   
      <!--SENSORS-->            
      <li class="collapsed prntli">
        <a  data-toggle="collapse" data-target="#sensorsnmb"  href="#" class="homepagetoogle sensortoggle" ><i class="fa-1x demo-icon"></i> Sensors <span class="arrow"></span></a>
        <ul class="sub-menu collapse ulsensorstop"  id="sensorsnmb">
          <li><a href="#" data-value="1" class="onclicksensor"><span>Rain Gauges</span></a></li>
          <li><a href="#" data-value="2" class="onclicksensor"><span>Stream Gauges</span></a></li>
          <li><a href="#" data-value="3" class="onclicksensor"><span>Rain and Stream Gauges</span></a></li>
          <li><a href="#" data-value="4" class="onclicksensor"><span>Weather Stations</span></a></li>
        </ul>
      </li>  
      <!--INCIDENTS-->
      <li class="collapsed prntli">
        <a  data-toggle="collapse" data-target="#incidentstoggle"  href="#" class="homepagetoogle sensortoggle" ><i class="fa fa-bullhorn"></i> Incidents <span class="arrow"></span></a>
        <ul class="sub-menu collapse ulsensorstop"  id="incidentstoggle">
            <li><a href="#" id="l-viewmap" onclick="$(this).toggleIconsL();">View all Landslides</a></li>
            <li><a href="#" id="f-viewmap" onclick="$(this).toggleIconsF();">View all Floods</a></li>
            <li><a href="#" id="all-viewmap" onclick="$(this).toggleIconsAll();">View all incidents</a></li>
            <li><a href="#" id="calTggle" hidden>Date Picker</a></li>
        </ul>


      <li  class="collapsed prntli">
       <a data-toggle="collapse" data-target="#hazardsnmb" class="homepagetoogle"  href="#"><i class="fa fa-1x fa-map" aria-hidden="true"></i>  Hazard Maps <span class="arrow"></span></a>
        <ul class="sub-menu ulsensorstop collapse" id="hazardsnmb"> 
          <li class="titleli"><a data-toggle="collapse" data-target=".mgb" href="#">MGB</a>
            <ul class="sub-menu-bottom collapse mgb" id="mgb">
              @foreach($provinces as $province)
              <li class="foldername-prov"><a data-toggle="collapse" data-target=".mgb-{{$province->name}}">{{$province->name}}</a>
                <ul class="sub-menu-bottom collapse mgb-{{$province->name}}" id="mgb-{{$province->name}}">
                    @foreach($hazardmaps as $hazardmap)
                      @if(($hazardmap->province_id == $province->id) && ($hazardmap->category_id == 1))          
                          @if($hazardmap->overlaytype == 'kmlfile')
                            <li><a href="#" data-value="{{ $hazardmap->hazardmap }}" class="kmlclick" id="{{$hazardmap->name}}-{{$hazardmap->id}}">{{$hazardmap->name}}</a></li>
                          @else
                            <li><a href="#" data-value="{{ $hazardmap->hazardmap }}" data-coords="{{ $hazardmap->north }},{{ $hazardmap->east }},{{ $hazardmap->south }},{{ $hazardmap->west }}" class="onclicktiff" id="{{$hazardmap->name}}-{{$hazardmap->id}}">{{$hazardmap->name}}</a></li>
                          @endif

                      @endif
                    @endforeach
                </ul> 
              </li>
                             
              @endforeach
            </ul>
          </li>   
            
          <li class="titleli">
          <a data-toggle="collapse" data-target=".noah" href="#">NOAH</a>
            <ul class="sub-menu-bottom collapse noah" id="noah">
             @foreach($provinces as $province)
                <li class="foldername-prov"><a data-toggle="collapse" data-target=".noah-{{$province->id}}">{{$province->name}}</a>
                <ul class="sub-menu-bottom collapse noah-{{$province->id}}" id="noah-{{$province->name}}">
                    @foreach($hazardmaps as $hazardmap)
                      @if(($hazardmap->province_id == $province->id) && ($hazardmap->category_id == 2))
                         
                        @if($hazardmap->overlaytype == 'kmlfile')
                            <li><a href="#" data-value="{{ $hazardmap->hazardmap }}" class="kmlclick" id="{{$hazardmap->name}}-{{$hazardmap->id}}">{{$hazardmap->name}}</a></li>
                          @else
                            <li><a href="#" data-value="{{ $hazardmap->hazardmap }}" data-coords="{{ $hazardmap->north }},{{ $hazardmap->east }},{{ $hazardmap->south }},{{ $hazardmap->west }}" class="onclicktiff" id="{{$hazardmap->name}}-{{$hazardmap->id}}">{{$hazardmap->name}}</a></li>
                          @endif
                      @endif
                    @endforeach
                    
                  </ul>  
                </li>            
              @endforeach
            </ul>
          </li>

          <li class="externallink">
            <a href="http://bagong.pagasa.dost.gov.ph/tropical-cyclone/tropical-cyclone-advisory" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> PHIVOLCS</a>
          </li>

          <!--<li class="titleli">
            <a data-toggle="collapse" data-target=".phivolcs" href="#">Phivolcs</a>
              <ul class="sub-menu-bottom collapse phivolcs" id="phivolcs">
               @foreach($provinces as $province)
                  <li class="foldername-prov"><a data-toggle="collapse" data-target=".phivolcs-{{$province->name}}">{{$province->name}}</a>
                  <ul class="sub-menu-bottom collapse phivolcs-{{$province->name}}" id="phivolcs-{{$province->name}}">
                      @foreach($hazardmaps as $hazardmap)
                        @if(($hazardmap->province_id == $province->id) && ($hazardmap->category_id == 3))

                          @if($hazardmap->overlaytype == 'kmlfile')
                            <li><a href="#" data-value="{{ $hazardmap->hazardmap }}" class="kmlclick" id="{{$hazardmap->name}}-{{$hazardmap->id}}">{{$hazardmap->name}}</a></li>
                          @else
                            <li><a href="#" data-value="{{ $hazardmap->hazardmap }}" data-coords="{{ $hazardmap->north }},{{ $hazardmap->east }},{{ $hazardmap->south }},{{ $hazardmap->west }}" class="onclicktiff" id="{{$hazardmap->name}}-{{$hazardmap->id}}">{{$hazardmap->name}}</a></li>
                          @endif

                        @endif
                      @endforeach
                  </ul> 
                  </li>             
                @endforeach
              </ul>
            </li>

            <li class="titleli">
            <a data-toggle="collapse" data-target=".dream" href="#">DREAM / LiPAD</a>
              <ul class="sub-menu-bottom collapse dream" id="dream">
               @foreach($provinces as $province)
                  <li class="foldername-prov"><a data-toggle="collapse" data-target=".dream-{{$province->name}}">{{$province->name}}</a>
                  <ul class="sub-menu-bottom collapse dream-{{$province->name}}" id="dream-{{$province->name}}">
                      @foreach($hazardmaps as $hazardmap)
                        @if(($hazardmap->province_id == $province->id) && ($hazardmap->category_id == 4))

                             @if($hazardmap->overlaytype == 'kmlfile')
                            <li><a href="#" data-value="{{ $hazardmap->hazardmap }}" class="kmlclick" id="{{$hazardmap->name}}-{{$hazardmap->id}}">{{$hazardmap->name}}</a></li>
                          @else
                            <li><a href="#" data-value="{{ $hazardmap->hazardmap }}" data-coords="{{ $hazardmap->north }},{{ $hazardmap->east }},{{ $hazardmap->south }},{{ $hazardmap->west }}" class="onclicktiff" id="{{$hazardmap->name}}-{{$hazardmap->id}}">{{$hazardmap->name}}</a></li>
                          @endif

                        @endif
                      @endforeach
                  </ul>  
                  </li>            
                @endforeach
              </ul>
            </li>-->
           

             
        </ul>
      </li>
        
        <li  class="collapsed prntli">
          <a data-toggle="collapse"  class="homepagetoogle" data-target=".contours" href="#"><i class="fa fa-1x fa-map" aria-hidden="true"></i>  Contours<span class="arrow"></span></a>
          <ul class="sub-menu collapse ulsensorstop contours"  id="contours">

            <?php 
            $path = 'http://drrmis.dostcar.ph/public/';
            $Fldrpth = 'contour/';           
            $files = glob($Fldrpth."*.kml");            

              ?>
            <li><a href="#" data-value="<?php echo $path.$files[0];?>" class="contourclick"><span>Abra</span></a></li>
            <li><a href="#" data-value="<?php echo $path.$files[1];?>" class="contourclick"><span>Apayao</span></a></li>
            <li><a href="#" data-value="<?php echo $path.$files[2];?>" class="contourclick"><span>Benguet</span></a></li>
            <li><a href="#" data-value="<?php echo $path.$files[3];?>" class="contourclick"><span>Ifugao</span></a></li>            
            <li><a href="#" data-value="<?php echo $path.$files[4];?>" class="contourclick"><span>Kalinga</span></a></li>
            <li><a href="#" data-value="<?php echo $path.$files[5];?>" class="contourclick"><span>Mt. Province</span></a></li>
          </ul>
        </li>
       
       <!-- @if($typhoonstatus[0]->typhoonstat == 1)
        <li  class="collapsed prntli">
          <a data-toggle="collapse"  class="homepagetoogle" data-target=".typhoontracks" href="#"><i class="fa fa-1x fa-road" aria-hidden="true"></i>  Typhoon Tracks<span class="arrow"></span></a>
          <ul class="sub-menu collapse ulsensorstop typhoontracks"  id="typhoontracks">
              @foreach($typhoontracks as $typhoontrack)
                @if($typhoontrack->typhoonstat == 1)
                  <li><a href="#" data-value="{{$typhoontrack->typhoonpath}}" class="typhoonclick"><span>{{$typhoontrack->typhoonName}}</span></a></li>
                @endif
              @endforeach
          </ul>
        </li>
        @endif-->
        <li class="externallink">
          <a href="http://bagong.pagasa.dost.gov.ph/tropical-cyclone/tropical-cyclone-advisory" target="_blank"><i class="fa fa-1x fa-road" aria-hidden="true"></i> Typhoon Tracks</a>
        </li>
        <!--<li class="externallink">
          <a href="{{action('ChartController@viewmultipleCharts')}}"><i class="fa fa-eye" aria-hidden="true"></i> Charts</a>
        </li>-->
    </ul>
  </div>
</div>
  </nav>
<button class="btn btnleftmenu"><i class="fa fa-bars fa-2x toggle-btn"></i></button>

