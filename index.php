<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>NYCCSC</title>
    <link rel="stylesheet" href="lib/bootstrap-3.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="lib/font-awesome-4.0.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="lib/leaflet-0.7.3/leaflet.css">
    <link rel="stylesheet" href="lib/jquery-ui-1.11.2.custom/jquery-ui.css">
    <link rel="stylesheet" href="lib/Leaflet.markercluster-master/dist/MarkerCluster.css">
    <link rel="stylesheet" href="lib/Leaflet.markercluster-master/dist/MarkerCluster.Default.css">
    <link rel="stylesheet" href="lib/leaflet-locatecontrol-gh-pages/src/L.Control.Locate.css">
    <link rel="stylesheet" href="assets/leaflet-groupedlayercontrol/leaflet.groupedlayercontrol.css">
    <link rel="stylesheet" href="assets/css/app.css">

    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/img/favicon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/img/favicon-152.png">
    <link rel="icon" sizes="196x196" href="assets/img/favicon-196.png">
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
  </head>

  <body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="navbar-header">
        <div class="navbar-icon-container">
          <a href="#" class="navbar-icon pull-right visible-xs" id="nav-btn"><i class="fa fa-bars fa-lg white"></i></a>
          <a href="#" class="navbar-icon pull-right visible-xs" id="sidebar-toggle-btn"><i class="fa fa-check-square fa-lg white"></i></a>
        </div>
        <a class="navbar-brand" href="#">NYCCSC</a>
      </div>
      <div class="navbar-collapse collapse">
        <form class="navbar-form navbar-right" role="search">
          <div class="form-group has-feedback navbar-right">
              <input id="searchbox" type="text" placeholder="Search Places" class="form-control">
              <span id="searchicon" class="fa fa-search form-control-feedback"></span>
          </div>
        </form>
        <ul class="nav navbar-nav">
          <!-- <li><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="about-btn"><i class="fa fa-question-circle white"></i>&nbsp;&nbsp;About</a></li> -->
          <li class="dropdown">
            <a id="toolsDrop" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-globe white"></i>&nbsp;&nbsp;Tools <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="full-extent-btn"><i class="fa fa-arrows-alt"></i>&nbsp;&nbsp;Zoom To Full Extent</a></li>
              <!-- <li><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="legend-btn"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;Show Legend</a></li>
              <li class="divider hidden-xs"></li> -->
              <li><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="login-btn"><i class="fa fa-user"></i>&nbsp;&nbsp;Login</a></li>
            </ul>
          </li>
          <li class="hidden-xs"><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="wmsSlider-btn"><i class="fa fa-check-square white"></i>&nbsp;&nbsp;WMS Slider</a></li>
          <li class="hidden-xs"><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="list-btn"><i class="fa fa-check-square white"></i>&nbsp;&nbsp;Layer Selector</a></li>
        </ul>
      </div><!--/.navbar-collapse -->
    </div>

    <div id="container">
      <div id="sidebar">
        <div class="sidebar-wrapper">
          <div class="panel panel-default" id="features">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-check-square fa-sm black"></i>&nbsp;&nbsp;Layer Selector
              <button type="button" class="btn btn-xs btn-default pull-right" id="sidebar-hide-btn"><i class="fa fa-chevron-left"></i></button></h3>
            </div>
            <div class="panel-body" id="sidebar-body">

                <div class="row" id="sidebar-filter">
                  <div class="col-xs-5 col-md-5">
                    <h4>Sector Filter</h4>
                  </div>
                  <div class="col-xs-7 col-md-7">
                    <!-- <input type="text" class="form-control search" placeholder="Filter" /> -->
                    <div id="control" > 
                      <select type='select' class="form-control search" onchange='tocFilter(value);'>
                        <option value="sector">All Sectors</option>
                        <option value="water">Water Resources</option>
                        <option value="coastal">Coastal Zones</option>
                        <option value="ecosystems">Ecosystems</option>
                        <option value="agriculture">Agriculture</option>
                        <option value="energy">Energy</option>
                        <option value="transportation">Transportation</option>
                        <option value="communication">Tele-comunications</option>
                        <option value="health">Public Health</option>
                      </select>
                    </div>
                  </div>
                  <!--<div class="col-xs-4 col-md-4">
                     <button type="button" class="btn btn-primary pull-right sort" data-sort="feature-name" id="sort-btn"><i class="fa fa-sort"></i>&nbsp;&nbsp;Sort</button> 
                    
                  </div>-->
                </div>

                <div class="row" id="sidebar-list">
                  <div class="col-xs-12 col-md-12">
                    <div id="gisdata"></div>
                  </div>
                </div>

