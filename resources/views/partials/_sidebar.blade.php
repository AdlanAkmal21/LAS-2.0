<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <p class="brand-link bg-primary d-flex justify-content-center align-items-center">
        <i class="fas fa-laptop-code elevation-3"></i>
        <span class="brand-text font-weight-bolder mx-3">IGS PROTECH</span>
    </p>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item mt-1">
                    <a @if(Auth::user()->role_id == 1) href="{{ route('admin.index') }}" @else
                        href="{{ route('user.index') }}" @endif class="nav-link active">
                        <i class="nav-icon fas fa-fw fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @if (Auth::user()->role_id == 1)
                <li class="nav-header text-uppercase">Admin</li>
                <!-- Report (Admin) -->
                <li class="nav-item has-treeview mb-1">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-fw fa-chart-area"></i>
                        <p>
                            Manage Report
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('report.overview') }}" class="nav-link">
                                <i class="fas fa-chart-pie nav-icon"></i>
                                <p>Overview Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.individual') }}" class="nav-link">
                                <i class="far fa-address-card nav-icon"></i>
                                <p>Individual Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.application') }}" class="nav-link">
                                <i class="far fa-chart-bar nav-icon"></i>
                                <p>Application Report</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Manage Employees (Admin) -->
                <li class="nav-item has-treeview mb-1">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Manage Employees
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.create') }}" class="nav-link">
                                <i class="fas fa-user-plus nav-icon"></i>
                                <p>Add Employee</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.employee_list') }}" class="nav-link">
                                <i class="fas fa-address-book nav-icon"></i>
                                <p>Employee List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Manage Applications (Admin) -->
                <li class="nav-item has-treeview mb-1">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>
                            Manage Applications
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.application_list') }}" class="nav-link">
                                <i class="fas fa-book nav-icon"></i>
                                <p>Applications List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Manage Leave (Admin) -->
                <li class="nav-item mb-1">
                    <a href="{{ route('leave_management.index') }}" class="nav-link">
                        <i class="nav-icon far fa-file"></i>
                        <p>
                            Manage Leave
                        </p>
                    </a>
                </li>

                <!-- Manage Holidays (Admin) -->
                <li class="nav-item has-treeview mb-1">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Manage Holidays
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('holiday.create') }}" class="nav-link">
                                <i class="far fa-calendar-plus nav-icon"></i>
                                <p>Add Holiday</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('holiday.index') }}" class="nav-link">
                                <i class="fas fa-calendar-week nav-icon"></i>
                                <p>Holiday List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Manage Files (Admin) -->
                <li class="nav-item has-treeview mb-1">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-file-pdf"></i>
                        <p>
                            Manage Files
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('file.index') }}" class="nav-link">
                                <i class="far fa-folder-open nav-icon"></i>
                                <p>File List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Manage WFH (Admin) -->
                <li class="nav-item has-treeview mb-1">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-laptop-house"></i>
                        <p>
                            Manage WFH
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.admin_user_log_index') }}" class="nav-link">
                                <i class="nav-icon fas fa-briefcase"></i>
                                <p>User Logs</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Manage Office (Admin) -->
                <li class="nav-item has-treeview mb-1">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Manage Office
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.admin_office_index') }}" class="nav-link">
                                <i class="nav-icon fas fa-briefcase"></i>
                                <p>Office Logs</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                <li class="nav-header text-uppercase">Employee</li>

                <!-- Manage Employee Details (Users) -->
                <li class="nav-item has-treeview mb-1">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-id-card"></i>
                        <p>
                            Manage Account
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.show', Auth::id())}}" class="nav-link">
                                <i class="fas fa-id-card-alt nav-icon"></i>
                                <p>Employee Details</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reset.view')}}" class="nav-link">
                                <i class="fas fa-key nav-icon"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Apply Leave (Users)-->
                <li class="nav-item mb-1">
                    <a href="{{ route('application.create')}}" class="nav-link">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p>
                            Apply Leave
                        </p>
                    </a>
                </li>

                <!-- Manage Applications (Users) -->
                <li class="nav-item has-treeview mb-1">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>
                            Manage Applications
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('application.index') }}" class="nav-link">
                                <i class="fas fa-book nav-icon"></i>
                                <p>Applications List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Work From Home (Users)-->
                <li class="nav-item mb-1">
                    <a href="{{ route('user_log.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-laptop-house"></i>
                        <p>
                            Work From Home
                        </p>
                    </a>
                </li>

                <!-- Office -->
                <li class="nav-item mb-1">
                    <a href="{{ route('office.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Office</p>
                    </a>
                </li>
                @endif

                @if (Auth::user()->role_id == 3)
                <li class="nav-header text-uppercase">Approver</li>

                <!-- Manage Applicants (Approver) -->
                <li class="nav-item has-treeview mb-1">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>
                            Manage Applicants
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('approver.approver_list') }}" class="nav-link">
                                <i class="fas fa-book nav-icon"></i>
                                <p>Pending Application List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('approver.applicant_list') }}" class="nav-link">
                                <i class="fas fa-book nav-icon"></i>
                                <p>Applicants List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @endif

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
