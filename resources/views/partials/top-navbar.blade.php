
        <div class="top_nav">
          <div class="nav_menu">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <nav class="nav navbar-nav">
              <ul class=" navbar-right">
                <div class="dropdown ms-auto  navtopextra">
                <button class="btn btn-light position-relative dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="margin: 0px 0px 0px 84%;">
                   {{ auth()->user()->name }}
                </button>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                    <li>
                      <form method="POST" action="{{ route('logout') }}">
                          @csrf
                          <a class="dropdown-item" href="route('logout')"
                                  onclick="event.preventDefault();
                                              this.closest('form').submit();">
                                              <i class="fa fa-sign-out pull-right"></i> Log Out</a>
                      </form>
                    </li>
                 </ul>
                </div>
              </ul>
            </nav>
          </div>
        </div>