<!--              <div class="row clearfix">
                  <div class="col-md-12 column">   
                      <div id="gisdata"></div>
                      <div>
                         <table id="gisdata-list" class='table table-striped table-bordered table-condensed'>
                        </table>
                      </div>  
                  </div>
              </div>
                           <p>
                <div class="rows">
                  <div class="col-xs-8 col-md-8">
                    <input type="text" class="form-control search" placeholder="Filter" />
                  </div>
                  <div class="col-xs-4 col-md-4">
                    <button type="button" class="btn btn-primary pull-right sort" data-sort="feature-name" id="sort-btn"><i class="fa fa-sort"></i>&nbsp;&nbsp;Sort</button>
                  </div>
                </div>
              </p> -->
            </div>

          </div>
        </div>
      </div>
      <div id="map"></div>
    </div>
    <div id="loading">
      <div class="loading-indicator">
        <div class="progress progress-striped active">
          <div class="progress-bar progress-bar-info progress-bar-full"></div>
        </div>
      </div>
    </div>





    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Login</h4>
          </div>
          <div class="modal-body">
            <form id="contact-form">
              <fieldset>
                <div class="form-group">
                  <label for="name">Username:</label>
                  <input type="text" class="form-control" id="username">
                </div>
                <div class="form-group">
                  <label for="email">Password:</label>
                  <input type="password" class="form-control" id="password">
                </div>
              </fieldset>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" data-dismiss="modal">Login</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="featureModal" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title text-primary" id="feature-title"></h4>
          </div>
          <div class="modal-body" id="feature-info"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal" id="wmsSliderModal" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title text-primary" id="feature-title"></h4>
          </div>
          <div class="modal-body" id="wmsSlider-body">
            <p>
              <label for="amount">Regression Slope (1 month increments):</label>
              <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
            </p>
             
            <div id="slider"></div>
            <div id="slider-legend"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="attributionModal" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">
              Application by <a href='http://frontierspatial.com' target='_blank_'>frontierspatial.com</a>
            </h4>
            <h5>
              Based on <a href='http://bmcbride.github.io/bootleaf/' target='_blank_'>Bootleaf template</a> by <a href='http://bryanmcbride.com' target='_blank_'>Bryan McBride</a>
            </h5>
          </div>
          <div class="modal-body">
            <div id="attribution"></div>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script src="lib/jquery-1.11.1.min.js"></script>
    <script src="lib/jquery-ui-1.11.2.custom/jquery-ui.js"></script>
    <script src="lib/bootstrap-3.2.0/dist/js/bootstrap.min.js"></script>
    <script src="lib/typeahead.bundle.js"></script>
    <!--<script src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/1.3.0/handlebars.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js"></script>-->
    <script src="lib/leaflet-0.7.3/leaflet.js"></script>
    <script src="lib/Leaflet.markercluster-master/dist/leaflet.markercluster.js"></script>
    <script src="lib/leaflet-locatecontrol-gh-pages/src/L.Control.Locate.js"></script>
    <script src="assets/leaflet-groupedlayercontrol/leaflet.groupedlayercontrol.js"></script>
    <script type="text/javascript" src="lib/topojson-master/topojson.js"></script>
    <script type="text/javascript" src="lib/topojsonHelper.js"></script>
    <script type="text/javascript" src="lib/esri-leaflet.js"></script>
    <script type="text/javascript" src="assets/js/config.js"></script>
    <script src="assets/js/app.js"></script>
  </body>
</html>
