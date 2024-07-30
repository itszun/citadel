<div class="app-sidebar menu-fixed {{ app(\App\Settings\GeneralSettings::class)->env != 'production' ? 'redoverlay' : '' }}"
    data-scroll-to-active="true">
    <div class="sidebar-header">
        <div class="logo clearfix">
            <div class="d-flex justify-content-center">
                <a class="logo-text" href="/" style="margin-left: -1rem">
                    <div class="">
                        <img src="{{ url('assets/img/wise_logo_putih.png') }}" class="menu-title" alt="e-SCM Logo"
                            style="width: 6.5rem;">
                    </div>
                </a>
                <a class="nav-close d-block d-lg-block d-xl-none" id="sidebarClose" href="javascript:;"><i
                        class="ft-x"></i></a>
            </div>
            <a class="nav-toggle d-none d-lg-none d-xl-block" id="sidebarToggle" type="button" href="#">
                <i class="toggle-icon" data-toggle="expanded"></i>
            </a>
        </div>
    </div>

    <div class="sidebar-content main-menu-content" style="overflow: auto">
        <div class="nav-container">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                @if (is_string($menu_content_html))
                    {!! $menu_content_html !!}
                @endif
            </ul>
        </div>
    </div>

    <!-- main menu content-->
    <div class="sidebar-background"></div>
</div>
