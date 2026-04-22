<nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top">

    <!-- LEFT NAVBAR -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- RIGHT NAVBAR -->
    <ul class="navbar-nav ml-auto">

        <!-- FULLSCREEN -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <!-- DARK MODE -->
        <li class="nav-item">
            <a class="nav-link" href="#" id="darkModeToggle">
                <i class="fas fa-moon" id="darkModeIcon"></i>
            </a>
        </li>

        <!-- LANGUAGE DROPDOWN -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-language"></i>
                <span class="badge badge-info navbar-badge text-uppercase">EN</span>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <span class="dropdown-header">Language</span>

                <a href="#" class="dropdown-item active">
                    🇺🇸 English
                    <i class="fas fa-check float-right text-success"></i>
                </a>

                <a href="#" class="dropdown-item">
                    🇰🇭 Khmer
                </a>
            </div>
        </li>

        <!-- USER DROPDOWN -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <img src="https://via.placeholder.com/30" class="img-circle" width="30" height="30"
                    style="object-fit:cover;">
                <span class="ml-1">{{ auth()->user()->name }}</span>
                <i class="fas fa-chevron-down text-xs ml-2"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-right">

                <div class="dropdown-item text-center bg-primary text-white">
                    <strong>{{ auth()->user()->name }}</strong><br>
                    <small>{{ auth()->user()->getRoleNames()->first() }}</small>
                </div>

                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item">
                    <i class="fas fa-user-circle mr-2"></i>
                    Profile
                </a>

                <div class="dropdown-divider"></div>

                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf

                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-power-off mr-2"></i>
                        Logout
                    </button>
                </form>

            </div>
        </li>

    </ul>
</nav>
