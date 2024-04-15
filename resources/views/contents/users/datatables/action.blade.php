@if (auth()->user()->hasAnyPermission(['user.edit', 'user.destroy']))
    <a href="#" class="btn btn-flex btn-sm btn-light btn-center btn-active-light-primary ps-5 pe-3"
        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
        {{ __('More') }}
        <i class="ki-solid ki-down fs-5 ms-1"></i>
    </a>

    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-3"
        data-kt-menu="true">
        {{-- @can('user.show')
        <div class="menu-item px-3">
            <a href="{{ route('users.show', $query->id) }}" class="menu-link px-3">
                <i class="ki-solid ki-shield-search fs-4 me-2"></i>
                {{ __('Preview') }}
            </a>
        </div>
    @endcan --}}
        @can('user.edit')
            <div class="menu-item px-3">
                <a href="{{ route('users.edit', $query->id) }}" class="menu-link px-3">
                    <i class="ki-solid ki-pencil fs-4 me-2"></i>
                    {{ __('Edit') }}
                </a>
            </div>
        @endcan
        @can('user.destroy')
            <div class="menu-item px-3">
                <a href="javascript:;" class="menu-link px-3" button-delete>
                    <i class="ki-solid ki-trash fs-4 me-2"></i>
                    {{ __('Delete') }}
                </a>
            </div>
        @endcan
    </div>
@else
    <span class="text-muted fst-italic text-nowrap">{{ __('Not Allowed') }}</span>
@endif
