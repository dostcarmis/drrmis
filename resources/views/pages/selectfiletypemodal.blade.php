<div id="selectfilemodal" class="modal fade" role="dialog">
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
          <h4 href="#" data-toggle="tooltip"  title="Note: Select file type you want to download" class="modal-title">Select File</h4>
        </div>
                    
          <div class="modal-body">
            <ul class="custom-list action">
              <li><i class="fa fa-folder" aria-hidden="true"></i> RDNA</li>
              <li><i class="fa fa-folder" aria-hidden="true"></i> PDNA</li>
              <li><i class="fa fa-folder" aria-hidden="true"></i> Minutes of Meetings</li>
              <li id="filetype-list-toggle"><i class="fa fa-folder" aria-hidden="true"></i> File types</li>
            </ul>
            <ul class="custom-list action ms-3" id="filetype-list" style="display: none">
              <a class="clearformat" href="{{ url("filedownloadpage") }}"><li><i class="fa fa-files-o" aria-hidden="true"></i>&nbspAll files</li></a>
              <a class="clearformat" href="{{ url("filedownloadpage?filetype=docx") }}"><li><i class="fa fa-files-o" aria-hidden="true"></i>&nbspDocuments</li></a>
              <a class="clearformat" href="{{ url("filedownloadpage?filetype=pptx") }}"><li><i class="fa fa-files-o" aria-hidden="true"></i>&nbspPresentations</li></a>
              <a class="clearformat" href="{{ url("filedownloadpage?filetype=xlsx") }}"><li><i class="fa fa-files-o" aria-hidden="true"></i>&nbspWorkbooks</li></a>
              <a class="clearformat" href="{{ url("filedownloadpage?filetype=pdf") }}"><li><i class="fa fa-files-o" aria-hidden="true"></i>&nbspPortable Documents</li></a>
              <a class="clearformat" href="{{ url("filedownloadpage?filetype=kml") }}"><li><i class="fa fa-files-o" aria-hidden="true"></i>&nbspMaps (KML)</li></a>
              <a class="clearformat" href="{{ url("filedownloadpage?filetype=jpeg") }}"><li><i class="fa fa-files-o" aria-hidden="true"></i>&nbspMaps (JPG)</li></a>
            </ul>
            {{-- <div class="row xs-d-none sm-d-none md-d-block">
                <div class="column">
                  <a class="clearformat" href="{{ url("filedownloadpage?filetype=docx") }}">
                    <div class="card">
                      <img border="0" src="{{ asset("assets/images/filetypeicons/doc.png") }}" width="100" height="100">
                        <p>Documents</p>
                    </div>
                  </a>
                </div> 

                <div class="column">
                  <a class="clearformat" href="{{ url("filedownloadpage?filetype=pptx") }}">
                    <div class="card">
                        <div class="view overlay zoom cursor-pointer">
                          <img class="card-img-top img-fluid" border="0" alt="Icon" src="{{ asset("assets/images/filetypeicons/ppt.png") }}" width="100" height="100">
                        </div>
                        <p>Presentations</p>
                    </div>
                  </a>
                </div> 

                <div class="column">
                  <a class="clearformat" href="{{ url("filedownloadpage?filetype=xlsx") }}">
                    <div class="card">
                      <img border="0"  src="{{ asset("assets/images/filetypeicons/xlsx.png") }}" width="100" height="100">
                      <p>Workbooks</p>
                    </div>
                  </a>
                </div> 

                <div class="column">
                  <a class="clearformat" href="{{ url("filedownloadpage?filetype=pdf") }}">
                    <div class="card">
                      <img border="0"  src="{{ asset("assets/images/filetypeicons/pdf.png") }}" width="100" height="100">
                      <p>Portable Documents</p>
                    </div>
                  </a>
                </div> 

                <div class="column">
                  <a class="clearformat" href="{{ url("filedownloadpage?filetype=kml") }}">
                    <div class="card">
                      <img border="0"  src="{{ asset("assets/images/filetypeicons/kml.png") }}" width="100" height="100">
                      <p>Maps (KML)</p>
                    </div>
                  </a>
                </div> 

                <div class="column">
                  <a class="clearformat" href="{{ url("filedownloadpage?filetype=jpeg") }}">
                    <div class="card">
                      <img border="0"  src="{{ asset("assets/images/filetypeicons/jpeg.png") }}" width="100" height="100">
                      <p>Maps (JPG)</p>
                    </div>
                  </a>
                </div>

               <div class="column">
                <a class="clearformat" href="{{ url("filedownloadpage") }}">
                  <div class="card">
                    <img border="0"  src="{{ asset("assets/images/filetypeicons/all.png") }}" width="100" height="100">
                    <p>All Files</p>
                  </div>
                </a>
              </div> 

            </div>
            <div class="container md-d-none">
              <div class="row d-flex xs-mb-3 sm-mb-3">
                <div class="col-xs-4 col-sm-4 h-100 px-2">
                  <a class="clearformat h-100 w-100" href="{{ url("filedownloadpage?filetype=docx") }}">
                    <button class="btn btn-secondary h-100 w-100">
                      <img border="0" src="{{ asset("assets/images/filetypeicons/doc.png") }}" width="50" height="50">
                      <p class="medium-text"> Documents</p>
                    </button>
                  </a>
                </div>
                <div class="col-xs-4 col-sm-4 h-100 px-2">
                  <a class="clearformat h-100 w-100" href="{{ url("filedownloadpage?filetype=ppt") }}">
                    <button class="btn btn-secondary h-100 w-100">
                      <img border="0" src="{{ asset("assets/images/filetypeicons/ppt.png") }}" width="50" height="50">
                      <p class="medium-text"> Presentations</p>
                    </button>
                  </a>
                </div>
                <div class="col-xs-4 col-sm-4 h-100 px-2">
                  <a class="clearformat h-100 w-100" href="{{ url("filedownloadpage?filetype=xlsx") }}">
                    <button class="btn btn-secondary h-100 w-100">
                      <img border="0" src="{{ asset("assets/images/filetypeicons/xlsx.png") }}" width="50" height="50">
                      <p class="medium-text">Workbooks</p>
                    </button>
                  </a>
                </div>
              </div>
              <div class="row d-flex xs-mb-3 sm-mb-3">
                <div class="col-xs-4 col-sm-4 h-100 px-2">
                  <a class="clearformat h-100 w-100" href="{{ url("filedownloadpage?filetype=pdf") }}">
                    <button class="btn btn-secondary h-100 w-100">
                      <img border="0" src="{{ asset("assets/images/filetypeicons/pdf.png") }}" width="50" height="50">
                      <p class="medium-text">PDFs</p>
                    </button>
                  </a>
                </div>
                <div class="col-xs-4 col-sm-4 h-100 px-2">
                  <a class="clearformat h-100 w-100" href="{{ url("filedownloadpage?filetype=kml") }}">
                    <button class="btn btn-secondary h-100 w-100">
                      <img border="0" src="{{ asset("assets/images/filetypeicons/kml.png") }}" width="50" height="50">
                      <p class="medium-text">Maps (KML)</p>
                    </button>
                  </a>
                </div>
                <div class="col-xs-4 col-sm-4 h-100 px-2">
                  <a class="clearformat h-100 w-100" href="{{ url("filedownloadpage?filetype=jpeg") }}">
                    <button class="btn btn-secondary h-100 w-100">
                      <img border="0" src="{{ asset("assets/images/filetypeicons/jpeg.png") }}" width="50" height="50">
                      <p class="medium-text">Maps (JPG)</p>
                    </button>
                  </a>
                </div>
              </div>
              <div class="row d-flex">
                <div class="col-xs-4 col-sm-4 h-100 px-2">
                  <a class="clearformat h-100 w-100" href="{{ url("filedownloadpage") }}">
                    <button class="btn btn-secondary h-100 w-100">
                      <img border="0" src="{{ asset("assets/images/filetypeicons/all.png") }}" width="50" height="50">
                      <p class="medium-text">All files</p>
                    </button>
                  </a>
                </div>
              </div>
            </div> --}}
          </div> 



        <div class="modal-footer">
          <div class="col-xs-12 np">
            <a href="#" data-toggle="modal" data-target="#addfileModal" class="btn btn-viewupload xs-mb-3 sm-mb-3">+ Add New File</a>
            <a type="button" class="btn btn-danger xs-mb-3 sm-mb-3" data-dismiss="modal">Cancel</a>  
          </div> 
        </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    $(document).on('click','#filetype-list-toggle',function(){
      $('#filetype-list').slideToggle();
      $(this).find('i').toggleClass('fa-folder fa-folder-open')
    })
  </script>
  @include('pages.adddrrmfile')
