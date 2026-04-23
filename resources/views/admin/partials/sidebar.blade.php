<style>
    /* ========================================== 🎓 SAINT PAUL LMS - FULL SIDEBAR STYLE ========================================== */
    :root {
        --sidebar-width: 300px;
        --sidebar-font: 21px;
        --sidebar-sub-font: 19px;
        --sidebar-icon: 17px;
        --sidebar-sub-icon: 14px;
        --sidebar-arrow: 14px;
        --sidebar-padding-y: 10px;
        --sidebar-padding-x: 12px;
    }

    .main-sidebar {
        width: var(--sidebar-width) !important;
        font-family: 'Battambang', sans-serif !important;
    }

    .content-wrapper,
    .main-header,
    .main-footer {
        margin-left: var(--sidebar-width) !important;
    }

    .sidebar-collapse .main-sidebar {
        width: 4.6rem !important;
    }

    .sidebar-collapse .content-wrapper,
    .sidebar-collapse .main-header,
    .sidebar-collapse .main-footer {
        margin-left: 4.6rem !important;
    }

    .main-sidebar .sidebar {
        width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .main-sidebar .brand-link {
        padding: 10px 12px !important;
    }

    .main-sidebar .brand-text {
        font-size: 18px !important;
        font-weight: 500;
    }

    .main-sidebar .nav-sidebar {
        width: 100% !important;
    }

    .main-sidebar .nav-sidebar .nav-item {
        width: 100% !important;
    }

    .main-sidebar .nav-sidebar .nav-link {
        display: flex !important;
        align-items: center !important;
        width: 100% !important;
        padding: var(--sidebar-padding-y) var(--sidebar-padding-x) !important;
        transition: all 0.2s ease;
    }

    .main-sidebar .nav-sidebar .nav-icon {
        width: 30px;
        text-align: center;
        font-size: var(--sidebar-icon) !important;
        margin-right: 14px;
    }

    .main-sidebar .nav-treeview .nav-icon {
        font-size: var(--sidebar-sub-icon) !important;
    }

    .main-sidebar .nav-sidebar .nav-link p {
        flex: 1 !important;
        margin: 0 !important;
        font-size: var(--sidebar-font) !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    .main-sidebar .nav-treeview .nav-link p {
        font-size: var(--sidebar-sub-font) !important;
    }

    .main-sidebar .nav-sidebar .nav-link .right {
        margin-left: auto !important;
        font-size: var(--sidebar-arrow) !important;
        opacity: .8;
    }

    .main-sidebar .nav-treeview .nav-link {
        padding-left: 55px !important;
    }

    .nav-item.menu-open>.nav-link {
        background: rgba(255, 255, 255, 0.05);
    }

    @media (max-width: 1366px) {
        :root {
            --sidebar-font: 16px;
            --sidebar-sub-font: 15px;
        }
    }

    @media (max-width: 992px) {
        :root {
            --sidebar-font: 15px;
            --sidebar-sub-font: 14px;
        }
    }
</style>

<aside class="main-sidebar sidebar-dark-primary sidebar-fixed">

    <!-- BRAND -->
    <a href="#" class="brand-link shadow-sm"
        style="color:white; display:flex; align-items:center; padding:0.6rem 1rem;">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png"
            style="width:40px; height:35px; margin-right:10px;">
        <span class="brand-text">Student System</span>
    </a>

    <div class="sidebar">
        <nav>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

                <!-- USER PANEL -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="https://via.placeholder.com/40" class="img-circle">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Welcome: MOV VOREACH</a>
                    </div>
                </div>

                <!-- DASHBOARD -->
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- STUDENT MANAGEMENT -->
                <li class="nav-header text-uppercase">Student Management</li>

                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>
                            Students
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Student</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/student" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Student List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- TEACHERS -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>
                            Teachers
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/teachers/create" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Teacher</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('teachers.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Teacher List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- CLASS / COURSE -->
                <li class="nav-header text-uppercase">Academics</li>

                <li class="nav-item">
                    <a href="/schedule" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Schedule</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/classes" class="nav-link">
                        <i class="nav-icon fas fa-school"></i>
                        <p>Classes</p>
                    </a>
                </li>

                <!-- ATTENDANCE -->
                <li class="nav-header text-uppercase">Attendance</li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>Attendance</p>
                    </a>
                </li>

                <!-- REPORTS -->
                <li class="nav-header text-uppercase">Reports</li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Student Report</p>
                    </a>
                </li>

                <!-- USERS -->
                <li class="nav-header text-uppercase">Users</li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>User Management</p>
                    </a>
                </li>

                <!-- SETTINGS -->
                <li class="nav-header text-uppercase">System</li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Settings</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
