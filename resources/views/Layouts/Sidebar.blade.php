        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="index.html" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('assets/assets/ahp.png') }}" alt="Logo" class="img-fluid" width="50"
                            height="50">
                    </span>
                    <span class="text-start app-brand-text fw-bold ms-2 ">
                        <small>AHP</small><br>
                        <small>Marching Band</small><br>
                        <small>SMAN 1 PALASA</small>
                    </span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
                    <a href="/" class="menu-link">
                        <i class="menu-icon fa-solid fa-house"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('criteria') ? 'active' : '' }}">
                    <a href="/criteria" class="menu-link">
                        <i class="menu-icon fas fa-list"></i>
                        <div data-i18n="Analytics">Kriteria</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('kandidat') ? 'active' : '' }}">
                    <a href="/kandidat" class="menu-link">
                        <i class="menu-icon fas fa-users"></i>
                        <div data-i18n="Analytics">Data Kandidat</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('applicant-scores') ? 'active' : '' }}">
                    <a href="/applicant-scores" class="menu-link">
                        <i class="menu-icon fas fa-percentage"></i>
                        <div data-i18n="Analytics">Nilai Kandidat</div>
                    </a>
                </li>
                 <li class="menu-item {{ request()->is('arsip-ahp') ? 'active' : '' }}">
                    <a href="/arsip-ahp" class="menu-link">
                        <i class="menu-icon fa-solid fa-book "></i>
                        <div data-i18n="Analytics">Arsip Data</div>
                    </a>
                </li>


            </ul>
        </aside>
        <!-- / Menu -->
