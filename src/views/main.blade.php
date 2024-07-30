<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @if (isset($page_info))
        <title>{{ $page_info['site_name'] }} - {{ $page_info['title'] }}</title>
    @else
        <title>
            @yield('title') - @yield('code')
        </title>
    @endif
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <base href="{{ url('/') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('template.head')

    <style>
        .citadel-section {
            position: relative;
        }

        .see-more {
            position: relative;
            overflow: hidden;
            min-height: 400px;
            height: 400px;
            transition: height .7s;
            -o-transition: height .7s;
            -webkit-transition: height .7s;
            -moz-transition: height .7s;
        }

        .see-more.enlarge {
            height: 100%;
        }

        .citadel-see-more {
            position: absolute;
            padding: 20px;
            right: 0;
            left: 0;
            bottom: 0px;
            display: flex;
            justify-content: flex-end;
            background: linear-gradient(0deg, rgba(255, 255, 255, 0.7) 22%, rgba(255, 255, 255, 0) 100%)
        }

        .see-more.enlarge .citadel-see-more {
            background: none;
        }

        .see-more.enlarge .citadel-section-expand {
            display: none;
        }


        .see-more .citadel-section-collapse {
            display: none;
        }

        .see-more.enlarge .citadel-section-collapse {
            display: flex;
        }

        .citadel-see-more a {
            color: #2aace3;
            border-bottom: .4px solid #2aace3;
        }

        #citadel-floaters .action_button a {
            font-size: 2rem;
        }

        .transition-all {
            transition: all .2s ease-in-out;
        }

        .floaters-content {
            max-height: 100vh;
            overflow: auto;
        }
    </style>
    @if ($is_view_only)
        <style>
            input:not([class*="swal2"] input),
            select:not([class*="swal2"] select),
            .ck {
                pointer-events: none;
                border-color: transparent;
                background: transparent;
            }

            .note-editor,
            .select2 {
                pointer-events: none;

            }

            .add {
                display: none;
            }
        </style>
    @endif

</head>

<body @if (isset($controller_name) && in_array($controller_name, ['aset', 'inventory', 'administration'])) ng-app='{{ $controller_name }}' @endif
    class="vertical-layout vertical-menu 2-columns navbar-sticky" data-menu="vertical-menu" data-col="2-columns"
    x-data="{ sidebarOpen: false }" :class="sidebarOpen ? '' : 'nav-collapsed'">
    @if (Auth::user())
        @include('layouts.header_v')
    @endif
    <div class="wrapper">
        @if (Auth::user())
            {!! $sidebarMenuRender() !!}
        @endif
        <div class="main-panel">
            <!-- BEGIN : Main Content-->
            <div class="main-content">
                <div class="content-wrapper">
                    @include('layouts.breadcrumb')

                    <div class="row">
                        <div class="transition-all col-12 col-md-12" id="citadel-blueprint">
                            {!! $renderBlueprints() !!}
                        </div>
                        <div class="transition-all col-12 d-block d-md-none" id="citadel-floaters">
                            {!! $renderFloats() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer_v')

    </div>

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    @stack('body')
    @stack('modal')



    <script src="{{ asset('vendor/citadel/citadel.js') }}"></script>
    <script src="{{ asset('assets/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-table/dist/bootstrap-table.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-table/dist/extensions/cookie/bootstrap-table-cookie.min.js') }}">
    </script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.min.js"></script>

    <!-- LoadingOverylay -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>


    <script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript" src="assets/js/bottom.js"></script>
    <div id="ajax-modal" class="modal fade" tabindex="-1"></div>

    <script type="text/javascript" src="{{ asset('assets/app-assets/js/core/app-menu.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/app-assets/js/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/app-assets/js/toastr/abe-toast.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/app-assets/js/core/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/app-assets/js/customizer.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/app-assets/js/scroll-top.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/app-assets/js/components-modal.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/app-assets/vendors/js/sweetalert2.all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/app-assets/js/components-popover.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/assets/js/scripts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/app-assets/js/customizer.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/app-assets/vendors/js/switchery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/app-assets/js/jquery.mask.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript"
        src="{{ asset('assets/plugins/bootstrap-table/dist/extensions/editable/x-editable.js') }}"></script>

    @vite(['resources/js/alpine.js', 'resources/js/simplebar.js'])

    @yield('script')

    <style>
        .content-header {
            color: #0e1825;
        }

        th {
            white-space: nowrap;
        }
    </style>

    {!! Toastr::message() !!}
    @include('citadel::includes.scripts')
</body>

</html>
