<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div id="kt_app_sidebar_logo" class="app-sidebar-logo px-8">
        <!--begin::Logo image-->
        <img alt="Logo" src="{{ asset(config('app.landscape_dark_image_url')) }}"
            class="h-30px app-sidebar-logo-default theme-light-show" />
        <img alt="Logo" src="{{ asset(config('app.landscape_dark_image_url')) }}"
            class="h-30px app-sidebar-logo-default theme-dark-show" />
        <img alt="Logo" src="{{ asset(config('app.logo_image_url')) }}" class="h-25px app-sidebar-logo-minimize" />
        <!--end::Logo image-->

        <!--begin::Sidebar toggle-->
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-outline ki-black-left-line fs-3 rotate-180"></i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->

    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <!--begin::Scroll wrapper-->
            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true"
                data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
                data-kt-scroll-save-state="true">

                <?php
                $groups = [
                    'dashboard' => [
                        'name' => '',
                        'conditional' => [],
                        'menus' => [
                            [
                                'name' => __('Dashboard'),
                                'icon' => 'ki-element-11',
                                'url' => route('dashboards.welcome'),
                                'route' => 'dashboards.',
                                'conditional' => [],
                                'sub_menus' => [],
                            ],
                        ],
                    ],
                ];
                
                $groups['entity-management'] = [
                    'name' => __('Entity Management'),
                    'conditional' => [
                        auth()
                            ->user()
                            ->hasAnyPermission(['entity.list']),
                    ],
                    'menus' => [
                        [
                            'name' => __('Entities'),
                            'icon' => 'ki-people',
                            'url' => route('entities.index'),
                            'route' => 'entities.',
                            'conditional' => [auth()->user()->can('entity.list')],
                            'sub_menus' => null,
                        ],
                    ],
                ];
                
                $groups['user-management'] = [
                    'name' => __('User Management'),
                    'conditional' => [
                        auth()
                            ->user()
                            ->hasAnyPermission(['user.list', 'role.list']),
                    ],
                    'menus' => [
                        [
                            'name' => __('Users'),
                            'icon' => 'ki-address-book',
                            'url' => route('users.index'),
                            'route' => 'users.',
                            'conditional' => [auth()->user()->can('user.list')],
                            'sub_menus' => null,
                        ],
                        [
                            'name' => __('Roles'),
                            'icon' => 'ki-security-user',
                            'url' => route('roles.index'),
                            'route' => 'roles.',
                            'conditional' => [auth()->user()->can('role.list')],
                            'sub_menus' => null,
                        ],
                    ],
                ];
                
                $groups['master'] = [
                    'name' => __('Master'),
                    'conditional' => [
                        auth()
                            ->user()
                            ->hasAnyPermission(['entity-category.list', 'item-category.list']),
                    ],
                    'menus' => [
                        [
                            'name' => __('Entity Categories'),
                            'icon' => 'ki-abstract-36',
                            'url' => route('entity-categories.index'),
                            'route' => 'entity-categories.',
                            'conditional' => [auth()->user()->can('entity-category.list')],
                            'sub_menus' => null,
                        ],
                        [
                            'name' => __('Item Categories'),
                            'icon' => 'ki-abstract-26',
                            'url' => route('item-categories.index'),
                            'route' => 'item-categories.',
                            'conditional' => [auth()->user()->can('item-category.list')],
                            'sub_menus' => null,
                        ],
                    ],
                ];
                ?>

                <!--begin::Menu-->
                <div id="#kt_app_sidebar_menu" class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                    data-kt-menu="true" data-kt-menu-expand="false">

                    @foreach ($groups as $group)
                        @if ($group['name'] && (count($group['conditional']) === 0 || array_search(true, $group['conditional']) !== false))
                            <!--begin:Menu item-->
                            <div class="menu-item pt-5">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7">
                                        {!! $group['name'] !!}
                                    </span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                            <!--end:Menu item-->
                        @endif

                        @foreach ($group['menus'] as $menu)
                            @if (count($menu['conditional']) === 0 || array_search(true, $menu['conditional']) !== false)
                                <!--begin:Menu item-->
                                @if ($menu['sub_menus'])
                                    <div data-kt-menu-trigger="click"
                                        class="menu-item menu-accordion {!! request()->routeIs($menu['route'] . '*') ? 'here show' : '' !!}">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="fs-2 ki-outline {!! $menu['icon'] !!}"></i>
                                            </span>
                                            <span class="menu-title">{!! $menu['name'] !!}</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->

                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                @foreach ($menu['sub_menus'] as $subMenu)
                                                    @if (count($subMenu['conditional']) == 0 || array_search(true, $subMenu['conditional']) !== false)
                                                        <!--begin:Menu link-->
                                                        <a class="menu-link {!! request()->routeIs($subMenu['route'] . '*') ? 'active' : '' !!}"
                                                            href="{!! $subMenu['url'] !!}">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">{!! $subMenu['name'] !!}</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    @endif
                                                @endforeach
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                @else
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {!! request()->routeIs($menu['route'] . '*') ? 'active' : '' !!}" href="{!! $menu['url'] !!}">
                                            <span class="menu-icon">
                                                <i class="fs-2 ki-outline {!! $menu['icon'] !!}"></i>
                                            </span>
                                            <span class="menu-title">{!! $menu['name'] !!}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                @endif
                                <!--end:Menu item-->
                            @endif
                        @endforeach
                    @endforeach
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Scroll wrapper-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
</div>
