<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">


                @if (Auth::check())
                @if (Auth::user()->getFirstMedia('user-profile'))
                <img src="{{Auth::user()->getFirstMedia('user-profile')->getUrl()}}" class="user-image img-circle elevation-2"
                    alt="User Image">
                @else
                <img src="{{asset('upload/img/avatar/default-avatar.png')}}" class="user-image img-circle elevation-2"
                    alt="User Image">
                @endif

                @else
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>

                @endif

                @if (Auth::check())
                <span class="d-none d-md-inline">{{Auth::user()->full_name}}</span>

                @endif
            </a>

            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    @if (Auth::check())
                    @if (Auth::user()->getFirstMedia('user-profile'))
                    <img src="{{Auth::user()->getFirstMedia('user-profile')->getUrl()}}" class="img-circle elevation-2" alt="User Image">
                    @else
                    <img src="{{asset('upload/img/avatar/default-avatar.png')}}" class="img-circle elevation-2"
                        alt="User Image">
                    @endif
                    @endif


                    @if (Auth::check())
                    <p>
                        {{Auth::user()->full_name}}
                        <small>{{Auth::user()->email}}</small>
                    </p>
                    @endif

                </li>

                <li class="user-footer">
                    <a href="{{ url('profile') }}" class="btn btn-default btn-flat">Profile</a>

                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();" class="btn btn-default btn-flat float-right">Sign
                        out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
