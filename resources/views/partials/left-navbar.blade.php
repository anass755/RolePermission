<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <!-- <div class="navbar nav_title" style="border: 0;">
      <a href="index.html" class="site_title"><i class="fa fa-users" aria-hidden="true" style="margin-left:10px;"></i><span style="margin-left:10px;">XGadgets</span></a>
    </div> -->

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic">
        <img src="{{ asset('images/defaultimageauthor.avif') }}" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>Welcome,</span>
        <h2>{{ auth()->user()->name }}</h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
          <li><a><i class="fa fa-home"></i>Users<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ route('users.index') }}">Manage</a></li>
            </ul>
          </li>
          <li><a><i class="fa fa-home"></i>Roles<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ route('roles.index') }}">Manage</a></li>
            </ul>
          </li>
          <li><a><i class="fa fa-desktop"></i>Permissions Group<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ route('permissionGroup.index') }}">Manage Post</a></li>
              <li><a href=""></a></li>
            </ul>
          </li>
          <li><a><i class="fa fa-desktop"></i>Permissions <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ route('permissions.index') }}">Manage Post</a></li>
              <li><a href=""></a></li>
            </ul>
          </li>
          <li><a><i class="fa fa-home"></i>Products<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ route('products.index') }}">Manage</a></li>
            </ul>
          </li>
          
        </ul>
      </div>
      

    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
      <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
      </a>
    </div>
    <!-- /menu footer buttons -->
  </div>
</div>