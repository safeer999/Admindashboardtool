<!-- BEGIN #sidebar -->
<div id="sidebar" class="app-sidebar" data-bs-theme="dark">
    <!-- BEGIN scrollbar -->
    <div class="app-sidebar-content py-3" data-scrollbar="true" data-height="100%">
        <!-- BEGIN menu -->
        <div class="menu ">
            <div class="menu-item has-sub  mb-2 {{ request()->is('dashboard*') ? 'miniactiveparent' : '' }}">
                <a href="javascript:;" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-tachometer"></i>
                    </div>
                    <div class="menu-text ">Dashboard</div>
                    <div class="menu-caret"></div>
                </a>
                <div class="menu-submenu ">
                    <div class="menu-item mb-2 {{ request()->is('dashboard*') ? 'miniactive' : '' }}">
                        <a href="/dashboard" class="menu-link ">
                            <div class="menu-text">Dashboard1</div>
                        </a>
                    </div>
                    <div class="menu-item mb-2 {{ request()->is('dashboard2*') ? 'miniactive' : '' }}">
                        <a href="/dashboard" class="menu-link ">
                            <div class="menu-text">Dashboard2</div>
                        </a>
                    </div>
                </div>
                <div class="menu-submenu ">
                </div>
            </div>
        <div class="menu-item has-sub mb-2 {{ request()->is('emailverify*') ? 'miniactiveparent' : '' }}">
    <a href="javascript:;" class="menu-link">
        <div class="menu-icon">
            <i class="fa fa-users"></i>
        </div>
        <div class="menu-text">Email Verifier</div>
        <div class="menu-caret"></div>
    </a>
    <div class="menu-submenu">
        <div class="menu-item mb-2 {{ request()->is('emailverify/create') ? 'miniactive' : '' }}">
            <a href="{{ url('emailverify/create') }}" class="menu-link">
                <div class="menu-icon">
                    <i class="fa fa-check-circle"></i>
                </div>
                <div class="menu-text">Email Verifier</div>
            </a>
        </div>
        <div class="menu-item mb-2 {{ request()->is('emailverify') && !request()->is('emailverify/create') ? 'miniactive' : '' }}">
            <a href="{{ url('emailverify') }}" class="menu-link">
                <div class="menu-icon">
                    <i class="fa fa-envelope-open-text"></i>
                </div>
                <div class="menu-text">Single Email Result</div>
            </a>
        </div>
        <div class="menu-item mb-2 {{ request()->is('bulk*') ? 'miniactive' : '' }}">
            <a href="{{ route('bulk.index') }}" class="menu-link">
                <div class="menu-icon">
                    <i class="fa fa-tasks"></i>
                </div>
                <div class="menu-text">Tasks And Results</div>
            </a>
        </div>
    </div>
</div>










            <!-- BEGIN minify-button -->
            <div class="menu-item d-flex">
                <a href="javascript:;"
                    class="app-sidebar-minify-btn ms-auto d-flex align-items-center text-decoration-none"
                    data-toggle="app-sidebar-minify"><i class="fa fa-angle-double-left"></i></a>
            </div>
            <!-- END minify-button -->
        </div>
        <!-- END menu -->
    </div>
    <!-- END scrollbar -->
</div>
<div class="app-sidebar-bg" data-bs-theme="dark"></div>
<div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a></div>
<!-- END #sidebar -->






