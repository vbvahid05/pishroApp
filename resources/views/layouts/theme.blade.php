<!DOCTYPE html>
@inject('PublicClass','App\Mylibrary\PublicClass')
<html>
<head>
    @include('layouts.parts.head')
    <meta charset="UTF-8">
    <title>AdminLTE 2 | Dashboard</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/dist/css/AdminLTE.css">
    <link rel="stylesheet" href="/dist/css/skins/skin-blue.min.css">
    <link rel="stylesheet" href="/dist/css/bootstrap-rtl.min.css">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">
        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>P</b>DS</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>P</b>ISHRO  </span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <!-- inner menu: contains the messages -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <!-- User Image -->
                                                <img src="/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                            </div>
                                            <!-- Message title and timestamp -->
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <!-- The message -->
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li><!-- end message -->
                                </ul><!-- /.menu -->
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li><!-- /.messages-menu -->

                    <!-- Notifications Menu -->
                    <li class="dropdown notifications-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <!-- Inner Menu: contains the notifications -->
                                <ul class="menu">
                                    <li><!-- start notification -->
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li><!-- end notification -->
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    <!-- Tasks Menu -->
                    <li class="dropdown tasks-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>
                                <!-- Inner menu: contains the tasks -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <!-- Task title and progress text -->
                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <!-- The progress bar -->
                                            <div class="progress xs">
                                                <!-- Change the css width attribute to simulate progress -->
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li><!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="/img/avatar/{{$PublicClass->userProfileInfo()}}" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs"> {{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->

                            <!-- Menu Body -->
                            {{--<li class="user-body">--}}
                                {{--<div class="col-xs-4 text-center">--}}
                                    {{--<a href="#">Followers</a>--}}
                                {{--</div>--}}
                                {{--<div class="col-xs-4 text-center">--}}
                                    {{--<a href="#">Sales</a>--}}
                                {{--</div>--}}
                                {{--<div class="col-xs-4 text-center">--}}
                                    {{--<a href="#">Friends</a>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="/editUser" class="btn btn-default btn-flat">
                                        {{Lang::get('labels.ChangePassword')}}
                                    </a>

                                </div>
                                <div class="pull-right">
                                    <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                        {{Lang::get('labels.logOut')}}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
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
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            {{--<!-- Sidebar user panel (optional) -->--}}
            <div class="user-panel">
                <div class="pull-left image">
                    <img  src="/img/avatar/{{$PublicClass->userProfileInfo()}}"  class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p> {{ Auth::user()->name }}</p>
                    <!-- Status -->
                    {{--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>--}}
                </div>
            </div>
            {{--<div class="left-sidebar col-md-1 ">--}}
                 {{--@include('layouts.parts.sidebar')--}}
            {{--</div>--}}


            <!-- search form (Optional) -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
                </div>
            </form>
            <!-- /.search form -->

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header">HEADER</li>
                <!-- Optionally, you can add icons to the links -->

                <li>
                    <a href="{{ url('/dashboard') }}" >
                        <i class="fa fa-tachometer"></i>
                        <span> {{ Lang::get('labels.dashboard') }}</span>
                    </a>
                </li>

                <li id="custommers" class="treeview">
                    <a href="">
                        <i class="fa fa-user-circle-o"></i>
                        <span>{{ Lang::get('labels.custommers') }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul  class="treeview-menu">
                        <li><a id="custommer"      href="{{ url('/custommer') }}">     <i class="fa fa-address-card" aria-hidden="true"></i>  {{ Lang::get('labels.newCustommer') }}</a></li>
                        <li><a id="all-custommers" href="{{ url('/all-custommers') }}"><i class="fa fa-address-book" aria-hidden="true"></i>  {{ Lang::get('labels.AllCustommer') }}</a></li>
                        <li><a id="all-orgs"       href="{{ url('/all-orgs') }}">      <i class="fa fa-building" aria-hidden="true"></i>      {{ Lang::get('labels.AllOrgs') }}     </a></li>
                    </ul>
                </li>

                <li id="stockroom" class="treeview">
                    <a href="">
                        <i class="fa fa-dropbox" aria-hidden="true"></i>
                        <span>{{ Lang::get('labels.stockroom') }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul  class="treeview-menu">
                        <li><a id="allproducts"      href="{{ url('stock/allproducts') }}">          <i class="fa fa-tags" aria-hidden="true"></i>{{ Lang::get('labels.newProduct') }}</a></li>
                        <li><a id="AllOrders"        href="{{ url('stock/AllOrders') }}">            <i class="fa fa-cart-plus" aria-hidden="true"></i>{{ Lang::get('labels.allOrders') }}  </a></li>
                        <li><a id="PuttingProducts"       href="{{ url('stock/PuttingProducts') }}"> <i class="fa fa-level-down" aria-hidden="true"></i>{{ Lang::get('labels.addtoStock') }}     </a></li>
                        <li><a id="TakeOutProducts"       href="{{ url('sell/TakeOutProducts') }}">  <i class="fa fa-paper-plane-o" aria-hidden="true"></i>  {{ Lang::get('labels.outStock') }}    </a></li>
                        <li><a id="TakeOutProducts"       href="{{ url('sell/stockRequest/warranty/stockOut') }}">  <i class="fa fa-paper-plane-o" aria-hidden="true"></i>  {{ Lang::get('labels.WarrantyoutStock') }}    </a></li>

                    </ul>
                </li>

                <li id="sell" class="treeview ">
                    <a href="">
                        <i class="fa fa-diamond" aria-hidden="true"></i>
                        <span> {{ Lang::get('labels.sell') }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul  class="treeview-menu">
                        <li><a id="ProductStatusReport"      href="{{ url('sell/ProductStatusReport') }}">    <i class="fa fa-file-text" aria-hidden="true"></i>{{ Lang::get('labels.ProductStatusReport') }}</a></li>
                        <li><a id="stockRequest"             href="{{ url('sell/stockRequest') }}">           <i class="fa fa-cubes" aria-hidden="true"></i>{{ Lang::get('labels.stockRequest') }} </a></li>
                        <li><a id="stockRequest"             href="{{ url('sell/stockRequest/warranty/addRequest') }}">           <i class="fa fa-cubes" aria-hidden="true"></i>{{ Lang::get('labels.warrantyStockRequest') }} </a></li>
                        <li><a id="invoice"                  href="{{ url('sell/invoice') }}">                <i class="fa fa-money" aria-hidden="true"></i> {{ Lang::get('labels.invoice') }}  </a></li>
                    </ul>
                </li>

                <li id="financial" class="treeview">
                    <a href="">
                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                        <span> {{ Lang::get('labels.financial') }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul  class="treeview-menu">
                        <li><a href=""> ...</a></li>
                    </ul>
                </li>

                <li id="Settings" class="treeview">
                    <a href="">
                        <i class="icon settings" aria-hidden="true"></i>
                        <span> {{ Lang::get('labels.settings') }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul  class="treeview-menu">
                        <li><a id="userSetting"  href="{{ url('setting/users') }}">    <i class="fa fa-user" aria-hidden="true"></i>{{Lang::get('labels.userSetting')}} </a></li>
                    </ul>
                </li>


            </ul><!-- /.sidebar-menu -->



        </section>
        <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
           @section('content')@show
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer" style="height: 50px;">
        <!-- To the right -->
        <div class="pull-left hidden-xs">
            گروه شرکت های مهندسی پیشرو © Copyright 2017-2019
        </div>
        <!-- Default to the left -->
        {{--<strong>Copyright &copy; 2015 <a href="#">Company</a>.</strong> All rights reserved.--}}

    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="control-sidebar-home-tab">
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
                </ul><!-- /.control-sidebar-menu -->

            </div><!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
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
                </form>
            </div><!-- /.tab-pane -->
        </div>
    </aside><!-- /.control-sidebar -->
    <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.4 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/app.min.js"></script>

</body>
</html>



{{--<html>--}}
    {{--<head>--}}
    {{--@include('layouts.parts.head')--}}
    {{--</head>--}}
    {{--<body>--}}
        {{--<div class="headerBar col-md-11">--}}
        {{--@include('layouts.parts.header')--}}
        {{--</div>--}}
        {{--<div class="col-md-1 ">--}}
        {{--</div>--}}
        {{--<div class="col-md-12">--}}
        {{--<div class="content-side col-md-11">--}}
        {{--<!-- ------------ ---------- -->--}}
        {{--@section('alerts')--}}

        {{--@yield('showalerts')--}}

        {{--@show--}}

        {{--<!-- ---------------------- -->--}}

        {{--@section('content')--}}
        {{--@show--}}

        {{--@include('layouts.parts.loading')--}}
        {{--</div>--}}
        {{--<div class="left-sidebar col-md-1 ">--}}
        {{--@include('layouts.parts.sidebar')--}}
        {{--</div>--}}
        {{--</div>--}}


        {{--<div class="footer col-md-12 ">--}}

        {{--@include('layouts.parts.footer')--}}
        {{--</div>--}}
    {{--</body>--}}
{{--</html>--}}
