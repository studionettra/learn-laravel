<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="index.html"><img src="{{ asset('template/dist/assets/images/logo/logo.png') }}" alt="Logo"
                            srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                @php
                    // Ambil nama level user yang sedang login
                    $levelName = Auth::user()->level->level_name ?? '';
                @endphp

                <li class="sidebar-item active ">
                    <a href="{{ url('dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Penjelasan: Menu Master Data untuk Administrator dan Operator -->
                @if(in_array($levelName, ['Administrator', 'Operator']))
                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-collection-fill"></i>
                        <span>Master Data</span>
                    </a>
                    <ul class="submenu ">
                        <!-- Penjelasan: Level dan User khusus Administrator -->
                        @if($levelName === 'Administrator')
                        <li class="submenu-item ">
                            <a href="{{ route('level.index') }}">Level</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{ route('user.index') }}">User</a>
                        </li>
                        @endif

                        <!-- Customer dan Service Type boleh untuk Administrator dan Operator -->
                        <li class="submenu-item ">
                            <a href="{{ route('customer.index') }}">Customer</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{ route('service.index') }}">Service Type</a>
                        </li>
                    </ul>
                </li>
                @endif

                <!-- Penjelasan: Menu Transaksi untuk Administrator dan Operator -->
                @if(in_array($levelName, ['Administrator', 'Operator']))
                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-basket-fill"></i>
                        <span>Transaction</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <a href="{{ route('transaction.index') }}">Laundry Order</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{ route('pickup.index') }}">Laundry Pickup</a>
                        </li>
                    </ul>
                </li>
                @endif

                <!-- Penjelasan: Menu Laporan untuk Administrator dan Pimpinan -->
                @if(in_array($levelName, ['Administrator', 'Pimpinan']))
                <li class="sidebar-item">
                    <a href="{{ route('report.index') }}" class='sidebar-link'>
                        <i class="bi bi-file-earmark-bar-graph-fill"></i>
                        <span>Report</span>
                    </a>
                </li>
                @endif
                <li class="sidebar-item">
                    <form action="{{ route('action-logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Log Out
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
