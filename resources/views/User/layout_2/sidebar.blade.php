
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}" style="height: 6rem;">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="{{ asset('img/Logo-removebg.png') }}" alt="" style="max-height: 80px; width: auto;">
        </div>
    </a>


    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('scan') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Scanfood</span></a>
    </li>
     <!-- Nav Item - Dashboard -->
     <li class="nav-item active">
        <a class="nav-link" href="{{ route('history') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Angka Kecukupan gizi</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>



</ul>
<!-- End of Sidebar -->
