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
        <ul class="nav nav-pills nav-sidebar flex-column"
            data-widget="treeview"
            role="menu"
            data-accordion="false">

            @php
                $user = auth()->user();

<<<<<<< HEAD
                $profileImage = asset('backend/dist/img/user2-160x160.jpg');

                if ($user->student?->image) {
                    $profileImage = asset('storage/' . $user->student->image);
                } elseif ($user->teacher?->image) {
                    $profileImage = asset('storage/' . $user->teacher->image);
                } elseif ($user->image) {
                    $profileImage = asset('storage/' . $user->image);
                }
            @endphp

            <!-- ================= USER PANEL ================= -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                <div class="image">
                    <img src="{{ $profileImage }}"
                        class="img-circle elevation-2"
                        alt="User Image"
                        style="width:40px; height:40px; object-fit:cover;">
=======
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
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
                </div>

                <div class="info">
                    <a href="#" class="d-block text-white">
                        Welcome: {{ $user->name ?? 'User' }}
                    </a>
                </div>
            </div>

            <!-- ================================================= -->
            <!-- STUDENT & TEACHER MENU -->
            <!-- ================================================= -->
            @if ($user->hasRole('student') || $user->hasRole('teacher'))

                <li class="nav-header text-uppercase">
                    My Schedule
                </li>

                @can('view schedule')
                    <li class="nav-item">
                        <a href="{{ route('schedule.index') }}"
                            class="nav-link {{ request()->routeIs('schedule.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-book"></i>

                            <p>Schedule</p>
                        </a>
                    </li>
                @endcan

            @else

<<<<<<< HEAD
                <!-- ================================================= -->
                <!-- ADMIN MENU -->
                <!-- ================================================= -->
=======
                    @can('view class')
                        <li class="nav-item">
                            <a href="{{ route('classes.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-school"></i>
                                <p>Classes</p>
                            </a>
                        </li>
                    @endcan
                    @can('view department')
                        <li class="nav-item">
                            <a href="{{ route('departments.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-building"></i>
                                <p>Departments</p>
                            </a>
                        </li>
                    @endcan
                    @can('view subject')
                        <li class="nav-item">
                            <a href="{{ route('subjects.index') }}" class="nav-link"></a>
                                <i class="nav-icon fas fa-book-open"></i>
                                <p>Subjects</p>
                            </a>
                        </li>
                    @endcan
                @endif
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23

                @can('view dashboard')
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-home"></i>

                            <p>Dashboard</p>
                        </a>
                    </li>
                @endcan

                <!-- ================= STUDENT MANAGEMENT ================= -->
                @canany(['view student', 'create student', 'edit student'])

                    <li class="nav-header text-uppercase">
                        Student Management
                    </li>

                    <li class="nav-item has-treeview {{ request()->is('student*') ? 'menu-open' : '' }}">

                        <a href="#"
                            class="nav-link {{ request()->is('student*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-user-graduate"></i>

                            <p>
                                Students
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            @can('create student')
                                <li class="nav-item">
                                    <a href="{{ route('student.create') }}"
                                        class="nav-link {{ request()->routeIs('student.create') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>

                                        <p>Add Student</p>
                                    </a>
                                </li>
                            @endcan

                            @can('view student')
                                <li class="nav-item">
                                    <a href="{{ route('student.index') }}"
                                        class="nav-link {{ request()->routeIs('student.index') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>

                                        <p>Student List</p>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endcanany

                <!-- ================= TEACHER MANAGEMENT ================= -->
                @canany(['view teacher', 'create teacher'])

                    <li class="nav-header text-uppercase">
                        Teacher Management
                    </li>

                    <li class="nav-item has-treeview {{ request()->is('teachers*') ? 'menu-open' : '' }}">

                        <a href="#"
                            class="nav-link {{ request()->is('teachers*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-chalkboard-teacher"></i>

                            <p>
                                Teachers
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            @can('create teacher')
                                <li class="nav-item">
                                    <a href="{{ route('teachers.create') }}"
                                        class="nav-link {{ request()->routeIs('teachers.create') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>

                                        <p>Add Teacher</p>
                                    </a>
                                </li>
                            @endcan

                            @can('view teacher')
                                <li class="nav-item">
                                    <a href="{{ route('teachers.index') }}"
                                        class="nav-link {{ request()->routeIs('teachers.index') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>

                                        <p>Teacher List</p>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endcanany

                <!-- ================= ACADEMICS ================= -->
                <li class="nav-header text-uppercase">
                    Academics
                </li>

                @can('view schedule')
                    <li class="nav-item">
                        <a href="{{ route('schedule.index') }}"
                            class="nav-link {{ request()->routeIs('schedule.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-book"></i>

                            <p>Schedule</p>
                        </a>
                    </li>
                @endcan

                @can('view class')
                    <li class="nav-item">
                        <a href="{{ route('classes.index') }}"
                            class="nav-link {{ request()->routeIs('classes.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-school"></i>

                            <p>Classes</p>
                        </a>
                    </li>
                @endcan

                @can('view department')
                    <li class="nav-item">
                        <a href="{{ route('departments.index') }}"
                            class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-building"></i>

                            <p>Departments</p>
                        </a>
                    </li>
                @endcan

                @can('view subject')
                    <li class="nav-item">
                        <a href="{{ route('subjects.index') }}"
                            class="nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-book-open"></i>

                            <p>Subjects</p>
                        </a>
                    </li>
                @endcan

            @endif

        </ul>
    </nav>
</div>
</aside>
