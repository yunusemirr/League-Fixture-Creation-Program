<!--begin::Aside-->
<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
    <!--begin::Logo-->
    <div class="pt-10 aside-logo flex-column-auto pt-lg-20" id="kt_aside_logo">
        <a href="{{ route('panel.show') }}">
            <img alt="Logo" src="{{ asset('assets/static/main-logo.png') }}" class="h-40px" />
        </a>
    </div>
    <!--end::Logo-->
    <!--begin::Nav-->
    <div class="pt-0 aside-menu flex-column-fluid pb-7 py-lg-10" id="kt_aside_menu">
        <!--begin::Aside menu-->
        <div id="kt_aside_menu_wrapper" class="w-100 hover-scroll-overlay-y scroll-ps d-flex" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="0">
            <div id="kt_aside_menu" class="my-auto menu menu-column menu-title-gray-600 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-icon-gray-400 menu-arrow-gray-400 fw-semibold fs-6" data-kt-menu="true">

                @forelse ($navigation?->tree()[0]["children"] as $index => $menu)
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="py-2 menu-item @if($menu['active']) here @endif">
                        <!--begin:Menu link-->
                        <a class="menu-link menu-center" href="{{ $menu['url'] }}">
                            <span class="menu-icon me-0">
                                <i class="{{ $menu['attributes']['icon'] ?? '' }} fs-2x"></i>
                            </span>
                        </a>
                        <!--end:Menu link-->
                        @if (count($menu['children']) > 0)
                            <!--begin:Menu sub-->
                            <div class="px-2 py-4 overflow-auto menu-sub menu-sub-dropdown menu-sub-indention w-250px mh-75">
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu content-->
                                    <div class="menu-content">
                                        <span class="py-1 menu-section fs-5 fw-bolder ps-1">{{ $menu['title'] }}</span>
                                    </div>
                                    <!--end:Menu content-->
                                </div>
                                <!--end:Menu item-->

                                @forelse ($menu['children'] as $item)
                                    @if (count($item['children']) > 0)
                                        <!--begin:Menu item-->
                                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $item['active'] ? "here show" : "" }}">
                                            <!--begin:Menu link-->
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="{{ $item['attributes']['icon'] ?? "" }} fs-2"></i>
                                                </span>
                                                <span class="menu-title">{{ $item['title'] }}</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <!--end:Menu link-->
                                            <!--begin:Menu sub-->
                                            <div class="menu-sub menu-sub-accordion">
                                                @foreach ($item['children'] as $route)
                                                    <!--begin:Menu item-->
                                                    <div class="menu-item {{ $route['active'] ? "here" : "" }}">
                                                        <!--begin:Menu link-->
                                                        <a class="menu-link" href="{{ $route['url'] }}">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">{{ $route['title'] }}</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->
                                                @endforeach
                                            </div>
                                            <!--end:Menu sub-->
                                        </div>
                                        <!--end:Menu item-->
                                    @else
                                        <!--begin:Menu item-->
                                        <div class="menu-item {{ $item['active'] ? "here" : "" }}">
                                            <!--begin:Menu link-->
                                            <a class="menu-link" href="{{ $item['url'] }}">
                                                <span class="menu-icon">
                                                    <i class="{{ $item['attributes']['icon'] ?? "" }} fs-2"></i>
                                                </span>
                                                <span class="menu-title">{{ $item['title'] }}</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endif
                                @empty
                                    <!--begin:Menu item-->
                                    <div class="menu-item  {{ $menu['active'] ? "here" : "" }}">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="../../demo9/dist/apps/calendar.html">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-calendar-8 fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                    <span class="path6"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title">Calendar</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endforelse

                            </div>
                            <!--end:Menu sub-->
                        @endif
                    </div>
                    <!--end:Menu item-->
                @empty

                @endforelse

            </div>
        </div>
        <!--end::Aside menu-->
    </div>
    <!--end::Nav-->
    <!--begin::Logout-->
    <div class="pb-5 aside-footer flex-column-auto pb-lg-10" id="kt_aside_footer">
        <!--begin::Menu-->
        <div class="d-flex flex-center w-100 scroll-px" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="{{ __('messages.auth.log_out') }}">
            <a href="{{ route('logout.post') }}" class="btn btn-custom">
                <i class="ki-duotone ki-entrance-left fs-2x">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </a>
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Logout-->
</div>
<!--end::Aside-->
