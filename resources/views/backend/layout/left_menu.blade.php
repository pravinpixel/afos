<div class="leftside-menu">
    
    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/afos/logo.png') }}" alt="" height="55">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/afos/sidesm.png') }}" alt="" height="75">
        </span>
    </a>
    
    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/afos/logo.png') }}" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/afos/logo.png') }}" alt="" height="16">
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-item">
                <a href="{{ route('dashboard')}}" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> Dashboard </span>
                </a>
            </li>
            
            <li class="side-nav-item">
                <a href="{{ route('reports') }}" class="side-nav-link">
                    <i class="uil-package"></i>
                    <span> Reports </span>
                </a>
            </li>
            
            <li class="side-nav-item">
                <a href="{{ route('orders') }}" class="side-nav-link">
                    <i class="uil-comments-alt"></i>
                    <span> Orders </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('payments') }}" class="side-nav-link">
                    <i class="uil-pricetag-alt"></i>
                    <span> Payments </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEcommerce" aria-expanded="false" aria-controls="sidebarEcommerce" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Products </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarEcommerce">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('products') }}">Foods</a>
                        </li>
                        <li>
                            <a href="{{ route('product-category') }}">Foods Categories</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEmail" aria-expanded="false" aria-controls="sidebarEmail" class="side-nav-link">
                    <i class="uil-envelope"></i>
                    <span> Managements </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarEmail">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('institutes') }}">Institutes</a>
                        </li>
                        <li>
                            <a href="{{ route('locations') }}">Locations</a>
                        </li>
                        <li>
                            <a href="{{ route('students') }}">Students</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarProjects" aria-expanded="false" aria-controls="sidebarProjects" class="side-nav-link">
                    <i class="uil-briefcase"></i>
                    <span> Authentication </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarProjects">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('users') }}">Users</a>
                        </li>
                        <li>
                            <a href="{{ route('roles') }}">Roles</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarLayouts" aria-expanded="false" aria-controls="sidebarLayouts" class="side-nav-link">
                    <i class="uil-shutter-alt "></i>
                    <span> Settings </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarLayouts">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('settings') }}">Site Settings</a>
                        </li>
                        <li>
                            <a href="{{ route('students.imports') }}">Import Students</a>
                        </li>  
                        <div></div>     
                    </ul>
                </div>
            </li>

            

            

            
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>