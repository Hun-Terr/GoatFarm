<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">91 Goat Farm</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Statistics</li>
            <li><a class="nav-link" href={{route('dashboard')}}><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

            <li class="menu-header">Farm</li>

            <li><a class="nav-link" href={{route('goat.index')}} ><i class="fas fa-horse"></i> <span>Goats</span></a></li>
            <li><a class="nav-link" href={{route('report.index')}} ><i class="fas fa-file-invoice"></i> <span>Report</span></a></li>
            <li><a class="nav-link" href={{route('transaction.index')}} ><i class="fas fa-rupee-sign"></i> <span>Transaction</span></a></li>
            <li><a class="nav-link" href={{route('customer.index')}} ><i class="fas fa-users"></i> <span>Customer</span></a></li>

            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Upcoming</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href={{route('healthrecord.index')}} ><i class="fas fa-plus"></i> <span>Health Record</span></a></li>
                    <li><a class="nav-link" href={{route('employee.index')}} ><i class="fas fa-people-carry"></i> <span>Employee</span></a></li>

                </ul>
            </li>

            <li class="menu-header">Admin</li>

                <li><a class="nav-link" href={{route('user.index')}}><i class="fas fa-user"></i> <span>User</span></a></li>

        </ul>

              </aside>
</div>
