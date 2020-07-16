@extends('layouts.app',['current' => 'circulars'])
@section('content')

               <!-- START PAGE CONTAINER -->
               <div class="page-container">

                    
                    <!-- PAGE CONTENT -->
                    <div class="page-content">
                        
                        <!-- START X-NAVIGATION VERTICAL -->
                        <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                            <!-- TOGGLE NAVIGATION -->
                            <li class="xn-icon-button">
                                <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                            </li>
                            <!-- END TOGGLE NAVIGATION -->
                            <!-- SEARCH -->
                            <li class="xn-search">
                                <form role="form">
                                    <input type="text" name="search" placeholder="Buscar..."/>
                                </form>
                            </li>
                            <!-- END SEARCH -->
                            <!-- SIGN OUT -->
                            <li class="xn-icon-button pull-right">
                                <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
                            </li> 
                            <!-- END SIGN OUT -->
                            <!-- MESSAGES -->
                            <li class="xn-icon-button pull-right">
                                <a href="#"><span class="fa fa-comments"></span></a>
                                <div class="informer informer-danger">0</div>
                                <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><span class="fa fa-comments"></span> Messages</h3>                                
                                        <div class="pull-right">
                                            <span class="label label-danger">4 new</span>
                                        </div>
                                    </div>
                                    <div class="panel-body list-group list-group-contacts scroll" style="height: 200px;">
                                        <a href="#" class="list-group-item">
                                            <div class="list-group-status status-online"></div>
                                            <img src="assets/images/users/user2.jpg" class="pull-left" alt="John Doe"/>
                                            <span class="contacts-title"></span>
                                            <p></p>
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <div class="list-group-status status-away"></div>
                                            <img src="assets/images/users/user.jpg" class="pull-left" alt="Dmitry Ivaniuk"/>
                                            <span class="contacts-title"></span>
                                            <p></p>
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <div class="list-group-status status-away"></div>
                                            <img src="assets/images/users/user3.jpg" class="pull-left" alt="Nadia Ali"/>
                                            <span class="contacts-title"></span>
                                            <p>Mauris vel eros ut nunc rhoncus cursus sed</p>
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <div class="list-group-status status-offline"></div>
                                            <img src="assets/images/users/user6.jpg" class="pull-left" alt="Darth Vader"/>
                                            <span class="contacts-title"></span>
                                            <p>I want my money back!</p>
                                        </a>
                                    </div>     
                                    <div class="panel-footer text-center">
                                        <a href="pages-messages.html">Show all messages</a>
                                    </div>                            
                                </div>                        
                            </li>
                            <!-- END MESSAGES -->
                            <!-- TASKS -->
                            <li class="xn-icon-button pull-right">
                                <a href="#"><span class="fa fa-tasks"></span></a>
                                <div class="informer informer-warning">0</div>
                                <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><span class="fa fa-tasks"></span> Tasks</h3>                                
                                        <div class="pull-right">
                                            <span class="label label-warning">3 active</span>
                                        </div>
                                    </div>
                                    <div class="panel-body list-group scroll" style="height: 200px;">                                
                                        <a class="list-group-item" href="#">
                                            <strong>Phasellus augue arcu, elementum</strong>
                                            <div class="progress progress-small progress-striped active">
                                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">50%</div>
                                            </div>
                                            <small class="text-muted">, 25 Sep 2014 / 50%</small>
                                        </a>
                                        <a class="list-group-item" href="#">
                                            <strong>Aenean ac cursus</strong>
                                            <div class="progress progress-small progress-striped active">
                                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">80%</div>
                                            </div>
                                            <small class="text-muted">, 24 Sep 2014 / 80%</small>
                                        </a>
                                        <a class="list-group-item" href="#">
                                            <strong>Lorem ipsum dolor</strong>
                                            <div class="progress progress-small progress-striped active">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%;">95%</div>
                                            </div>
                                            <small class="text-muted">, 23 Sep 2014 / 95%</small>
                                        </a>
                                        <a class="list-group-item" href="#">
                                            <strong>Cras suscipit ac quam at tincidunt.</strong>
                                            <div class="progress progress-small">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
                                            </div>
                                            <small class="text-muted">, 21 Sep 2014 /</small><small class="text-success"> Done</small>
                                        </a>                                
                                    </div>     
                                    <div class="panel-footer text-center">
                                        <a href="pages-tasks.html">Show all tasks</a>
                                    </div>                            
                                </div>                        
                            </li>
                            <!-- END TASKS -->
                        </ul>
                        <!-- END X-NAVIGATION VERTICAL -->                     
        
                        <!-- START BREADCRUMB -->
                        <ul class="breadcrumb">
                            <li><a href="#">Menu</a></li>                    
                            <li class="active">Dashboard</li>
                        </ul>
                        <!-- END BREADCRUMB -->                       
                        
                                    
                                   <!-- START CONTENT FRAME -->
                                <div class="content-frame">
                                    
                                    <!-- START CONTENT FRAME TOP -->
                                    <div class="content-frame-top">                        
                                        <div class="page-title">                    
                                            <h2><span class="fa fa-arrow-circle-o-left"></span> Linha do tempo</h2>
                                        </div>                                      
                                        <div class="pull-right">
                                            <button class="btn btn-{{Auth::user()->css}} content-frame-right-toggle"><span class="fa fa-bars"></span></button>
                                        </div>                        
                                    </div>
                                    <!-- END CONTENT FRAME TOP -->
                                    
                                    <!-- START CONTENT FRAME LEFT -->
                                    <div class="content-frame-right">
                                        <div class="panel panel-{{Auth::user()->css}}">
                                            <div class="panel-body">
                                                <h3 class="push-up-0">Noticias Recentes </h3>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END CONTENT FRAME LEFT -->
                                    
                                    <!-- START CONTENT FRAME BODY -->
                                    <div class="content-frame-body content-frame-body-left">
                                        <div class="panel panel-{{Auth::user()->css}}">
                                           
                                                
        <!-- START TIMELINE -->
        <div class="page-content-wrap" style='background-color:#f5f5f5 '>

            <!-- START TIMELINE ITEM -->                                  
            <ul type='none'>
                <!-- START TIMELINE -->
                <div class="timeline timeline-right">
                                
                    

                    @foreach($circulares as $circular)
                        <p>{{$circular->name}}</p>
                    @endforeach
                                                   
                    <!-- END TIMELINE ITEM -->
                </div>
            </ul>

        <div>
        <!-- END TIMELINE --> 


                                            
                                        </div>
                                    </div>
                                    <!-- END CONTENT FRAME BODY -->
                                </div>
                                <!-- END CONTENT FRAME -->
                                    
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8">
                              
                                </div>
                                <div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-content">
                                        <ul class="list-inline item-details">
                                            <li><a href="http://themifycloud.com/downloads/janux-premium-responsive-bootstrap-admin-dashboard-template/">Admin templates</a></li>
                                            <li><a href="http://themescloud.org">Bootstrap themes</a></li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                             
                                </div>
                            </div>
                            
                            <!-- START DASHBOARD CHART -->
                            <div class="chart-holder" id="dashboard-area-1" style="height: 200px;"></div>
                            <div class="block-full-width">
                                                                               
                            </div>                    
                            <!-- END DASHBOARD CHART -->
                            
                        </div>
                        <!-- END PAGE CONTENT WRAPPER -->                                
                    </div>            
                    <!-- END PAGE CONTENT -->
                </div>
                <!-- END PAGE CONTAINER -->
        
                <!-- MESSAGE BOX-->
                <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
                    <div class="mb-container">
                        <div class="mb-middle">
                            <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                            <div class="mb-content">
                                <p>Are you sure you want to log out?</p>                    
                                <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                            </div>
                            <div class="mb-footer">
                                <div class="pull-right">
                                    <a href="pages-login.html" class="btn btn-success btn-lg">Yes</a>
                                    <button class="btn btn-{{Auth::user()->css}} btn-lg mb-control-close">No</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END MESSAGE BOX-->
@endsection
