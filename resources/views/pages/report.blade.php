@extends('layouts.masters.backend-layout')
@section('pagecss')
<link rel="stylesheet" href="{!! url('css/bootstrap-datepicker3.css') !!}">
@endsection
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">
			<span class="fa fa-line-chart"></span> 
			Report Generation 
			<button id="btn-tour" type="button" class="btn btn-success">Quick Tour</button>
			<!--
			<span style="float: right;">
				<select id="report-type" class="btn btn-default form-control" style="color: #000000;" disabled="disabled">
					<option value="1" selected> HYDROMET DATA </option>
					<option value="2"> LANDSLIDES </option>
					<option value="3"> FLOODS </option>
					<option value="4"> ROAD NETWORKS </option>
				</select>
			</span> !-->
		</h1>

		<!-- /.row -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="demo-icon fa-5x">&#xe801;</i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"></div>
                                <div>Hydromet Data Report</div>
                            </div>
                        </div>
                    </div>
                    <a href="#" id="toggle-hydromet-data">
                        <div class="panel-footer">
                            <b><span id="text-hydromet" class="pull-left">Selected</span></b>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa-5x demo-icon">&#xe801;</i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"></div>
                                <div>Landslide Report</div>
                                <br>
                            </div>
                        </div>
                    </div>
                    <a href="#" id="toggle-landslide-data">
                        <div class="panel-footer">
                            <b><span id="text-landslide" class="pull-left">View</span></b>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa-5x demo-icon">&#xe801;</i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"></div>
                                <div>Flood Report</div>
                            </div>
                        </div>
                    </div>
                    <a href="#" id="toggle-flood-data">
                        <div class="panel-footer">
                            <b><span id="text-flood" class="pull-left">View</span></b>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa-5x demo-icon">&#xe801;</i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"></div>
                                <div>Road Networks Report</div>
                            </div>
                        </div>
                    </div>
                    <a href="#" id="toggle-road-data">
                        <div class="panel-footer">
                            <b><span id="text-road" class="pull-left">View</span></b>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        <!-- /.row -->
	</div>

	<hr id="b-color" style="background: #d9534f; border: 0; height: 5px">

	<div id="hydromet-data">
		
		<div id="btn-display-info"></div>

		<!-- Main -->
		<div id="main-display" class="form-group col-xs-12 col-md-12 col-lg-12">
			<div class="form-group col-xs-12 col-md-4 col-lg-4">
				<div id="display-info">
					<div class="panel-heading" style="background-color: #262626;">
						
						<h4>
							<B style="color: #FFFFFF;">
								<span>
									<div class="btn-group">
										<button id="btn-settings" class="btn btn-danger btn-sm dropdown-toggle" type="button" data-toggle="dropdown" 
											arial-haspopup="true" arial-expanded="false">
											<span class="glyphicon glyphicon-cog"></span>
										</button>

										<ul class="dropdown-menu">
											
											<li><a id="display-info-hide" href="#">Hide</a></li>

										</ul>
									</div>
								</span> 

								Display Information

							</B>
						</h4>

						<hr  style="border-top: 1px solid #1e1d1f;">
						
						<div class="well" style="background-color: #1e1d1f; color: #FFFFFF;">
							<p>
								<span>
									<label><B><span class="glyphicon glyphicon-list"></span> Display Type:</B></label>
								</span>

								<span>
									<select id="display-type" class="btn form-control" style="color: #000000;" disabled="disabled">
										<option value="1" selected>Default (ARG - 15mins, WLMS & TDM - 10mins)</option>
										<option value="2"> Hourly </option>
										<option value="3"> Daily </option>
										<option value="4"> Monthly </option>
										<option value="5"> Yearly </option>
										<option value="6"> Other (Accumulated Rainfall and/or Lowest & Highest Waterlevel for a Period of Time) </option>
									</select>
								</span>

								<div class="radio">
					    	  	  	<label><input id="generate-all-sensors" class='form-check-input' type='checkbox' value="" disabled="disabled"> Generate All Sensors</label>
					    	  	</div>
							</p>

							<br>
							
							<div id="other-information" class="panel-collapse collapse-in collapse in" aria-expanded="true">
								<p>
									<span>
										<label><B> <span class="glyphicon glyphicon-eye-open"></span> Sensor Type: (<em>Filters the location</em>)</B></label>
									</span>

									<span>
										<select id="sensor-type" class="btn form-control" style="color: #000000;" disabled="disabled">
											<option value="0" selected>ALL</option>
											<option value="1">Automated Rain Gauge (ARG)</option>
											<option value="2">Waterlevel Monitoring Sensor (WLMS)</option>
											<option value="3">Automated Rain and Stream Gauge (TDM)</option>
											<option value="4">Automated Weather Station (AWS)</option>
										</select>
									</span>
								</p>

								<br>

								<p>
									<div class="panel panel-default">
								  		<div class="panel-heading" role="tab" id="headingTwo">
								  		    <h4 class="panel-title">
								  		    	<a class data-toggle="collapse" data-parent="#accordion" href="#collapse-location"
								  		    		aria-expanded="false" aria-controls="collapseOn">
								  		    	  	<div id="location"> 
								  		    	  		<B> 
								  		    	  			<span class="glyphicon glyphicon-screenshot"></span> 
								  		    	  				Location 
								  		    	  			<span class="glyphicon glyphicon-chevron-down"></span>
								  		    	  			<span id="info-sensor-location"> </span>
								  		    	  		</B> 
								  		    	  	</div>
								  		    	</a>
								  		    </h4>
								  		</div>
								  		<div id="collapse-location" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
								  		   	<div class="well" style="background-color: #262626; color: #FFFFFF;">
								  		   		<span>
													<label><B>Province:</B></label>
												</span>

												<span>
													<select name="province_id" id="province-id" class="btn form-control" style="color: #000000;" disabled="disabled">
														
														@foreach($provinces as $province)

															@if($province->id === 1)
																<option selected="selected" value="{{ $province->id }}">{{ $province->name }}</option>
															@else
																<option value="{{ $province->id }}">{{ $province->name }}</option>
															@endif	

														@endforeach

													</select>
												</span>

												<hr>

												<span>
													<label><B>Sensor Location/s:</B></label>
												</span>

												<span>
													<select name="address_id" id="address-id" class="form-control" id="locationlist" size="10" style="color: #000000; overflow-y: auto;"  disabled="disabled">

													</select>
												</span>
								  		   	</div>
								  		</div>
								  	</div>
								</p>
								<p>
									<span> 
										<B>Sensor Location:</B>
									</span> 
									<span id="sensor-location-display" class="label btn form-control" style="color: #000000;">
										Null
									</span>
								</p>
								<p>
									<span> 
										<B>Landslide Threshold:</B>
									</span> 
									<span id="landslide-threshold-display" class="label btn form-control" style="color: #000000;">
										Null
									</span>
								</p>
								<!--
								<p>
									<span> 
										<B>Flood Threshold:</B>
									</span> 
									<span id="flood-threshold-display" class="label btn form-control" style="color: #000000;">
										Null
									</span>
								</p>
								!-->
								<hr>
							</div>

							<div class="panel panel-default">
						  		<div class="panel-heading" role="tab" id="headingTwo">
						  		    <h4 class="panel-title">
						  		    	<a class data-toggle="collapse" data-parent="#accordion"
						  		    		aria-expanded="false" aria-controls="collapseTwo">
						  		    	  	<div> <B><span class="glyphicon glyphicon-calendar"></span> Date: <span id="display-date"></span></B> </div>
						  		    	</a>
						  		    </h4>
						  		</div>
						  		<div id="collapse" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
						  		   	<div class="well" style="background-color: #262626; color: #FFFFFF;">
						  		   		<div id="calendar-input">

		                                    
		                                </div>
						  		   	</div>
						  		</div>
						  	</div>
						  	<form id="btn-generate" action="#">
				      	 		<input type="hidden" name="_token" value="{{ csrf_token() }}">
				      	 		<input type="button" name="Generate Data" value="Generate Data" class="btn btn-primary btn-block">
				      		</form>
						</div>
					</div>
			    </div>
			    <br>
			    <div id="defective-date" hidden>
			    	<div class="well" style="background-color: #262626;">
			    		<h4>
							<B style="color: #FFFFFF;">
								<span class="fa fa-exclamation-triangle" aria-hidden="true" style="color: #d9534f;"></span>
								Warning
							</B>
						</h4>

						<div class="well" style="background-color: #1e1d1f; color: #FFFFFF; margin-bottom: 8px;">
							<table style="background-color: #FFFFFF; color: #d9534f; width:100%; font-size: 15px; 
									      border-radius: 6px; margin-bottom: 2px;" 
								   class="table table-hover">
							    <thead>
							      	<tr>
							      	  	<th style="background-color: #363940; color: #FFFFFF;">
							      	  		YYYY/MM/DD - Remarks
							      	  	</th>
							      	</tr>
							    </thead>
							    <tbody id="defective-table" style="overflow-y: auto; height: 178px; display: block;
							    								   font-size: 13px;">
								    
							    </tbody>
							</table>
						</div>
			    	</div>
			    </div>
			</div>

		    <div id="frmmain" class="form-group col-xs-12 col-md-8 col-lg-8">
		      	<div class="panel panel-default">
		      	  	<div class="panel-heading" style="border-color: #1e1d1f; background-color: #262626;">
		      	  		<label id="data-title" style="color:#FFFFFF;"> 
		      	  			<h4>
		      	  				<b>
		      	  					<span class="glyphicon glyphicon-list-alt"></span> 
		      	  					DATA [ <span id="location-title" style="color: #9edbf9;"> </span> ]
		      	  				</b>
		      	  			</h4>
		      	  			<div id="buttons"></div>
		      	  		</label>
		      	  	</div>
		      	  	<div class="panel-body" style="background-color: #252525;">
		      	  		<div id="CSVTableDisplay" class="well panel-collapse collapse-in" style="background-color: #1e1d1f;">
		      	  			<div id="report-table" style="overflow-y: auto;"> 
			      	  			<center>
			      	  				<h3 style="color: #FFFFFF;">Generate a data first.</h3>
			      	  			</center>
		      	  			</div>
		      	  		</div>
		      		</div>
		    	</div>
			</div>
			

		</div>

	</div>

	<div id="landslide-data" hidden>
		
		<div class="form-group col-xs-12 col-md-12 col-lg-12">

			<div class="form-group col-xs-12 col-md-12 col-lg-12">
		      	<div class="panel panel-default">
		      	  	<div class="panel-heading" style="border-color: #1e1d1f; background-color: #262626;">
		      	  		<label style="color:#FFFFFF;"> 
		      	  			
		      	  			<h4>
		      	  				<b>
		      	  					<span class="glyphicon glyphicon-list-alt"></span> 
		      	  					DATA [ <span style="color: #9edbf9;"> Landslide Reports </span> ]
		      	  				</b>
		      	  			</h4>

		      	  		</label>
		      	  		
		      	  	</div>

		      	  	<div class="panel-body" style="background-color: #252525;">

		      	  		<div id="landslide-display" class="well" style="background-color: #1e1d1f;">

		      	  			<div id="landslide-table" style="overflow-y: auto;"> 
			      	  			


		      	  			</div>
		      	  			
		      	  		</div>
	 
		      		</div>

		    	</div>

			</div>

		</div>

	</div>

	<div id="flood-data" hidden>
		
		<div class="form-group col-xs-12 col-md-12 col-lg-12">

			<div class="form-group col-xs-12 col-md-12 col-lg-12">
		      	<div class="panel panel-default">
		      	  	<div class="panel-heading" style="border-color: #1e1d1f; background-color: #262626;">
		      	  		<label style="color:#FFFFFF;"> 
		      	  			
		      	  			<h4>
		      	  				<b>
		      	  					<span class="glyphicon glyphicon-list-alt"></span> 
		      	  					DATA [ <span style="color: #9edbf9;"> Flood Reports </span> ]
		      	  				</b>
		      	  			</h4>

		      	  		</label>
		      	  		
		      	  	</div>

		      	  	<div class="panel-body" style="background-color: #252525;">

		      	  		<div id="flood-display" class="well" style="background-color: #1e1d1f;">

		      	  			<div id="flood-table" style="overflow-y: auto;"> 
			      	  			
		      	  				
			      	  			
		      	  			</div>
		      	  			
		      	  		</div>
	 
		      		</div>

		    	</div>

			</div>

		</div>

	</div>

	<div id="road-data" hidden>
		
		<div class="form-group col-xs-12 col-md-12 col-lg-12">

			<div class="form-group col-xs-12 col-md-12 col-lg-12">
		      	<div class="panel panel-default">
		      	  	<div class="panel-heading" style="border-color: #1e1d1f; background-color: #262626;">
		      	  		<label style="color:#FFFFFF;"> 
		      	  			
		      	  			<h4>
		      	  				<b>
		      	  					<span class="glyphicon glyphicon-list-alt"></span> 
		      	  					DATA [ <span style="color: #9edbf9;"> Road Network Reports </span> ]
		      	  				</b>
		      	  			</h4>

		      	  		</label>
		      	  		
		      	  	</div>

		      	  	<div class="panel-body" style="background-color: #252525;">

		      	  		<div id="road-display" class="well" style="background-color: #1e1d1f;">

		      	  			<div id="road-table" style="overflow-y: auto;"> 
			      	  			
		      	  				
			      	  			
		      	  			</div>
		      	  			
		      	  		</div>
	 
		      		</div>

		    	</div>

			</div>

		</div>

	</div>

	<!-- Modal -->
	<div class="modal fade" id="generate-report-modal" role="dialog">
	  	<div class="modal-dialog">
	  
	    	<!-- Modal content-->
	    	<div class="modal-content">
	    	  	<div class="modal-header">
	    	  	  	<button type="button" class="close" data-dismiss="modal">&times;</button>
	    	  	  	<h4 class="modal-title">Disclaimer</h4>
	    	  	</div>
	    	  	<div class="modal-body">
	    	  	  	<p>Please bear in mind that the development of this website and the calibration of sensors used in data collection are on-going. The data reflected herein have not been subjected to any corrections and should not be construed as an official material of the Department of Science and Technology (DOST) and its affiliates. This medium has been created for the use of authorized disaster managers in the region, who have the capacity to validate, interpret and process the data.</p>
	    	  	</div>
	    	  	<div class="modal-footer">
	    	  	  	<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
	    	  	</div>
	    	</div>
	    
	  	</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="error-report-modal" role="dialog">
	  	<div class="modal-dialog modal-lg">
	  
	    	<!-- Modal content-->
	    	<div class="modal-content">
	    	  	<div class="modal-header">
	    	  	  	<button type="button" class="close" data-dismiss="modal">&times;</button>
	    	  	  	<h4 class="modal-title">Error</h4>
	    	  	</div>
	    	  	<div class="modal-body">
	    	  	  	<p>
	    	  	  		Please select a sensor location.
	    	  	  		<center><img src="css/images/report/select-location2.png" class="img-responsive img-thumbnail" alt="Responsive image"></center>
	    	  	  	</p>
	    	  	</div>
	    	  	<div class="modal-footer">
	    	  	  	<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
	    	  	</div>
	    	</div>
	    
	  	</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="tour-report-modal" role="dialog">
	  	<div class="modal-dialog modal-lg">
	  
	    	<!-- Modal content-->
	    	<div class="modal-content">
	    	  	<div class="modal-header">
	    	  	  	<button type="button" class="close" data-dismiss="modal">&times;</button>
	    	  	  	<h4 class="modal-title">Quick Tour</h4>
	    	  	</div>
	    	  	<div class="modal-body">
	    	  	  	<p>
	    	  	  		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
						  <!-- Indicators -->
						  <ol class="carousel-indicators">
						    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
						    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
						    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
						  </ol>

						  <!-- Wrapper for slides -->
						  <div class="carousel-inner" role="listbox">
						    <div class="item active">
						      <img src="css/images/report/select-location.png" class="img-thumbnail" alt="Responsive image">
						      <div class="carousel-caption">
						        ...
						      </div>
						    </div>
						    <div class="item">
						      <img src="css/images/report/select-location2.png" class="img-thumbnail" alt="Responsive image">
						      <div class="carousel-caption">
						        ...
						      </div>
						    </div>
						    ...
						  </div>

						  <!-- Controls -->
						  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
						    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						    <span class="sr-only">Previous</span>
						  </a>
						  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
						    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						    <span class="sr-only">Next</span>
						  </a>
						</div>
	    	  	  	</p>
	    	  	</div>
	    	  	<div class="modal-footer">
	    	  	  	<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
	    	  	</div>
	    	</div>
	    
	  	</div>
	</div>

	<script type="x/kendo-template" id="page-template">
	    <div class="page-template">
	      	<div class="header">
	      	  	<div style="float: right">Page #: pageNum # of #: totalPages #</div>
	      	  	Disaster Risk Reduction Management Information System
	      	</div>
	      	<div class="footer">
	      	  	Page #: pageNum # of #: totalPages #
	      	</div>
	    </div>
    </script>

</div>

@stop
@section('page-js-files')
  	<script src="{!! url('assets/js/report.js') !!}"></script>
@stop