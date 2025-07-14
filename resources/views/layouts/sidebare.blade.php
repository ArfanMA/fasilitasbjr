<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-building"></i>
        </div>
        <div class="sidebar-brand-text mx-4">Sistem Peminjaman Fasilitas</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-columns"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">Interface</div>

    <!-- Nav Item - Data Master (hanya untuk admin) -->
    @if(auth()->user()->role == 'admin')
        <li class="nav-item {{ request()->routeIs('master.ruangan.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('master.ruangan.index') }}">
                <i class="fas fa-layer-group"></i>
                <span>Data Ruangan</span>
            </a>
        </li>
    @endif

    <!-- Nav Item - Pinjam Ruangan (untuk user) -->
    @if(auth()->check() && auth()->user()->role == 'user')
        <li class="nav-item {{ request()->routeIs('transaksi.peminjaman.ruangan') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('transaksi.peminjaman.ruangan') }}">
                <i class="fas fa-fw fa-building"></i>
                <span>Pinjam Fasilitas</span>
            </a>
        </li>
    @endif

    <!-- Nav Item - Data Peminjaman (hanya untuk admin) -->
    @if(auth()->check() && auth()->user()->role == 'admin')
    <li class="nav-item {{ request()->routeIs('transaksi.admin.peminjaman.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('transaksi.admin.peminjaman.index') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Data Peminjaman</span>
        </a>
    </li>
@endif


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
