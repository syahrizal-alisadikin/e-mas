 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('rb') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-store"></i>
                </div>
                <div class="sidebar-brand-text mx-3">UMKM </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Request::is('mitra/dashboard') ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('rb') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
                   <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-dollar-sign"></i>
                    <span>MITRA BINAAN</span>
                </a>
                <div id="collapseTwo" class="collapse {{ Request::is('mitra/users*') ? 'show' : '' }} {{ Request::is('mitra/products-mitra*') ? 'show' : '' }} {{ Request::is('mitra/pemasaran-mitra*') ? 'show' : '' }}{{ Request::is('mitra/transactions*') ? 'show' : '' }} " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        {{-- <h6 class="collapse-header">MPT</h6> --}}
                        <a class="collapse-item {{ Request::is('mitra/users*') ? ' active' : '' }}"  href="{{ route('users.index') }}">MITRA</a>
                        <a class="collapse-item {{ Request::is('mitra/products-mitra*') ? ' active' : '' }}" href="{{ route('products-mitra.index') }}">PRODUCT</a>
                        <a class="collapse-item {{ Request::is('mitra/transactions*') ? ' active' : '' }}" href="{{ route('transactions.index') }}">TRANSAKSI</a>
                        <a class="collapse-item {{ Request::is('mitra/pemasaran-mitra*') ? ' active' : '' }}" href="{{ route('pemasaran-mitra.index') }}">KEGIATAN PENJUALAN</a>
                    
                    </div>
                </div>
            </li>
            <li class="nav-item {{ Request::is('mitra/status-umkm') ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('status-umkm.index') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>STATUS UMKM</span></a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-dollar-sign"></i>
                    <span>TRANSAKSI</span>
                </a>
                <div id="collapseTwo" class="collapse  {{ Request::is('user/laporan-penjualan-product*') ? ' show' :  '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">LAPORAN</h6>
                        <a class="collapse-item {{ Request::is('user/laporan-penjualan-product*') ? ' active' : '' }}""  href="{{ route('laporan-penjualan-product.index') }}">PENJUALAN PRODUCT</a>
                        <a class="collapse-item" href="javascript:void(0)">PEMBEYARAN LAIN-LAIN</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduk"
                    aria-expanded="true" aria-controls="collapseProduk">
                    <i class="fab fa-product-hunt"></i>
                    <span>PRODUK</span>
                </a>
                <div id="collapseProduk" class="collapse {{ Request::is('user/bahan-product*') ? ' show' :  '' }} {{ Request::is('user/modal*') ? ' show' :  '' }} {{ Request::is('user/products*') ? ' show' :  '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">PRODUK & MODAL</h6>
                        <a class="collapse-item {{ Request::is('user/products*') ? ' active' : '' }}" href="{{ route('products.index') }}">PRODUK</a>
                        <a class="collapse-item {{ Request::is('user/modal*') ? ' active' : '' }}" href="{{ route('modal.index') }}">MODAL</a>
                        <a class="collapse-item {{ Request::is('user/bahan-product*') ? ' active' : '' }}" href="{{ route('bahan-product.index') }}">BAHAN</a>
                    
                    </div>
                </div>
            </li>
            <li class="nav-item {{ Request::is('user/pemasaran*') ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('pemasaran.index') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>KEGIATAN PEMASARAN</span></a>
            </li>
             <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProfile"
                    aria-expanded="true" aria-controls="collapseProfile">
                    <i class="fab fa-product-hunt"></i>
                    <span>PROFILE</span>
                </a>
                <div id="collapseProfile" class="collapse {{ Request::is('user/profile') ? ' show' :  '' }} {{ Request::is('user/status') ? ' show' :  '' }} {{ Request::is('user/sertifikasi') ? ' show' :  '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">PROFILE & STATUS</h6>
                        <a class="collapse-item {{ Request::is('user/profile') ? ' active' : '' }}" href="{{ route('user.profile') }}">PROFILE</a>
                        <a class="collapse-item {{ Request::is('user/status') ? ' active' : '' }}" href="{{ route('user.status') }}">STATUS</a>
                        <a class="collapse-item {{ Request::is('user/sertifikasi') ? ' active' : '' }}" href="{{ route('user.sertifikasi') }}">SERTIFIKASI</a>
                    </div>
                </div>
            </li> --}}


          
        
          

          

          
        </ul>