<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div class="d-flex align-items-center ">
        <a href="{{ route('index') }}" class="sidebar-logo ">
            <img src="{{ asset('assets/images/logo7.png') }}" alt="site logo" class="light-logo w-100 object-fit-cover">
            <img src="{{ asset('assets/images/logo9.png') }}" alt="site logo" class="dark-logo">
            <img src="{{ asset('assets/images/logo-icon.png') }}" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('index') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Dashboard </a>
                    </li>
{{--                    <li>--}}
{{--                        <a href="{{ route('index2') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Dashboard Manager</a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a href="{{ route('index3') }}"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Dashboard Admin</a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a href="{{ route('index4') }}"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Dashboard Superadmin</a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a href="{{ route('index5') }}"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Dashboard Operator</a>--}}
{{--                    </li>--}}
                </ul>
            </li>
            <li class="sidebar-menu-group-title">Application</li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Client</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('client.index') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Submit Client</a>
                    </li>
                    <li>
                        <a href="{{ route('client.list') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>List Client</a>
                    </li>

                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span >Maintenance</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('wo.list') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Work Orders</a>
                    </li>
                    <li>
                        <a href="{{ route('scheduler.list') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Scheduled Maintenance</a>
                    </li>
                    <li>
                        <a href="{{ route('task.list') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Task Group</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span >Project Management</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('project.create') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Submit Project</a>
                    </li>
                    <li>
                        <a href="{{ route('project.list') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>List Project</a>
                    </li>


                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span >Assets Management</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('asset.list') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>All Assets</a>
                    </li>
                    <li>
                        <a href="{{ route('asset.facility') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Facilites</a>
                    </li>

                    <li>
                        <a href="{{ route('equipment.list') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Equipment</a>
                    </li>
                    <li>
                        <a href="{{ route('tools.list') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Tools</a>
                    </li>

                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Inventory & Spare Parts Management</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('part.list') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Parts and Supplier</a>
                    </li>

                    <li>
                        <a href="{{ route('bom.list') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Bill of Materials Groups</a>
                    </li>

                    <li>
                        <a href="{{ route('business.list') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Business</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span >Building Permit Management</span>
                </a>
                <ul class="sidebar-submenu">



                    <li>
                        <a href="{{ route('permit.list') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>List Building Permit</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>External Worker/Contractor Management</span>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href=""><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Submit External Worker</a>
                    </li>

                    <li>
                        <a href=""><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>List Building Permit</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Procurement Management</span>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ route('purchase.list') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Puchase Request</a>
                    </li>

                    <li>
                        <a href="{{ route('receipt.list') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Receipt Management</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Energy & Utility Management</span>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('socket/list') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Configuration API Connection Monitoring</a>
                    </li>

                    <li>
                        <a href=""><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Analytics Utility Management</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Space & Occupancy Management</span>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ route('space.list') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Submit Space Occupancy</a>
                    </li>

                    <li>
                        <a href="{{ route('space.analytics') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Analytics Space Occupancy</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Report</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href=""><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Report Utility</a>
                    </li>
                    <li>
                        <a href=""><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Report Account</a>
                    </li>
                    <li>
                        <a href=""><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Report KPI Dashboard</a>
                    </li>
                    <li>
                        <a href=""><i class="ri-circle-fill circle-icon text-success-600 w-auto"></i>Report Tenant</a>
                    </li>
                    <li>
                        <a href=""><i class="ri-circle-fill circle-icon text-danger-600 w-auto"></i>Report Maintenance</a>
                    </li>
                    <li>
                        <a href=""><i class="ri-circle-fill circle-icon text-info-600 w-auto"></i>Report Security</a>
                    </li>
                    <li>
                        <a href=""><i class="ri-circle-fill circle-icon text-primary-500 w-auto"></i>Report Asset & Inventory</a>
                    </li>
                    <li>
                        <a href=""><i class="ri-circle-fill circle-icon text-secondary-600 w-auto"></i>Report Procurement</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span >Setting</span>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ route('user.list') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Users</a>
                    </li>

                    <li>
                        <a href="{{ route('groups.list') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Departement</a>
                    </li>
                    <li>
                        <a href="{{ route('division.list') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Division</a>
                    </li>
                    <li>
                        <a href="{{ route('role.list') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Role</a>
                    </li>

                    <li>
                        <a href="{{ route('activity.index') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Activity Logs</a>
                    </li>
                    <li>
                        <a href="{{ route('user.show', \Illuminate\Support\Facades\Auth::user()->id) }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>My Profile</a>
                    </li>
                    <li>
                        <a href=""><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Import</a>
                    </li>
                    <li>
                        <a href=""><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Database Export</a>
                    </li>
                    <li>
                        <a href=""><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Schedule Restore Database</a>
                    </li>
                </ul>
            </li>


        </ul>
    </div>
</aside>
