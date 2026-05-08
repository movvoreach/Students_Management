<aside class="main-sidebar sidebar-dark-primary sidebar-fixed">

    <!-- BRAND -->
    <a href="{{ route('dashboard') }}" class="brand-link shadow-sm"
        style="color:white; display:flex; align-items:center; padding:0.6rem 1rem;">
        <img src="{{ asset('backend/dist/img/lms.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="width:50px; height:45px; margin-right:10px;">
        <span class="brand-text">Student System</span>
    </a>

    <div class="sidebar">
        <nav>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">
                @php
                    $user = auth()->user();

                    $profileImage = asset('backend/dist/img/user2-160x160.jpg');

                    if ($user->student && $user->student->image) {
                        $profileImage = asset('storage/' . $user->student->image);
                    } elseif ($user->teacher && $user->teacher->image) {
                        $profileImage = asset('storage/' . $user->teacher->image);
                    } elseif ($user->image) {
                        $profileImage = asset('storage/' . $user->image);
                    }
                @endphp
                <!-- USER PANEL -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ $profileImage }}" class="img-circle"
                            style="width:40px; height:35px; object-fit: cover;">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Welcome: {{ Auth::user()->name ?? 'User' }}</a>
                    </div>
                </div>

                <!-- ========================== -->
                <!-- ROLE-BASED SIDEBAR CONTROL -->
                <!-- ========================== -->
                @if (Auth::user()->hasRole('student') || Auth::user()->hasRole('teacher'))
                    <!-- ================================== -->
                    <!-- STUDENTS & TEACHERS: SHOW SCHEDULE -->
                    <!-- ================================== -->
                    <li class="nav-header text-uppercase">My Schedule</li>

                    @can('view schedule')
                        <li class="nav-item">
                            <a href="{{ route('schedule.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Schedule</p>
                            </a>
                        </li>
                    @endcan
                @else
                    <!-- ================================== -->
                    <!-- ADMIN ROLE: FULL MENU -->
                    <!-- ================================== -->

                    @can('view dashboard')
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                    @endcan

                    <!-- Student Management -->
                    @canany(['view student', 'create student', 'edit student'])
                        <li class="nav-header text-uppercase">Student Management</li>
                        <li class="nav-item has-treeview {{ request()->is('student*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>
                                    Students
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('create student')
                                    <li class="nav-item">
                                        <a href="{{ route('student.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Student</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('view student')
                                    <li class="nav-item">
                                        <a href="{{ route('student.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Student List</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany

                    <!-- Teacher Management -->
                    @canany(['view teacher', 'create teacher'])
                        <li class="nav-header text-uppercase">Teacher Management</li>
                        <li class="nav-item has-treeview {{ request()->is('teachers*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                <p>
                                    Teachers
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('create teacher')
                                    <li class="nav-item">
                                        <a href="{{ route('teachers.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Teacher</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('view teacher')
                                    <li class="nav-item">
                                        <a href="{{ route('teachers.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Teacher List</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany

                    <!-- Academics -->
                    <li class="nav-header text-uppercase">Academics</li>

                    @can('view schedule')
                        <li class="nav-item">
                            <a href="{{ route('schedule.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Schedule</p>
                            </a>
                        </li>
                    @endcan

                    @can('view class')
                        <li class="nav-item">
                            <a href="{{ route('classes.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-school"></i>
                                <p>Classes</p>
                            </a>
                        </li>
                    @endcan
                @endif

            </ul>
        </nav>
    </div>
</aside>
