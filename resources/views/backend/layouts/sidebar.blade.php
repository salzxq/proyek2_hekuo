<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: green">

    <!-- Sidebar - Brand -->
    <a  style="height: 10rem" class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
      <div class="sidebar-brand-icon ">
        {{-- <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth()->user()->name}}</span> --}}
        @if(Auth()->user()->photo)
          <img class="img-profile rounded-circle" src="{{Auth()->user()->photo}}">
        @else
          <img class="img-profile rounded-circle" src="{{asset('backend/img/avatar.png')}}">
        @endif
      </div>
      <div class="sidebar-brand-text mx-3">{{Auth()->user()->name}}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="{{route('admin')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <li class="nav-item active">
      <a class="nav-link" href="{{route('admin-profile')}}">
        <i class="fas fa-user fa-sm fa-fw mr-2 "></i>
        <span>Profile</span></a>
    </li>

    <!-- Divider -->
    
    <!-- Divider -->
    <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            Shop
        </div>

    <!-- Categories -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categoryCollapse" aria-expanded="true" aria-controls="categoryCollapse">
          <i class="fas fa-sitemap"></i>
          <span>Jenis Hewan</span>
        </a>
        <div id="categoryCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Category Options:</h6>
            <a class="collapse-item" href="{{route('category.index')}}">Jenis Hewan</a>
            <a class="collapse-item" href="{{route('category.create')}}">Tambah Jenis Hewan</a>
          </div>
        </div>
    </li>
    {{-- Products --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productCollapse" aria-expanded="true" aria-controls="productCollapse">
          <i class="fas fa-cubes"></i>
          <span>Hewan Kurban</span>
        </a>
        <div id="productCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Hewan Kurban Options:</h6>
            <a class="collapse-item" href="{{route('product.index')}}">Hewan Kurban</a>
            <a class="collapse-item" href="{{route('product.create')}}">Tambah Hewan Kurban</a>
          </div>
        </div>
    </li>



    {{-- Shipping --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#shippingCollapse" aria-expanded="true" aria-controls="shippingCollapse">
          <i class="fas fa-truck"></i>
          <span>Pengiriman</span>
        </a>
        <div id="shippingCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Pengiriman Options:</h6>
            <a class="collapse-item" href="{{route('shipping.index')}}">Pengiriman</a>
            <a class="collapse-item" href="{{route('shipping.create')}}">Tambah Pengiriman</a>
          </div>
        </div>
    </li>
    
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#hargapenitipanCollapse" aria-expanded="true" aria-controls="hargapenitipanCollapse">
        <i class="fas fa-truck"></i>
        <span>Harga Penitipan</span>
      </a>
      <div id="hargapenitipanCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Pengiriman Options:</h6>
          <a class="collapse-item" href="{{route('hargapenitipan.index')}}">Pengiriman</a>
          <a class="collapse-item" href="{{route('hargapenitipan.create')}}">Tambah Pengiriman</a>
        </div>
      </div>
  </li>

    <!--Orders -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('order.index')}}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Pesanan</span>
        </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{route('penitipan.index')}}">
          <i class="fas fa-hammer fa-chart-area"></i>
          <span>Penitipan</span>
      </a>
  </li>
{{-- 
    <!-- Reviews -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('review.index')}}">
            <i class="fas fa-comments"></i>
            <span>Reviews</span></a>
    </li> --}}
    

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    

    <!-- Heading -->
    <div class="sidebar-heading">
        Banner
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- Nav Item - Charts -->


    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-image"></i>
        <span>Banners</span>
      </a>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Banner Options:</h6>
          <a class="collapse-item" href="{{route('banner.index')}}">Banners</a>
          <a class="collapse-item" href="{{route('banner.create')}}">Add Banners</a>
        </div>
      </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
     <!-- Heading -->
    <div class="sidebar-heading">
        General Settings
    </div>
     <!-- Users -->
     <li class="nav-item">
        <a class="nav-link" href="{{route('users.index')}}">
            <i class="fas fa-users"></i>
            <span>Users</span></a>
    </li>
     <!-- General settings -->
     <li class="nav-item">
        <a class="nav-link" href="{{route('settings')}}">
            <i class="fas fa-cog"></i>
            <span>Settings</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>