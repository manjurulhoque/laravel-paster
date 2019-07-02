<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">PasteR</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <a class="btn btn-success btn-sm new_paste" href="/">
                    <i class="fa fa-plus"></i> New paste
                </a>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item @if(Route::currentRouteName() == 'home') active @endif">
                        <a class="nav-link" href="{{url('/')}}">Home</a>
                    </li>
                    <li class="nav-item @if(Route::currentRouteName() == 'trending') active @endif">
                        <a class="nav-link" href="{{ route('trending') }}">Trending</a>
                    </li>

                    <li class="nav-item @if(Route::currentRouteName() == 'archives') active @endif">
                        <a class="nav-link" href="{{ route('archives') }}">Archive</a>
                    </li>

                    <li class="nav-item">
                        <form class="form-inline" method="get" action="#">
                            <div class="md-form my-0">
                                <input class="form-control mr-sm-2" name="keyword" type="text" placeholder="Search"
                                       aria-label="Search">
                            </div>
                        </form>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    @if(auth()->check())
                        <li class="nav-item btn-group @if(Route::currentRouteName() == 'my_pastes' || Route::currentRouteName() == 'profile') active @endif">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                {{auth()->user()->name}}
                                <img src="{{ auth()->user()->avatar }}"
                                     width="20" height="20" class="rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-primary"
                                 aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('my.pastes') }}">
                                    <i class="fa fa-list-alt blue-grey-text"></i> My Pastes
                                </a>
                                <a class="dropdown-item" href="{{ route('my.profile') }}">
                                    <i class="fa fa-user-circle-o blue-grey-text"></i> Edit Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out blue-grey-text"></i> Logout
                                </a>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li class="nav-item  @if(Route::currentRouteName() == 'register') active @endif">
                            <a class="nav-link" href="{{url('register')}}">Sign up</a>
                        </li>
                        <li class="nav-item @if(Route::currentRouteName() == 'login') active @endif">
                            <a class="nav-link" href="{{url('login')}}">Login</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

</header>
