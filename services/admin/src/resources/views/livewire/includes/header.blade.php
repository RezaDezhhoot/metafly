@use('App\Enums\PageAction')
<!--begin::Header-->
<div id="kt_header" class="header header-fixed">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
        </div>
        <div class="topbar">
            <div class="topbar-item">
                <div class="btn jdate btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                    <span class="text-dark-50 jdate font-weight-bolder font-size-base d-none d-md-inline mr-3">{{auth()->user()->email}} - {{ persian_date(now()) }}</span>
                    <span class="symbol symbol-lg-35 symbol-25 symbol-light-success"></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
        <h3 class="font-weight-bold m-0">{{ __('general.profile') }}
            <small class="text-muted font-size-sm ml-2"></small></h3>
        <a  class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
            <i class="ki ki-close icon-xs text-muted"></i>
        </a>
    </div>
    <div class="offcanvas-content pr-5 mr-n5">
        <div class="d-flex align-items-center mt-5">
            <div class="symbol symbol-100 mr-5">
                <div class="symbol-label rounded-circle" style="background-image:url('{{asset(auth()->user()->avatar?->url ?? null )}}')"></div>
                <i class="symbol-badge bg-success"></i>
            </div>
            <div class="d-flex flex-column">
                <a href="" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">
                    {{ auth()->user()->name }} #{{ auth()->id() }}
                </a>
                <div class="text-muted mt-1">
                    @foreach(auth()->user()->roles as $item)
                        {!!  $item->name."<br>" !!}
                    @endforeach
                </div>
                <div class="navi mt-2">
                    <a class="navi-item">
                            <span class="navi-link p-0 pb-2">
									<span class="navi-icon mr-1">
										<span class="svg-icon svg-icon-lg svg-icon-primary">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"></rect>
													<path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000"></path>
													<circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5"></circle>
												</g>
											</svg>
										</span>
                            </span>
                            <span class="navi-text text-muted text-hover-primary">{{ auth()->user()->email ?? '-' }}</span>
                            </span>
                    </a>
                    <a href="{{ route('auth.logout') }}" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">{{__('general.sidebar.logout')}}</a>
                </div>
            </div>
        </div>
        <div class="separator separator-dashed mt-8 mb-5"></div>
    </div>
</div>
