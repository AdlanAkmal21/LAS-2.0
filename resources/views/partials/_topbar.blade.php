<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-primary navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        @if (Auth::user()->role_id == 1)
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.activity_log') }}">
                <i class="fas fa-clipboard-list"></i>
            </a>
        </li>
        @endif
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                @if (Auth()->user()->unreadNotifications->count() > 0)
                <span class="badge badge-warning navbar-badge">{{ Auth()->user()->unreadNotifications->count() }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">{{ Auth()->user()->unreadNotifications->count() }}
                    Notifications</span>
                <div class="dropdown-divider"></div>
                @foreach (Auth()->user()->unreadNotifications as $unreadNotification)
                @if ($unreadNotification->type == 'App\Notifications\NewApplicationAlert')
                <a href="{{ route('user.read_notifications') }}" class="dropdown-item">
                    <i class="far fa-bell mr-3"></i></i>New application
                    <span class="float-right text-muted text-sm">{{ date('H:i:sa', strtotime($unreadNotification->created_at)) }}</span>
                </a>
                @else
                <a href="{{ route('user.read_notifications') }}" class="dropdown-item">
                    <i class="far fa-envelope mr-3"></i></i>Application approval
                    <span class="float-right text-muted text-sm">{{ date('H:i:sa', strtotime($unreadNotification->created_at)) }}</span>
                </a>
                @endif

                <div class="dropdown-divider"></div>
                @endforeach
                <a href="{{ route('user.read_notifications') }}" class="dropdown-item dropdown-footer">See All
                    Notifications</a>
            </div>
        </li>

        <li class="nav-item dropdown user-menu">
            <a class="nav-link dropdown-toggle" href="#" role="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user()->name}}</span>
                <i class="fas fa-sort-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown" >
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="{{ (isset(Auth::user()->userdetail)) ? ((Auth::user()->userdetail->gender_id == 1)?asset('assets/svg/profile-male.svg'): asset('assets/svg/profile-female.svg')) : asset('assets/svg/profile-admin.svg') }}"
                        class="img-circle" alt="User Image">
                    <p class="m-0">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="m-0">
                        <small>({{ Auth::user()->refRole->role_name }})</small>
                        <small>{{ (isset(Auth::user()->userdetail)) ? ('Member since ' . date('d M. Y', strtotime(Auth::user()->userdetail->date_joined))) : '' }}</small>
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="float-left">
                        <a href="{{ route('user.show', Auth::id()) }}" class="btn btn-outline-info">Profile</a>
                    </div>
                    <div class="float-right">
                        <a href="#" class="btn btn-outline-danger" data-toggle="modal"
                            data-target="#logoutModal">Logout</a>
                    </div>
                </li>
            </ul>
        </li>

    </ul>
</nav>
<!-- /.navbar -->


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
