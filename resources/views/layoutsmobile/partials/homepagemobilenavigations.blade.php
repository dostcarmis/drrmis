<div class="col-xs-12" id="mobilehomelinkwrap">
  <span class="defsp spmobilebrand">Disaster Risk Reduction Management IS</span><a href="#menumobile" id="mobilehomelink" class="stripelink"><span></span></a>
</div>
<nav id="menumobile" class="mobilenav hidden-sm hidden-lg hidden-md">
  <ul>
    @if( Auth::user() )
        <li><a href="{{ action("HydrometController@dashboard") }}">Dashboard</a></li>         
         <li><span>Prevention & Mitigation</span>
        <ul>
          <li><a href="{{action('HydrometController@dashboard')}}">Monitor</a></li>
          <li><a href="{{action('HydrometController@dashboard')}}">Report</a></li>
          <li><a href="{{action('HydrometController@dashboard')}}">Warn</a></li>    
        </ul>
      </li>
    @endif
    <li><span> Sensors</span>      
      <ul id="service">
          <li><a href="#" data-value="1" class="onclicksensor"><span>Rain Gauges</span></a></li>
          <li><a href="#" data-value="2" class="onclicksensor"><span>Stream Gauges</span></a></li>
          <li><a href="#" data-value="3" class="onclicksensor"><span>Rain and Stream Gauges</span></a></li>
          <li><a href="#" data-value="4" class="onclicksensor"><span>Weather Stations</span></a></li>
        </ul>
    </li> 
    <li><span> Hazard Maps</span>      
      <ul  id="new"> 
          <li class="titleli"><span>MGB</span>
            <ul id="mgb">
              @foreach($provinces as $province)
              <li class="foldername-prov"><span>{{$province->name}}</span>
                <ul id="mgb-{{$province->name}}">
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
            
          <li class="titleli"><span>NOAH</span>
            <ul id="noah">
             @foreach($provinces as $province)
                <li class="foldername-prov"><span>{{$province->name}}</span>
                <ul id="noah-{{$province->name}}">
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


          <li class="titleli"><span>Phivolcs</span>
              <ul id="phivolcs">
               @foreach($provinces as $province)
                  <li class="foldername-prov"><span>{{$province->name}}</span>
                  <ul id="phivolcs-{{$province->name}}">
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

            <li class="titleli"><span>DREAM / LiPAD</span>
              <ul id="dream">
               @foreach($provinces as $province)
                  <li class="foldername-prov"><span>{{$province->name}}</span>
                  <ul id="dream-{{$province->name}}">
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
            </li>
           

             
        </ul>
    </li>
   <li><span>Contours</span>
       
          <ul class="contours"  id="contours">

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
     @if( !Auth::user() )
          <li class="login">{!! link_to_route('get_login', 'Login') !!}</li>
          <li class="register">{!! link_to_route('get_register', 'Register') !!}</li>          
    @else
    <li>
      <a href="{{action('ChartController@viewmultipleCharts')}}">Charts</a>
    </li>
    <li>{!! link_to_route('get_logout', 'Log out') !!}</li>
    @endif
   
  </ul>
</nav>

