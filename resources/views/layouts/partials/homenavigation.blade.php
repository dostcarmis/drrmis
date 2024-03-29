<div class="homenavwrap">
  <div class="container-fluid">
    <nav class="navbar navbar-default hidden-xs" id="home-nav">        
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      </button>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav nav-justified">
        <li><a href="{{ action("HydrometController@dashboard") }}">Prevention and Mitigation</a></li>
        <li><a href="{{action('PreparednessController@viewPreparedness')}}">Preparedness</a></li>
        <li><a href="{{action('ResponseController@viewResponse')}}">Response</a></li>
        <li><a href="{{action('RehabilitationController@viewRehabilitation')}}">Rehabilitation & Recovery</a></li>
      </ul>
    </div><!--/.nav-collapse -->
    </nav>
  </div>
  
</div>