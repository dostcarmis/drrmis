<div id="selectsitreplevelmodal" class="modal fade" role="dialog">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    * {
      box-sizing: border-box;
    }
    body {
      font-family: Arial, Helvetica, sans-serif;
    }
    /* Float four columns side by side */
    .column {
      float: left;
      width: 25%;
      padding: 0 10px;
    }
    /* Remove extra left and right margins, due to padding */
    .row {margin: 0 -5px;}
    /* Clear floats after the columns */
    .row:after {
      content: "";
      display: table;
      clear: both;
    }
    /* Responsive columns */
    @media screen and (max-width: 600px) {
      .column {
        width: 100%;
        display: block;
        margin-bottom: 20px;
      }
    }
    /* Style the counter cards */
    .card {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      padding: 8px;
      text-align: center;
      background-color: #f1f1f1;
    }
    </style>  
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4  data-toggle="tooltip"  title="Note: Select the level where you want to download sitrep" class="modal-title">Select Sitrep Level <i class="fa fa-info-circle" text-align="right" aria-hidden="true"></i></h4>
        </div>
          <div class="modal-body">
            <ul class="custom-list action" id="sitrep-level-list">
              <a href="#" level="regional" class="clearformat"><li><i class="fa fa-folder" aria-hidden="true"></i>&nbspRegional Sitreps</li></a>
              <a href="#" level="provincial" class="clearformat"><li><i class="fa fa-folder" aria-hidden="true"></i>&nbspProvincial Sitreps</li></a>
              <a href="#" level="municipal" class="clearformat"><li><i class="fa fa-folder" aria-hidden="true"></i>&nbspMunicipal Sitreps</li></a>
              <a href="#" level="all" class="clearformat"><li><i class="fa fa-folder" aria-hidden="true"></i>&nbspAll Sitreps</li></a>
            </ul>
            {{-- {{ url("sitreps/regional") }}
            {{ url("sitreps/provincial") }}
            {{ url("sitreps/municipal") }}
            {{ url("sitreps") }} --}}
            {{-- <div class="row xs-d-none sm-d-none md-d-block">
              <div class="column">
                <a href="{{ url("sitreps/regional") }}" class="clearformat">
                  <div class="card">
                      <img border="0" src="{{ asset("assets/images/filetypeicons/folder.png") }}" width="100" height="100" >
                      <p>Regional Sitreps</p>
                  </div>
                </a>
              </div>
              @if(Auth::check() && Auth::user()->role_id <= 3)
                <div class="column">
                  <a href="{{ url("sitreps/provincial") }}" class="clearformat">
                    <div class="card">
                      <img border="0" src="{{ asset("assets/images/filetypeicons/folder.png") }}" width="100" height="100" >
                      <p>Provincial Sitreps</p>
                    </div>
                  </a>
                </div> 
              @endif
              <div class="column">
                <a href="{{ url("sitreps/municipal") }}" class="clearformat">
                  <div class="card">
                      <img border="0" src="{{ asset("assets/images/filetypeicons/folder.png") }}" width="100" height="100" >
                      <p>Municipal Sitreps</p>
                  </div>
                </a>
              </div>
              <div class="column">
                <a href="{{ url("sitreps") }}" class="clearformat">
                  <div class="card">
                    <img border="0" src="{{ asset("assets/images/filetypeicons/folder.png") }}" width="100" height="100" >
                    <p>All Uploaded Sitreps</p>
                  </div>
                </a>
              </div>

            </div>
            <div class="container md-d-none">
              <div class="row d-flex xs-mb-3 sm-mb-3">
                <div class="col-xs-3 col-sm-3 h-100 px-2">
                  <a class="clearformat h-100 w-100" href="{{ url("sitreps/regional") }}">
                    <button class="btn btn-secondary h-100 w-100">
                      <img border="0" src="{{ asset("assets/images/filetypeicons/folder.png") }}" class="w-100">
                      <p>Regional</p>
                    </button>
                  </a>
                </div>
                @if(Auth::check() && Auth::user()->role_id <= 3)
                  <div class="col-xs-3 col-sm-3 h-100 px-2">
                    <a class="clearformat h-100 w-100" href="{{ url("sitreps/provincial") }}">
                      <button class="btn btn-secondary h-100 w-100">
                        <img border="0" src="{{ asset("assets/images/filetypeicons/folder.png") }}" class="w-100">
                        <p>Provincial</p>
                      </button>
                    </a>
                  </div>
                @endif
                <div class="col-xs-3 col-sm-3 h-100 px-2">
                  <a class="clearformat h-100 w-100" href="{{ url("sitreps/municipal") }}">
                    <button class="btn btn-secondary h-100 w-100">
                      <img border="0" src="{{ asset("assets/images/filetypeicons/folder.png") }}" class="w-100">
                      <p>Municipal</p>
                    </button>
                  </a>
                </div>
                <div class="col-xs-3 col-sm-3 h-100 px-2">
                  <a class="clearformat h-100 w-100" href="{{ url("sitreps") }}">
                    <button class="btn btn-secondary h-100 w-100">
                      <img border="0" src="{{ asset("assets/images/filetypeicons/folder.png") }}" class="w-100">
                      <p>All Sitreps</p>
                    </button>
                  </a>
                </div>
              </div>
            </div> --}}
          </div> 
        <div class="modal-footer">
          <div class="col-xs-12 np">
            {{-- <a href="#" data-toggle="modal" data-target="#addsitrepModal" class="btn btn-viewupload xs-mb-3 sm-mb-3">+ Add New File</a> --}}
            <a type="button" class="btn btn-danger xs-mb-3 sm-mb-3" data-dismiss="modal">Cancel</a>
          </div> 
          
        </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    $(document).on('click','#filetype-list-toggle',function(e){
      e.stopImmediatePropagation();
      $('#filetype-list').slideToggle();
      $(this).find('i').toggleClass('fa-folder fa-folder-open')
    })
    .on('click','#sitrep-level-list>a ',function(){
      let data = {};
      let ref_id = $(this).attr('level');
      data = {"sitrep_level":ref_id};
      
      $.ajax({
        type:"POST",
        data:data,
        url:"{{route('sitrep-viewfiles')}}",
        success:function(res){
          $('#page-wrapper').html(res);
          $('#sitrep_table').DataTable();
          $("#selectsitreplevelmodal").modal('hide');
        }
      })
    })
  </script>
  {{-- @include('pages.addsitrep') --}}
