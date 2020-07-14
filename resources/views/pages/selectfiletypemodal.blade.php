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
          <h4 href="#" data-toggle="tooltip"  title="Note: Select file type you want to download" class="modal-title">Select File Type <i class="fa fa-info-circle" text-align="right" aria-hidden="true"></i></h4>
        </div>
                    
          <div class="modal-body">
            <div class="row">
                
                <div class="column">
                    <div class="card">
                      <div></div>
                          <a href="{{ url("filedownloadpage?filetype=docx") }}"><img border="0" src="{{ asset("assets/images/filetypeicons/doc.png") }}" width="100" height="100"></a>
                          <p>Documents</p>
                      </div>
                </div> 

                <div class="column">
                    <div class="card">
                          <div class="view overlay zoom cursor-pointer">
                              <a href="{{ url("filedownloadpage?filetype=pptx") }}">
                                <img class="card-img-top img-fluid" border="0" alt="Icon" src="{{ asset("assets/images/filetypeicons/ppt.png") }}" width="100" height="100">
                              </a>
                          </div>
                        <p>Presentations</p>
                    </div>
                </div> 

                <div class="column">
                    <div class="card">
                        <a href="{{ url("filedownloadpage?filetype=xlsx") }}"><img border="0"  src="{{ asset("assets/images/filetypeicons/xlsx.png") }}" width="100" height="100"></a>
                        <p>Workbooks</p>
                    </div>
                </div> 

                 <div class="column">
                        <div class="card">
                            <a href="{{ url("filedownloadpage?filetype=pdf") }}"><img border="0"  src="{{ asset("assets/images/filetypeicons/pdf.png") }}" width="100" height="100"></a>
                            <p>Portable Documents</p>
                        </div>
                </div> 

                <div class="column">
                    <div class="card">
                        <a href="{{ url("filedownloadpage?filetype=kml") }}"><img border="0"  src="{{ asset("assets/images/filetypeicons/kml.png") }}" width="100" height="100"></a>
                        <p>Maps (KML)</p>
                    </div>
                </div> 

                <div class="column">
                  <div class="card">
                      <a href="{{ url("filedownloadpage?filetype=jpeg") }}"><img border="0"  src="{{ asset("assets/images/filetypeicons/jpeg.png") }}" width="100" height="100"></a>
                      <p>Maps (JPG)</p>
                  </div>
              </div>

               <div class="column">
                    <div class="card">
                        <a href="{{ url("filedownloadpage") }}"><img border="0"  src="{{ asset("assets/images/filetypeicons/all.png") }}" width="100" height="100"></a>
                        <p>All Files</p>
                    </div>
                </div> 

              </div>
          </div> 


        <div class="modal-footer">
          <div class="col-xs-12 np"><a href="#" data-toggle="modal" data-target="#addfileModal" class="btn btn-viewupload">+ Add New File</a></div> 
          <a type="button" class="btn btn-danger" data-dismiss="modal">Cancel</a>  
             
        </div>
        </form>
      </div>
    </div>
  </div>
  @include('pages.adddrrmfile')
