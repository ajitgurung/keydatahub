<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="{{route('dashboard')}}" class="brand-link">
            <!--begin::Brand Image-->
            <img
                src="{{asset('dash/images/img/AdminLTELogo.png')}}"
                alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">{{config('app.name')}}</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
                class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link">
                        @if(auth()->user()->isAdmin() || auth()->user()->isEditor())
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                        @else
                        <i class="nav-icon bi bi-search"></i>
                        <p>Key Search</p>
                        @endif
                    </a>
                </li>
                @if(auth()->user()->isAdmin() || auth()->user()->isEditor())

                <li class="nav-item"><a href="#" class="nav-link">
                        <i class="nav-icon bi bi-collection"></i>
                        <p>
                            Data Management
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-car-front-fill"></i>
                                <p>
                                    Make
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('makes.create')}}" class="nav-link">
                                        <i class="nav-icon bi bi-plus-circle"></i>
                                        <p>Add Make</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('makes.index')}}" class="nav-link">
                                        <i class="nav-icon bi bi-eye"></i>
                                        <p>View Make</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-ev-front"></i>
                                <p>
                                    Model
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('models.create')}}" class="nav-link">
                                        <i class="nav-icon bi bi-plus-circle"></i>
                                        <p>Add Model</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('models.index')}}" class="nav-link">
                                        <i class="nav-icon bi bi-eye"></i>
                                        <p>View Model</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-list-ol"></i>
                                <p>
                                    Year
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('years.create')}}" class="nav-link">
                                        <i class="nav-icon bi bi-plus-circle"></i>
                                        <p>Add Year</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('years.index')}}" class="nav-link">
                                        <i class="nav-icon bi bi-eye"></i>
                                        <p>View Year</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-info-circle"></i>
                                <p>
                                    Info
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('infos.create')}}" class="nav-link">
                                        <i class="nav-icon bi bi-plus-circle"></i>
                                        <p>Add Info</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('infos.index')}}" class="nav-link">
                                        <i class="nav-icon bi bi-eye"></i>
                                        <p>View Infos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                @if(auth()->user()->isAdmin())
                @can('admin-only')
                <li class="nav-item"><a href="#" class="nav-link">
                        <i class="nav-icon bi bi-people"></i>
                        <p>
                            Users Management
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('users.create')}}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Add User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('users.index')}}" class="nav-link">
                                <i class="nav-icon bi bi-eye"></i>
                                <p>View Users</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.income')}}" class="nav-link">
                        <i class="nav-icon bi bi-wallet"></i>
                        <p>Revenue</p>
                    </a>
                </li>
                @endcan
                @endif
                @endif

                <li class="nav-item">
                    <a href="{{route('subscription')}}" class="nav-link">
                        <i class="nav-icon bi bi-credit-card"></i>
                        <p>Subscription</p>
                    </a>
                </li>
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>