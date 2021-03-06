<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <div class="c-sidebar-brand-full">
            <img src="{{ asset(setting('app_logo', 'img/brand/logo_white.png')) }}" alt="Arpan Electric" style="margin: .5rem;" width="145" height="77">
        </div>
        <div class="c-sidebar-brand-minimized">
            <img src="{{ asset(setting('app_logo', 'img/brand/mini_white.png')) }}" alt="" width="45px">
        </div>
    </div><!--c-sidebar-brand-->

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <x-utils.link
                class="c-sidebar-nav-link"
                :href="route('admin.dashboard')"
                :active="activeClass(Route::is('admin.dashboard'), 'c-active')"
                icon="c-sidebar-nav-icon cil-speedometer"
                :text="__('Dashboard')" />
        </li>

        @if (
            $logged_in_user->hasAllAccess() ||
            (
                $logged_in_user->can('admin.access.user.list') ||
                $logged_in_user->can('admin.access.user.deactivate') ||
                $logged_in_user->can('admin.access.user.reactivate') ||
                $logged_in_user->can('admin.access.user.clear-session') ||
                $logged_in_user->can('admin.access.user.impersonate') ||
                $logged_in_user->can('admin.access.user.change-password')
            )
        )

            <li class="c-sidebar-nav-title">@lang('Transaction')</li>

            {{-- sales menu --}}
            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.sales.*'), 'c-open c-show') }}">
                <x-utils.link
                    href="#"
                    icon="c-sidebar-nav-icon cil-layers"
                    class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Sales')" />
                    <ul class="c-sidebar-nav-dropdown-items">
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.sales.index')"
                                class="c-sidebar-nav-link"
                                :active="activeClass(Route::is('admin.sales.index'), 'c-active')"
                                :text="__('All Sales')" />
                        </li>
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.sales.create')"
                                class="c-sidebar-nav-link"
                                :active="activeClass(Route::is('admin.sales.create'), 'c-active')"
                                :text="__('Add Sales')" />
                        </li>
                    </ul>
            </li>

            {{-- purchase menu --}}
            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.purchase.*'), 'c-open c-show') }}">
                <x-utils.link
                    href="#"
                    icon="c-sidebar-nav-icon cil-layers"
                    class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Purchase')" />
                    <ul class="c-sidebar-nav-dropdown-items">
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.purchase.index')"
                                class="c-sidebar-nav-link"
                                :active="activeClass(Route::is('admin.purchase.index'), 'c-active')"
                                :text="__('All Purchases')" />
                        </li>
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.purchase.create')"
                                class="c-sidebar-nav-link"
                                :active="activeClass(Route::is('admin.purchase.create'), 'c-active')"
                                :text="__('Add Purchase')" />
                        </li>
                    </ul>
            </li>

            {{-- report menu --}}
            <li class="c-sidebar-nav-item">
                <x-utils.link
                    class="c-sidebar-nav-link"
                    :href="route('admin.report.index')"
                    :active="activeClass(Route::is('admin.report*'), 'c-active')"
                    icon="c-sidebar-nav-icon cil-bar-chart"
                    :text="__('Report')" />
            </li>



            <li class="c-sidebar-nav-title">@lang('Master Data')</li>

            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.product.*'), 'c-open c-show') }}">
                <x-utils.link
                    href="#"
                    icon="c-sidebar-nav-icon cil-layers"
                    class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Inventory')" />
                    <ul class="c-sidebar-nav-dropdown-items">
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.product.index')"
                                class="c-sidebar-nav-link"
                                :active="activeClass(Route::is('admin.product.index'), 'c-active')"
                                :text="__('All Products')" />
                        </li>
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.product.create')"
                                class="c-sidebar-nav-link"
                                :active="activeClass(Route::is('admin.product.create'), 'c-active')"
                                :text="__('New Product')" />
                        </li>
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.category.index')"
                                class="c-sidebar-nav-link"
                                :active="activeClass(Route::is('admin.category.index'), 'c-active')"
                                :text="__('All Product Categories')" />
                        </li>
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.category.create')"
                                class="c-sidebar-nav-link"
                                :active="activeClass(Route::is('admin.category.create'), 'c-active')"
                                :text="__('New Product Category')" />
                        </li>
                    </ul>
            </li>

            {{-- customer menu --}}
            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.customer.*'), 'c-open c-show') }}">
                <x-utils.link
                    href="#"
                    icon="c-sidebar-nav-icon cil-layers"
                    class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Customer')" />
                    <ul class="c-sidebar-nav-dropdown-items">
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.customer.index')"
                                class="c-sidebar-nav-link"
                                :active="activeClass(Route::is('admin.customer.index'), 'c-active')"
                                :text="__('All Customers')" />
                        </li>
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.customer.create')"
                                class="c-sidebar-nav-link"
                                :active="activeClass(Route::is('admin.customer.create'), 'c-active')"
                                :text="__('New Customer')" />
                        </li>
                    </ul>
            </li>

            {{-- supplier menu --}}
            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.supplier.*'), 'c-open c-show') }}">
                <x-utils.link
                    href="#"
                    icon="c-sidebar-nav-icon cil-layers"
                    class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Supplier')" />
                    <ul class="c-sidebar-nav-dropdown-items">
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.supplier.index')"
                                class="c-sidebar-nav-link"
                                :active="activeClass(Route::is('admin.supplier.index'), 'c-active')"
                                :text="__('All Suppliers')" />
                        </li>
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.supplier.create')"
                                class="c-sidebar-nav-link"
                                :active="activeClass(Route::is('admin.supplier.create'), 'c-active')"
                                :text="__('New Supplier')" />
                        </li>
                    </ul>
            </li>


            <li class="c-sidebar-nav-title">@lang('System')</li>

            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.auth.user.*') || Route::is('admin.auth.role.*'), 'c-open c-show') }}">
                <x-utils.link
                    href="#"
                    icon="c-sidebar-nav-icon cil-user"
                    class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Access')" />

                <ul class="c-sidebar-nav-dropdown-items">
                    @if (
                        $logged_in_user->hasAllAccess() ||
                        (
                            $logged_in_user->can('admin.access.user.list') ||
                            $logged_in_user->can('admin.access.user.deactivate') ||
                            $logged_in_user->can('admin.access.user.reactivate') ||
                            $logged_in_user->can('admin.access.user.clear-session') ||
                            $logged_in_user->can('admin.access.user.impersonate') ||
                            $logged_in_user->can('admin.access.user.change-password')
                        )
                    )
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.auth.user.index')"
                                class="c-sidebar-nav-link"
                                :text="__('User Management')"
                                :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                        </li>
                    @endif

                    @if ($logged_in_user->hasAllAccess())
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.auth.role.index')"
                                class="c-sidebar-nav-link"
                                :text="__('Role Management')"
                                :active="activeClass(Route::is('admin.auth.role.*'), 'c-active')" />
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if ($logged_in_user->hasAllAccess())
            <li class="c-sidebar-nav-dropdown">
                <x-utils.link
                    href="#"
                    icon="c-sidebar-nav-icon cil-list"
                    class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Logs')" />

                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <x-utils.link
                            :href="route('log-viewer::dashboard')"
                            class="c-sidebar-nav-link"
                            :text="__('Dashboard')" />
                    </li>
                    <li class="c-sidebar-nav-item">
                        <x-utils.link
                            :href="route('log-viewer::logs.list')"
                            class="c-sidebar-nav-link"
                            :text="__('Logs')" />
                    </li>
                </ul>
            </li>
        @endif

        <li class="c-sidebar-nav-item">
            <x-utils.link
                class="c-sidebar-nav-link"
                :href="route('admin.settings.index')"
                :active="activeClass(Route::is('admin.settings*'), 'c-active')"
                icon="c-sidebar-nav-icon cil-settings"
                :text="__('Settings')" />
        </li>
    </ul>

    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div><!--sidebar-->
