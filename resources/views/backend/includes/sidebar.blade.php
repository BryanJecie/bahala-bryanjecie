<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none text-uppercase font-weight-bold">
        {{ appName() }}
    </div><!--c-sidebar-brand-->

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <x-utils.link class="c-sidebar-nav-link" :href="route('admin.dashboard')" :active="activeClass(Route::is('admin.dashboard'), 'c-active')"
                icon="c-sidebar-nav-icon cil-speedometer" :text="__('Dashboard')" />
        </li>


        @if (
            $logged_in_user->hasAllAccess() ||
                ($logged_in_user->can('admin.access.user.list') ||
                    $logged_in_user->can('admin.access.user.deactivate') ||
                    $logged_in_user->can('admin.access.user.reactivate') ||
                    $logged_in_user->can('admin.access.user.clear-session') ||
                    $logged_in_user->can('admin.access.user.impersonate') ||
                    $logged_in_user->can('admin.access.user.change-password')))
            <li class="c-sidebar-nav-item ">
                <x-utils.link icon="c-sidebar-nav-icon cil-cog" :href="route('admin.auth.role.index')" class="c-sidebar-nav-link"
                    :text="__('Roles')" :active="activeClass(Route::is('admin.auth.role.*'), 'c-active')" />
            </li>
        @endif
    </ul>

    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
        data-class="c-sidebar-minimized"></button>
</div>
