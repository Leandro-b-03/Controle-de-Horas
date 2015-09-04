<!DOCTYPE html>
<html lang="pt_BR">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>
    	@section('title')
      @show
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    {!! Html::style("library/adminLTE/bootstrap/css/bootstrap.min.css") !!}
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Select2 -->
    {!! Html::style("library/adminLTE/plugins/select2/select2.min.css") !!}
    <!-- PNotify -->
    {!! Html::style("library/adminLTE/plugins/pnotify/src/pnotify.core.css") !!}
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    {!! Html::style("library/adminLTE/dist/css/skins/_all-skins.min.css") !!}
    {!! Html::style("library/adminLTE/dist/css/skins/skin-yellow-light.min.css") !!}
    <!-- iCheck -->
    {!! Html::style("library/adminLTE/plugins/iCheck/square/yellow.css") !!}
    {!! Html::style("library/adminLTE/plugins/iCheck/flat/yellow.css") !!}
    <!-- Theme style -->
    {!! Html::style("library/adminLTE/dist/css/AdminLTE.min.css") !!}
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    {!! Html::style("library/adminLTE/dist/css/skins/_all-skins.min.css") !!}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @section('style')
    @show
    <!-- Custom style -->
    {!! Html::style("library/adminLTE/custom/custom.css") !!}
  </head>
  @if(Auth::user()->settings()->getResults())
  <body class="{!! Auth::user()->settings()->getResults()->skin ? Auth::user()->settings()->getResults()->skin : 'skin-yellow' !!} {!! Auth::user()->settings()->getResults()->boxed ? Auth::user()->settings()->getResults()->boxed : '' !!} {!! Auth::user()->settings()->getResults()->sidebar_toggle ? Auth::user()->settings()->getResults()->sidebar_toggle : '' !!} sidebar-mini">
  @else
  <body class="skin-yellow sidebar-mini">
  @endif
    <!-- Site wrapper -->
    <div class="wrapper">
      <div class="notification"></div>
      <header class="main-header">
        <!-- Logo -->
        <a href="{!! URL::to('/') !!}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>SV</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>SVL</b>abs</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-success message-count">4</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 4 messages</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li><!-- start message -->
                        <a href="#">
                          <div class="pull-left">
                            <img src="{!! (Auth::user() ? URL::to(Auth::user()->photo) : '') !!}" class="img-circle" alt="User Image"/>
                          </div>
                          <h4>
                            Support Team
                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li><!-- end message -->
                    </ul>
                  </li>
                  <li class="footer"><a href="#">{!! Lang::get('general.all-messages') !!}</a></li>
                </ul>
              </li>
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning notification-count">{!! Auth::user()->getNotifications()->unseen()->get()->count() != 0 ? Auth::user()->getNotifications()->unseen()->get()->count() : '' !!}</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">{!! Lang::choice('general.navbar-notification', Auth::user()->getNotifications()->unseen()->get()->count(), ['count' => Auth::user()->getNotifications()->unseen()->get()->count() ]) !!}</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      @foreach (Auth::user()->getNotifications()->orderBy('created_at', 'desc')->get() as $notification)
                      <li>
                        <a href="{!! $notification->href !!}">
                          <i class="fa fa-{!! $notification->faicon !!} text-aqua"></i> {!! $notification->message !!}
                        </a>
                      </li>
                      @endforeach
                    </ul>
                  </li>
                  <li class="footer"><a href="#">{!! Lang::get('general.all-notifications') !!}</a></li>
                </ul>
              </li>
              <!-- Tasks: style can be found in dropdown.less -->
              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-danger tasks-count">9</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 9 tasks</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li><!-- Task item -->
                        <a href="#">
                          <h3>
                            Design some buttons
                            <small class="pull-right">20%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">20% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li><!-- end task item -->
                    </ul>
                  </li>
                  <li class="footer">
                    <a href="#">{!! Lang::get('general.all-tasks') !!}</a>
                  </li>
                </ul>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{!! (Auth::user() ? URL::to(Auth::user()->photo) : '') !!}" class="user-image" alt="User Image"/>
                  <span class="hidden-xs">{!! Auth::user()->first_name !!} {!! Auth::user()->last_name !!}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="{!! (Auth::user() ? URL::to(Auth::user()->photo) : '') !!}" class="img-circle" alt="User Image" />
                    <p>
                      {!! Auth::user()->first_name !!} {!! Auth::user()->last_name !!} - Web Developer
                      <small>{!! Lang::get('general.member-since', ['month-year' => date('F \d\e Y', strtotime(Auth::user()->created_at))]) !!}</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  {{-- <li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </li> --}}
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{!! URL::to('profile/' . Auth::user()->id) !!}" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="{!! URL::to('auth/logout') !!}" class="btn btn-danger btn-flat">Sair da Sessão</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>

      <!-- =============================================== -->

      <!-- Left side column. contains the sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{!! (Auth::user() ? URL::to(Auth::user()->photo) : '') !!}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p>{!! Auth::user()->first_name !!} {!! Auth::user()->last_name !!}</p>

              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          @include('general.menu')
          {{--  --}}
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          @yield('content')
          <div id="filemanager" class="modal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Gerenciador de arquivos</h4>
                </div>
                <div class="modal-body">
                  <iframe id="filemanager-iframe" src="{{ URL::to('/') }}/filemanager/dialog.php?type=1&field_id=photo"></iframe>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <div id="chat-line" class="row">
      </div>
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Versão</b> {!! Config::get('app.app_version') !!}
        </div>
        <strong>Copyright &copy; 2015 <a href="http://www.svlabs.com.br">SVLabs</a>.</strong> Todos os direitos reservados.
      </footer>
      
			<!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-{!! (Auth::user()->settings()->getResults() ? (Auth::user()->settings()->getResults()->right_sidebar_white == 'true' ? 'light' : 'dark') : 'dark') !!}">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                    <p>Will be 23 on April 24th</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-user bg-yellow"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                    <p>New phone +1(800)555-1234</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                    <p>nora@example.com</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-file-code-o bg-green"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                    <p>Execution time 5 seconds</p>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Update Resume
                    <span class="label label-success pull-right">95%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Laravel Integration
                    <span class="label label-warning pull-right">50%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Back End Framework
                    <span class="label label-primary pull-right">68%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

          </div><!-- /.tab-pane -->

          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Some information about this general settings option
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Allow mail redirect
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Other sets of options are available
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Expose author name in posts
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Allow the user to show his name in blog posts
                </p>
              </div><!-- /.form-group -->

              <h3 class="control-sidebar-heading">Chat Settings</h3>

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Show me as online
                  <input type="checkbox" class="pull-right" checked>
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Turn off notifications
                  <input type="checkbox" class="pull-right">
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Delete chat history
                  <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                </label>
              </div><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>
      @extends('general.chat')
      @show
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    {!! Html::script("library/adminLTE/plugins/jQuery/jQuery-2.1.4.min.js") !!}
    <!-- Pusher -->
    {!! Html::script("//js.pusher.com/3.0/pusher.min.js") !!}

    <!-- Bootstrap 3.3.2 JS -->
    {!! Html::script("library/adminLTE/bootstrap/js/bootstrap.min.js") !!}
    <!-- FastClick -->
    {!! Html::script("library/adminLTE/plugins/fastclick/fastclick.min.js") !!}
    <!-- AdminLTE App -->
    {!! Html::script("library/adminLTE/dist/js/app.min.js") !!}
    <!-- SlimScroll -->
    {!! Html::script("library/adminLTE/plugins/slimScroll/jquery.slimscroll.min.js") !!}
    <!-- iCheck -->
    {!! Html::script("library/adminLTE/plugins/iCheck/icheck.min.js") !!}
    <!-- Select2 -->
    {!! Html::script("library/adminLTE/plugins/select2/select2.full.min.js") !!}
    <!-- PNotify -->
    {!! Html::script("library/adminLTE/plugins/pnotify/src/pnotify.core.js") !!}
    <!-- jQuery-Play-sound -->
    {!! Html::script("library/adminLTE/plugins/jquery-play-sound/jquery.playSound.js") !!}
    @section('scripts')
    @show
    <script>
    	var settings = {!! Auth::user()->settings()->getResults() ? '$.parseJSON(' . Auth::user()->settings()->getResults() . ')' : '{}' !!};

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN':'{!! csrf_token() !!}'
          }
      });

      var user = $.parseJSON('{!! Auth::user() !!}');

      var dataTableLang = [];

      dataTableLang.processing = "{!! Lang::get('general.dataTable-processing') !!}"
      dataTableLang.search = "{!! Lang::get('general.dataTable-search') !!}"
      dataTableLang.lengthMenu = "{!! Lang::get('general.dataTable-lengthMenu') !!}"
      dataTableLang.info = "{!! Lang::get('general.dataTable-info') !!}"
      dataTableLang.infoEmpty = "{!! Lang::get('general.dataTable-infoEmpty') !!}"
      dataTableLang.infoFiltered = "{!! Lang::get('general.dataTable-infoFiltered') !!}"
      dataTableLang.infoPostFix = "{!! Lang::get('general.dataTable-infoPostFix') !!}"
      dataTableLang.loadingRecords = "{!! Lang::get('general.dataTable-loadingRecords') !!}"
      dataTableLang.zeroRecords = "{!! Lang::get('general.dataTable-zeroRecords') !!}"
      dataTableLang.emptyTable = "{!! Lang::get('general.dataTable-emptyTable') !!}"
      dataTableLang.paginate_first = "{!! Lang::get('general.dataTable-paginate_first') !!}"
      dataTableLang.paginate_previous = "{!! Lang::get('general.dataTable-paginate_previous') !!}"
      dataTableLang.paginate_next = "{!! Lang::get('general.dataTable-paginate_next') !!}"
      dataTableLang.paginate_last = "{!! Lang::get('general.dataTable-paginate_last') !!}"
    </script>
    <!-- Custom PusherChatWidget.js -->
    {!! Html::script("library/adminLTE/custom/CustomPusherChatWidget.js") !!}
    <!-- Dashboard -->
    <!-- {!! Html::script("library/adminLTE/dist/js/demo.js") !!} -->
    <!-- Dashboard -->
    {!! Html::script("library/adminLTE/custom/demo.js") !!}
    <!-- Custom script -->
    {!! Html::script("library/adminLTE/custom/custom.js") !!}
  </body>
</html>