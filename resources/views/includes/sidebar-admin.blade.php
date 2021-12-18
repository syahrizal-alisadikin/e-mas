 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-store"></i>
                </div>
                <div class="sidebar-brand-text mx-3">ADMIN UMKM </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Request::is('user/dashboard') ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('user') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

           
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-dollar-sign"></i>
                    <span>LAPORAN</span>
                </a>
                <div id="collapseTwo" class="collapse {{ Request::is('admin/mitra-admin*') ? 'show' : '' }}  {{ Request::is('admin/rumah-bumn*') ? ' show' :  '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">LAPORAN RB & UMKM</h6>
                        <a class="collapse-item {{ Request::is('admin/rumah-bumn*') ? ' active' : '' }}"  href="{{ route('rumah-bumn.index') }}">RUMAH BUMN</a>
                        <a class="collapse-item {{ Request::is('admin/mitra-admin*') ? ' active' : '' }}" href="{{ route('mitra-admin') }}">MITRA UMKM</a>
                    </div>
                </div>
            </li>
           
        


          
        
          

          

          
        </ul>