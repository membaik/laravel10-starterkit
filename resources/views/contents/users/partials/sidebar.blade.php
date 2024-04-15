<div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
    <!--begin::Card-->
    <div class="card mb-5 mb-xl-8">
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Summary-->
            <!--begin::User Info-->
            <div class="d-flex flex-center flex-column py-5">
                <!--begin::Avatar-->
                <div class="symbol symbol-100px symbol-circle mb-5">
                    <img src="{{ $query->image_full_url }}" alt="User Image" />
                </div>
                <!--end::Avatar-->
                <!--begin::Name-->
                <a href="javascript:;"
                    class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{ $query->full_name }}</a>
                <!--end::Name-->
            </div>
            <!--end::User Info-->
            <!--end::Summary-->
            <!--begin::Details toggle-->
            <div class="d-flex flex-stack fs-4 py-3">
                <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details"
                    role="button" aria-expanded="false" aria-controls="kt_user_view_details">
                    {{ __('Details') }}
                    <span class="ms-2 rotate-180">
                        <i class="ki-duotone ki-down fs-3"></i>
                    </span>
                </div>
            </div>
            <!--end::Details toggle-->
            <div class="separator"></div>
            <!--begin::Details content-->
            <div id="kt_user_view_details" class="collapse show">
                <div class="pb-5 fs-6">
                    <!--begin::Details item-->
                    <div class="fw-bold mt-5">{{ __('Status') }}</div>
                    <div class="text-gray-600">
                        @if ($query->is_active)
                            <div class="badge badge-success fw-bold py-2 px-3 mt-1">
                                {{ strtoupper(__('Active')) }}
                            </div>
                        @else
                            <div class="badge badge-secondary fw-bold py-2 px-3 mt-1">
                                {{ strtoupper(__('Inactive')) }}
                            </div>
                        @endif

                    </div>
                    <!--begin::Details item-->
                    <!--begin::Details item-->
                    <div class="fw-bold mt-5">{{ __('Status') }}</div>
                    <div class="text-gray-600">
                        <a href="mailto:{{ $query->email }}"
                            class="text-gray-600 text-hover-primary">{{ $query->email }}</a>
                    </div>
                    <!--begin::Details item-->
                    <!--begin::Details item-->
                    <div class="fw-bold mt-5">{{ __('Roles') }}</div>
                    <div class="text-gray-600">
                        {!! $query->getRoleNames()->toArray()
                            ? '<span class="d-block">' . implode('</span><span class="d-block">', $query->getRoleNames()->toArray()) . '</span>'
                            : '<span class="text-muted fw-light fst-italic">' . __('general.none') . '</span>' !!}
                    </div>
                    <!--begin::Details item-->
                </div>
            </div>
            <!--end::Details content-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</div>
