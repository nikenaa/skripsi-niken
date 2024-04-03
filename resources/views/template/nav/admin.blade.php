   <div class="header-bg">
       <!-- Navigation Bar-->
       <header id="topnav">
           <div class="topbar-main">
               <div class="container-fluid">

                   <!-- Logo-->
                   <div>
                       <a href="" class="logo">
                           <span class="logo-light">
                               <i class="mdi mdi-data-matrix-scan"></i> E-Presensi
                           </span>
                       </a>
                   </div>
                   <!-- End Logo-->

                   <div class="menu-extras topbar-custom navbar p-0">
                       <ul class="navbar-right ml-auto list-inline float-right mb-0">
                           <!-- full screen -->
                           <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                               <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                                   <i class="mdi mdi-arrow-expand-all noti-icon"></i>
                               </a>
                           </li>

                           <!-- notification -->
                           <li class="dropdown notification-list list-inline-item">
                               <div class="dropdown notification-list nav-pro-img">
                                   <a class="dropdown-toggle nav-link arrow-none nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                       <img src="{{ asset('public/assets/user/' . $admin->foto) }}" alt="user" class="rounded-circle">
                                   </a>
                                   <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                       <!-- item-->
                                       <a class="dropdown-item" href="{{ url('/admin/' . $admin->id) }}"><i class="mdi mdi-account-circle"></i> Profile</a>
                                       <div class="dropdown-divider"></div>
                                       <a class="dropdown-item text-danger btn-logout" href="{{ url('/logout') }}"><i class="mdi mdi-power text-danger"></i> Logout</a>
                                   </div>
                               </div>
                           </li>

                           <li class="menu-item dropdown notification-list list-inline-item">
                               <!-- Mobile menu toggle-->
                               <a class="navbar-toggle nav-link">
                                   <div class="lines">
                                       <span></span>
                                       <span></span>
                                       <span></span>
                                   </div>
                               </a>
                               <!-- End mobile menu toggle-->
                           </li>

                       </ul>

                   </div>
                   <!-- end menu-extras -->

                   <div class="clearfix"></div>

               </div>
               <!-- end container -->
           </div>
           <!-- end topbar-main -->

           <!-- MENU Start -->
           <div class="navbar-custom">
               <div class="container-fluid">

                   <div id="navigation">

                       <!-- Navigation Menu-->
                       <ul class="navigation-menu">

                           <li class="has-submenu">
                               <a href="{{ url('/admin/dashboard') }}"><i class="icon-accelerator"></i> Dashboard</a>
                           </li>


                           <li class="has-submenu">
                               <a href="#"><i class="icon-profile"></i> Pengguna <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                               <ul class="submenu megamenu">
                                   <li>
                                       <ul>
                                           <li><a href="{{ url('/admin/' . $admin->id) }}">Profile</a></li>
                                           <li><a href="{{ url('/admin') }}">Admin</a></li>
                                           <li><a href="{{ url('/data_karyawan') }}">Karyawan</a></li>
                                       </ul>
                                   </li>
                               </ul>
                           </li>

                           <li class="has-submenu">
                               <a href="{{ url('/data_project') }}"><i class="icon-pencil-ruler"></i> Proyek</a>
                           </li>

                           <li class="has-submenu">
                               <a href="{{ url('/data_absensi') }}"><i class="icon-todolist"></i> Absensi</a>
                           </li>

                       </ul>
                       <!-- End navigation menu -->
                   </div>
                   <!-- end #navigation -->
               </div>
               <!-- end container -->
           </div>
           <!-- end navbar-custom -->
       </header>
       <!-- End Navigation Bar-->

   </div>
   <!-- header-bg -->