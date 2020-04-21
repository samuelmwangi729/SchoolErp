<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <link rel="icon" href="{{ asset('img/logo.png') }}">
  @include('layouts.head')
  <style>
  .treeview-menu li a{
      font-size: 12px !important;
      font-family: 'Times New Roman', Times, serif !important;
  }
  h1{
    font-family: 'Times New Roman', Times, serif !important;
  }
  </style>
<body class="skin-black">
  <header class="header">
    <a class="navbar-brand logo" style="color:#f04d0c;font-weight:bold" href="{{route('index')}}">
        {{-- <img src="img/logo.png" alt="logo"> --}}
        {{ config('app.name') }}
     </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation" style="background-color: #ededed!important">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                         <!-- User Account: style can be found in dropdown.less -->
                <no-print class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user-circle"></i>
                        <span style="font-family:'Times New Roman', Times, serif">  {{Auth::user()->name}} <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                        <img src="{{asset('img/avatar3.png')}}" class="img-circle" alt="User Image" />
                            <p>
                                {{Auth::user()->username}}
                                <small>Member since:  {{ (Auth::user()->created_at)->toFormatteddateString() }}</small>
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
                                <a href="/Account/Status" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" >Sign out</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </no-print>
            </ul>
        </div>
    </nav>
</header>
@if(false)

@else
<div class="wrapper row-offcanvas row-offcanvas-left">
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="left-side sidebar-offcanvas" style="background-color:#2f3541 !important">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
              <div class="pull-left image">
              <img src="{{asset('img/avatar3.png')}}" class="img-circle" alt="User Image" />
              </div>
              <div class="pull-left info">
              <p style="font-family: 'Times New Roman', Times, serif; font-size:10px;color:#db5518">Hello, {{Auth::user()->username}}</p>

                  <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
              </div>
          </div>
          <!-- search form -->
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" style="font-family: 'Times New Roman', Times, serif; font-size:12px">
            <li class="active">
                <a href="/home">
                    <i class="fa fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
            </li>
            <li class="nav-link">
                <a href="{{ route('Ses.index') }}">
                    <i class="fa fa-cog"></i> <span>Manage Sessions</span>
            </a>
            </li>
            <li class="nav-link">
                <a href="{{ route('parents.index') }}">
                    <i class="fa fa-baby-carriage"></i> <span>Parents</span>
            </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user-graduate"></i>
                    <span>Students</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="font-size:12px">
                      <li><a href="{{route('students.add')}}"><i class="fa fa-plus"></i> Add Student</a></li>
                      <li><a href="{{route('students.all')}}"><i class="fa fa-users"></i> View Students</a></li>
                </ul>
            </li>
            <li class="nav-link">
                <a href="{{ route('syllabus.index') }}">
                    <i class="fa fa-cog"></i> <span>Syllabus</span>
            </a>
            </li>
            <li class="nav-link">
                <a href="{{ route('teachers.index') }}">
                    <i class="fa fa-users"></i> <span>Teachers</span>
            </a>
            </li>
            <li class="nav-link">
                <a href="{{ route('staff.index') }}">
                    <i class="fa fa-users"></i> <span>School Staff</span>
            </a>
            </li>
            <li class="nav-link">
                <a href="{{ route('class.index') }}">
                    <i class="fa fa-university"></i> <span>Classes</span>
            </a>
            </li>
            <li class="nav-link">
                <a href="{{ route('dorm.index') }}">
                    <i class="fa fa-building"></i> <span>Dorms</span>
            </a>
            </li>
            <li class="/nav-link">
                <a href="/home">
                    <i class="fa fa-id-card"></i> <span>Id Cards</span>
            </a>
            </li>
            <li class="nav-link">
                <a href="{{ route('clubs.index') }}">
                    <i class="fa fa-users-cog"></i> <span>Clubs</span>
            </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money-check"></i>
                    <span>Fees</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="font-size:12px">
                      <li><a href="{{route('voteheads')}}"><i class="fa fa-vote-yea"></i>Voteheads</a></li>
                      <li><a href="{{route('fees.index')}}"><i class="fa fa-plus"></i> Set Fees</a></li>
                      <li><a href="{{route('fees.balances')}}"><i class="fa fa-digital-tachograph"></i> View Balances</a></li>
                      <li><a href="{{route('index')}}"><i class="fa fa-eye"></i> View Subjects</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-credit-card"></i>
                    <span>Payments</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="font-size:12px">
                      <li><a href="{{route('index')}}"><i class="fa fa-plus"></i> Add Subject</a></li>
                      <li><a href="{{route('index')}}"><i class="fa fa-times-circle"></i> Manage Subjects</a></li>
                      <li><a href="{{route('index')}}"><i class="fa fa-eye"></i> View Subjects</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book-reader"></i>
                    <span>Exams</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                      <li><a href="{{route('index')}}"><i class="fa fa-plus"></i> Add Subject</a></li>
                      <li><a href="{{route('index')}}"><i class="fa fa-times-circle"></i> Manage Subjects</a></li>
                      <li><a href="{{route('index')}}"><i class="fa fa-eye"></i> View Subjects</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-barcode"></i>
                    <span>Exam Results</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                      <li><a href="{{route('index')}}"><i class="fa fa-plus"></i> Add Subject</a></li>
                      <li><a href="{{route('index')}}"><i class="fa fa-times-circle"></i> Manage Subjects</a></li>
                      <li><a href="{{route('index')}}"><i class="fa fa-eye"></i> View Subjects</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>Subjects</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                      <li><a href="{{route('index')}}"><i class="fa fa-plus"></i> Add Subject</a></li>
                      <li><a href="{{route('index')}}"><i class="fa fa-times-circle"></i> Manage Subjects</a></li>
                      <li><a href="{{route('index')}}"><i class="fa fa-eye"></i> View Subjects</a></li>
                </ul>
            </li>

          </ul>
      </section>
      <!-- /.sidebar -->
  </aside>

  <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div style="overflow:hidden">
          <main class="py-4" style="font-family: 'Times New Roman', Times, serif; font-size:12px">
              @yield('content')
              {{-- <router-view></router-view> --}}
          </main>
      </div>
      </section><!-- /.content -->
  </aside><!-- /.right-side -->
</div>
@endif
</div>
    @include('layouts.js')

</body>
</html>
