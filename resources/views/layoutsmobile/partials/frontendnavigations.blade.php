<div class="col-xs-12" id="mobilehomelinkwrap">
  <a href="#menumobileinnplayouts" id="mobilehomelink" class="stripelink"><span></span></a>
</div>
<nav id="menumobileinnplayouts" class="mobilenav hidden-sm hidden-lg hidden-md">
  <ul>
      <li><a href="{{ action("HydrometController@dashboard") }}">Dashboard</a></li>         
         <li><span>Prevention & Mitigation</span>
          <ul>
            <li><a href="{{action('HydrometController@dashboard')}}">Monitor</a></li>
            <li><a href="{{action('HydrometController@dashboard')}}">Report</a></li>
            <li><a href="{{action('HydrometController@dashboard')}}">Warn</a></li>    
          </ul>
        </li> 
      <li>
      <a href="{{action('ChartController@viewmultipleCharts')}}">Rain Monitoring</a>
    </li>
    <li>{!! link_to_route('get_logout', 'Log out') !!}</li>
  </ul>
</nav>