  
  <style>
    
    .side-header .header-brand1{
        display: flex;
        justify-content: center;
        align-items: center;
        width: 75%;
    }

    .app.sidebar-mini.sidenav-toggled .side-header{
        width: 100%;
    }
    @media only screen and (max-width: 600px) {
        .header-brand-img {
        
            width: 20%;
        }
    }
  </style>
  <!-- app-Header -->
  <div class="app-header header sticky">
      <div class="container-fluid main-container">
          <div class="d-flex">
              <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
              <!-- sidebar-toggle-->
              <a class="logo-horizontal " href="{{route("admin.dashboard")}}">
                  <img src="{{asset("assets/images/brand/logo.png")}}" style="height: 50px;" class="header-brand-img desktop-logo" alt="logo">
                  <img src="{{asset("assets/images/brand/logo.png")}}" style="height: 50px;" class="header-brand-img light-logo1" alt="logo">
              </a>
              <!-- LOGO -->

              <div class="d-flex order-lg-2 ms-auto header-right-icons">
                  <!-- SEARCH -->
                  <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                  </button>
                  <div class="navbar navbar-collapse responsive-navbar p-0">
                      <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                          <div class="d-flex order-lg-2">
                            
                              <!-- COUNTRY -->
                              <div class="d-flex">
                                  <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                      <span class="dark-layout"><i class="fe fe-moon"></i></span>
                                      <span class="light-layout"><i class="fe fe-sun"></i></span>
                                  </a>
                              </div>
                              <!-- Theme-Layout -->

                              <div class="dropdown d-flex">
                                  <a class="nav-link icon full-screen-link nav-link-bg">
                                      <i class="fe fe-minimize fullscreen-button"></i>
                                  </a>
                              </div>

                              <!-- SIDE-MENU -->
                              <div class="dropdown d-flex profile-1">
                                  <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link leading-none d-flex">
                                      <img src="{{asset("assets/images/users/21.jpg")}}" alt="profile-user" class="avatar  profile-user brround cover-image">
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="
                                  left: -210%;
                              ">
                                      <div class="drop-heading">
                                          <div class="text-center">
                                              <h5 class="text-dark mb-0 fs-14 fw-semibold">{{ucfirst(Auth::guard('admin')->user()->name)}}</h5>
                                                  <small class="text-muted">{{ucfirst(Auth::guard('admin')->user()->type)}}</small>
                                          </div>
                                      </div>
                                      <div class="dropdown-divider m-0"></div>
                                        {{-- <a class="dropdown-item" href="config.php">
                                            <i class="dropdown-icon fe fe-user"></i> Configurations
                                        </a>
                                      <a class="dropdown-item" href="user_password.php">
                                          <i class="dropdown-icon fe fe-lock"></i> Password
                                      </a> --}}
                                      <a class="dropdown-item" href="{{route("admin.logout")}}">
                                          <i class="dropdown-icon fe fe-alert-circle"></i> Log out
                                      </a>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- /app-Header -->

  <!--APP-SIDEBAR-->
  <div class="sticky">
      <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
      <div class="app-sidebar">
          <div class="side-header">
              <a class="header-brand1" href="{{route("admin.dashboard")}}">
                  <img src="{{asset("assets/images/brand/logo.png")}}" style="height: 60px;" class="header-brand-img desktop-logo" alt="logo">
                  <img src="{{asset("assets/images/brand/logo.png")}}" style="height: 60px;" class="header-brand-img toggle-logo" alt="logo">
                  <img src="{{asset("assets/images/brand/logo.png")}}" style="height: 60px;" class="header-brand-img light-logo" alt="logo">
                  <img src="{{asset("assets/images/brand/logo.png")}}" style="height: 60px;" class="header-brand-img light-logo1" alt="logo">
              </a>
              <!-- LOGO -->
          </div>
          <div class="main-sidemenu">
              <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                      <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                  </svg></div>
              <ul class="side-menu">
                  <li class="sub-category">
                      <h3>Main</h3>
                  </li>
                  <li class="slide">
                      <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{route("admin.dashboard")}}"><i class="side-menu__icon fas fa-home"></i><span class="side-menu__label">Dashboard</span></a>
                  </li>
                  <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{route("admin.kitchenManager", ['view'=> 'list'])}}"><i class="side-menu__icon fas fa-user-tie"></i><span class="side-menu__label">Kitchen Managers</span></a>
                </li>
                  <li class="slide">
                      <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{route("admin.kitchen", ['view'=> 'list'])}}"><i class="side-menu__icon fas fa-utensils"></i><span class="side-menu__label">Kitchen</span></a>
                  </li>
                 
                  <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fas fa-sliders-h"></i><span class="side-menu__label">MLM Plan Setting</span><i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu" style="display: none;">
                        <li class="panel sidetab-menu">
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side9" role="tabpanel">
                                        <ul class="sidemenu-list">
                                            <li>
                                                <a class="slide-item" href="{{route("admin.plan", ['view' => 'form', 'mode'=> 'edit', 'planid'=> 1])}}"
                                                    class="side-menu__item has-link" data-bs-toggle="slide"><i
                                                        class="fas fa-cog"></i>&nbsp; Plan Setting</a>
                                            </li>
                                            <li>
                                                <a class="slide-item" href="{{route("admin.performanceBonus", ['view' => 'list'])}}"
                                                    class="side-menu__item has-link" data-bs-toggle="slide"><i
                                                        class="fas fa-user-tie"></i>&nbsp; Performance Bonus </a>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                   <li class="slide">
                      <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{route("admin.members", ['view' => 'list'])}}"><i class="side-menu__icon fas fa-users"></i><span class="side-menu__label">Members</span></a>
                  </li>
                  <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{route("admin.pincodeMaster", ['view'=> 'list'])}}"><i class="side-menu__icon fas fa-map-marker-alt"></i><span class="side-menu__label">Pincode Master</span></a>
                </li>
              

                  <li class="slide">
                      <a class="side-menu__item" data-bs-toggle="slide" href="{{route("admin.logout")}}"><i class="side-menu__icon fas fa-sign-out-alt"></i><span class="side-menu__label">Logout</span>
                      </a>

                  </li>

              </ul>
              <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                      <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                  </svg></div>
          </div>
      </div>
  </div>
  <!--/APP-SIDEBAR-->