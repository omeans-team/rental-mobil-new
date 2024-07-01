<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <div class="sb-sidenav-menu-heading">Menu Utama</div>

                <a class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-fw fa-home"></i></div>
                    Dashboard
                </a>
                @if (Auth::user()->role_id == 1)
                    <a class="nav-link {{ request()->is('admin/setting*') ? 'active' : '' }}"
                        href="{{ route('setting.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-fw fa-user"></i></div>
                        Configurasi System
                    </a>
                @endif

                <div class="sb-sidenav-menu-heading">Addons</div>

                {{-- @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) --}}
                    <a class="nav-link {{ request()->is('admin/car*') || request()->is('admin/manufacture*') ? '' : 'collapsed' }}"
                        href="#" data-bs-toggle="collapse" data-bs-target="#collapseMobil" aria-expanded="true"
                        aria-controls="collapseMobil">
                        <div class="sb-nav-link-icon"><i class="fas fa-fw fa-user"></i></div>
                        Data Mobil
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-fw fa-angle-down"></i></div>
                    </a>
                    <div class="{{ request()->is('admin/car*') || request()->is('admin/manufacture*') ? 'collapse show' : 'collapse' }}"
                        id="collapseMobil" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link {{ request()->is('admin/car*') ? 'active' : '' }}"
                                href="{{ route('car.index') }}">Mobil</a>
                            <a class="nav-link {{ request()->is('admin/manufacture*') ? 'active' : '' }}"
                                href="{{ route('manufacture.index') }}">Merk</a>
                        </nav>
                    </div>
                {{-- @endif --}}

                <a class="nav-link {{ request()->is('admin/customer*') ? 'active' : '' }}"
                    href="{{ route('customer.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-fw fa-user"></i></div>
                    Customer
                </a>

                <a class="nav-link {{ request()->is('admin/transaction*') ? '' : 'collapsed' }}" href="#"
                    data-bs-toggle="collapse" data-bs-target="#collapseTransaksi" aria-expanded="true"
                    aria-controls="collapseTransaksi">
                    <div class="sb-nav-link-icon"><i class="fas fa-fw fa-book"></i></div>
                    Transaksi
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-fw fa-angle-down"></i></div>
                </a>
                <div class="{{ request()->routeIs('transaction.create') || request()->routeIs('transaction.index') || request()->routeIs('transaction.history') ? 'collapse show' : 'collapse' }}"
                    id="collapseTransaksi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs('transaction.create') ? 'active' : '' }}"
                            href="{{ route('transaction.create') }}">Transaksi</a>
                        <a class="nav-link {{ request()->routeIs('transaction.index') ? 'active' : '' }}"
                            href="{{ route('transaction.index') }}">List Transaksi</a>
                        <a class="nav-link {{ request()->routeIs('transaction.history') ? 'active' : '' }}"
                            href="{{ route('transaction.history') }}">Riwayat Transaksi</a>
                    </nav>
                </div>

                @if (Auth::user()->role_id == 1)
                    <a class="nav-link {{ request()->is('admin/user*') || request()->is('admin/role*') ? '' : 'collapsed' }}"
                        href="#" data-bs-toggle="collapse" data-bs-target="#collapsePengguna"
                        aria-expanded="{{ Request::is('admin/user*') || Request::is('admin/role*') ? 'true' : 'false' }}"
                        aria-controls="collapsePengguna">
                        <div class="sb-nav-link-icon"><i class="fas fa-fw fa-user"></i></div>
                        Management Pengguna
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-fw fa-angle-down"></i></div>
                    </a>
                    <div class="{{ request()->is('admin/user*') || request()->is('admin/role*') ? 'collapse show' : 'collapse' }}"
                        id="collapsePengguna" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link {{ Request::is('admin/user*') ? 'active' : '' }}"
                                href="{{ route('user.index') }}">Pengguna</a>
                            <a class="nav-link {{ Request::is('admin/role*') ? 'active' : '' }}"
                                href="{{ route('role.index') }}">Hak Akses</a>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </nav>
</div>
