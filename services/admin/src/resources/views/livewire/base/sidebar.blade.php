@use('App\Enums\CategoryType')
<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
    <div class="brand flex-column-auto" id="kt_brand">
        <a href="{{ route('dashboard') }}" class="brand-logo">
            <img alt="Logo" style="max-width: 4rem;border-radius: 50%;" src="{{asset(getSettings('logo'))}}" />
        </a>
        <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
							<span class="svg-icon svg-icon svg-icon-xl">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24" />
										<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
										<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
									</g>
								</svg>
							</span>
        </button>
    </div>
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
        <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
            <ul class="menu-nav">
                <li class="menu-item {{ url()->current() == route('dashboard') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ route('dashboard') }}" class="menu-link">
                                    <span class="svg-icon menu-icon">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<polygon points="0 0 24 0 24 24 0 24" />
													<path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
													<path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
												</g>
											</svg>
										</span>
                        <span class="menu-text">{{__('general.sidebar.dashboard.dashboard')}}</span>
                    </a>
                </li>


                <li class="menu-section">
                    <h4 class="menu-text">{{__('general.sidebar.media.media')}}</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>
                <x-admin.menu-item href="{{route('lfm')}}" icon="fas fa-file" :active="request()->routeIs('lfm')" label="{{ __('general.sidebar.media.file-manager') }}" />

                <li class="menu-section">
                    <h4 class="menu-text">{{__('general.sidebar.report.report')}}</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>
                @role('administrator')
{{--                    <x-admin.menu-item href="{{ route('admin.log-activity.index') }}" :active="request()->routeIs(['admin.log-activity.index'])" icon="fas fa-history" label="{{__('general.sidebar.log_activity')}}" />--}}
{{--                    <x-admin.menu-item href="{{ route('admin.authentication-log.index') }}" :active="request()->routeIs(['admin.authentication-log.index'])" icon="fas fa-sign-in-alt" label="{{__('general.sidebar.authentication_logs')}}" />--}}
                @endif
                <li class="menu-section">
                    <h4 class="menu-text"> {{__('general.sidebar.content_section')}}</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>
                @can('show_topics')
                    <x-admin.menu-item
                        href="{{route('topic.index')}}"
                        icon="fas fa-filter"
                        :active="request()->routeIs(['topic.index','topic.store'])"
                        label="{{__('general.sidebar.topics')}}" />
                @endcan
                @can('show_blogs')
                    <x-admin.menu-group icon="far fa-newspaper" :active="request()->routeIs(['category.index','category.store','post.index','post.store'])" label="{{__('general.sidebar.posts') }}" >
                        @can('show_categories')
                            <x-admin.menu-item href="{{route('category.index',CategoryType::POST)}}" icon="menu-bullet menu-bullet-dot" :active="request()->routeIs(['category.index','category.store'])" label="{{__('general.sidebar.categories') }} " />
                        @endcan
                        <x-admin.menu-item href="{{route('post.index')}}" icon="menu-bullet menu-bullet-dot" :active="request()->routeIs(['post.index','post.store'])" label="{{__('general.sidebar.posts') }} " />
                    </x-admin.menu-group>
                @endcan
                @can('show_comments')
                    <x-admin.menu-item
                        href="{{route('comment.index')}}"
                        icon="far fa-comment"
                        :active="request()->routeIs(['comment.index','comment.store'])"
                        label="{{__('general.sidebar.comments')}}({{$comments}})"
                    />
                @endcan

                <li class="menu-section">
                    <h4 class="menu-text"> {{__('general.sidebar.user_section')}}</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md "></i>
                </li>

                @can('show_users')
                    <x-admin.menu-item
                        href="{{route('user.index')}}"
                        icon="fas fa-user"
                        :active="request()->routeIs(['user.index','user.store'])"
                        label="{{__('general.sidebar.users')}}"
                    />
                @endcan
                @can('show_roles')
                    <x-admin.menu-item
                        href="{{route('role.index')}}"
                        icon="fas fa-key"
                        :active="request()->routeIs(['role.index','role.store'])"
                        label="{{__('general.sidebar.roles')}}"
                    />
                @endcan

                <li class="menu-section">
                    <h4 class="menu-text">{{__('general.sidebar.technical_section')}}</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>
                @can('show_points')
                    <x-admin.menu-item
                        href="{{route('point.index')}}"
                        icon="flaticon2-location"
                        :active="request()->routeIs(['point.index','point.store'])"
                        label="{{__('general.sidebar.points')}}" />
                @endcan
                @can('show_transports')
                    <x-admin.menu-item
                        href="{{route('transport.index')}}"
                        icon="fas fa-shipping-fast"
                        :active="request()->routeIs(['transport.index','transport.store'])"
                        label="{{__('general.sidebar.transports')}}" />
                @endcan

                @can('show_settings')
                    <x-admin.menu-group icon="fa fa-cog" :active="request()->routeIs(['settings.base','settings.contact','settings.footer','settings.landing','faq.index','faq.store'])" label="{{__('general.sidebar.settings') }}" >
                        <x-admin.menu-item href="{{route('settings.base')}}" icon="menu-bullet menu-bullet-dot" :active="request()->routeIs('settings.base')" label="{{__('general.sidebar.base') }} " />
                        <x-admin.menu-item href="{{route('settings.contact')}}" icon="menu-bullet menu-bullet-dot" :active="request()->routeIs('settings.contact')" label="{{__('general.sidebar.contact') }} " />
                        <x-admin.menu-item href="{{route('settings.footer')}}" icon="menu-bullet menu-bullet-dot" :active="request()->routeIs('settings.footer')" label="{{__('general.sidebar.footer') }} " />
                        <x-admin.menu-item href="{{route('settings.landing')}}" icon="menu-bullet menu-bullet-dot" :active="request()->routeIs('settings.landing')" label="{{__('general.sidebar.landing') }} " />
                        <x-admin.menu-item href="{{route('faq.index')}}" icon="menu-bullet menu-bullet-dot" :active="request()->routeIs(['faq.index','faq.store'])" label="{{__('general.sidebar.faqs')}}" />
                    </x-admin.menu-group>
                @endcan

                <li class="menu-section">
                    <h4 class="menu-text">{{__('general.sidebar.tools')}}</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md "></i>
                </li>
                @role('administrator')
{{--                    <x-admin.menu-item href="{{route('log-viewer.index')}}" icon="fas fa-book" :active="false" label="logger" />--}}
{{--                    <x-admin.menu-item href="{{route('telescope')}}" icon="fas fa-book" :active="false" label="telescope" />--}}
{{--                    <x-admin.menu-item href="{{route('horizon.index')}}" icon="fab fa-whmcs" :active="false" label="horizon" />--}}
{{--                    <x-admin.menu-item href="{{ config('admin.phpmyadmin') }}" icon="fas fa-database" :active="false" label="php my admin" />--}}
                @endif

                <li class="menu-section">
                    <h4 class="menu-text"> {{__('general.sidebar.logout')}}</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md "></i>
                </li>
                <x-admin.menu-item href="{{route('auth.logout')}}" icon="fas fa-door-closed" :active="false" label="{{__('general.sidebar.logout')}}" />
            </ul>
        </div>
    </div>
</div>
