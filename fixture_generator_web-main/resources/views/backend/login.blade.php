
<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic
Product Version: 8.1.8
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="{{ app()->getLocale() }}">
	<!--begin::Head-->
	<head>
        <base href=""/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<title>{{ env('APP_NAME', 'app_title') }}</title>
		<meta charset="utf-8" />
		<meta name="description" content="{{ env('APP_DESCRIPTION', 'app_desc') ?? $container->description }}" />
		<meta name="keywords" content="{{ env('APP_KEYWORDS', 'app_keywords') ?? $container->keywords }}" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="{{ env('APP_NAME', 'app_title') }}" />
		<meta property="og:url" content="{{ env('APP_URL', 'app_url') }}" />
		<meta property="og:site_name" content="{{ env('APP_NAME', 'app_title') }}" />
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
        @stack('css')
        @yield('css')
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page bg image-->
			<style>body { background-image: url('{{ asset('assets/media/auth/bg4.jpg') }}'); } [data-bs-theme="dark"] body { background-image: url('{{ asset('assets/media/auth/bg4-dark.jpg') }}'); }</style>
			<!--end::Page bg image-->
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-column-fluid flex-lg-row">
				<!--begin::Aside-->
				<div class="px-10 d-flex flex-center w-lg-50 pt-15 pt-lg-0">
					<!--begin::Aside-->
					<div class="d-flex flex-center flex-lg-start flex-column">
						<!--begin::Logo-->
						<a href="{{route('login.show')}}" class="mb-5">
							<img alt="Logo" src="{{ asset('assets/static/main-logo.png') }}" />
						</a>
						<!--end::Logo-->
						<!--begin::Title-->
						
						<!--end::Title-->
					</div>
					<!--begin::Aside-->
				</div>
				<!--begin::Aside-->
				<!--begin::Body-->
				<div class="p-12 d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-lg-20">
					<!--begin::Card-->
					<div class="p-20 bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px">
						<!--begin::Wrapper-->
						<div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
							<!--begin::Form-->
							<form method="POST" action="{{route('login.post')}}" class="form w-100 row" >
                                @csrf
								<!--begin::Heading-->
								<div class="text-center mb-11">
									<!--begin::Title-->
									<h1 class="mb-3 text-dark fw-bolder">{{ __('messages.auth.sign_in') }}</h1>
									<!--end::Title-->
									<!--begin::Subtitle-->
									<div class="text-gray-500 fw-semibold fs-6">{{ __('messages.auth.acc_credentials') }}</div>
									<!--end::Subtitle=-->
								</div>
								<!--begin::Heading-->
								<!--begin::Separator-->
								<div class="separator separator-content my-14">
									<span class="text-gray-500 w-125px fw-semibold fs-7">{{ __('messages.auth.enter_your_informations') }}</span>
								</div>
								<!--end::Separator-->
								<!--begin::Input group=-->
								<div class="mb-8 fv-row form-group">
									<!--begin::Email-->
									<input class="form-control bg-transparent @" name="tc" maxlength="11" placeholder="{{ __('models.user.tc') }}" type="text" autocomplete="off" />
                                    <x-form-invalid name='tc' />
									<!--end::Email-->
								</div>
								<!--end::Input group=-->
								<div class="mb-3 fv-row form-group">
									<!--begin::Password-->
									<input class="bg-transparent form-control" name="password" placeholder="{{ __('models.user.password') }}"  type="password" autocomplete="off"  />
                                    <x-form-invalid name='password' />
									<!--end::Password-->
								</div>
								<!--end::Input group=-->
								<!--begin::Wrapper-->
								<div class="flex-wrap gap-3 mb-8 d-flex flex-stack fs-base fw-semibold d-none">
									<div></div>
									<!--begin::Link-->
									<a href="#" class="link-primary">{{ __('messages.auth.forgot_password') }}</a>
									<!--end::Link-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Submit button-->
								<div class="mb-10 d-grid">
									<button type="submit" class="btn btn-primary">
										{{ __('messages.auth.sign_in') }}
									</button>
								</div>
								<!--end::Submit button-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::Wrapper-->
                        @include('backend.layout.messages')
						<!--begin::Footer-->
						<div class="d-flex flex-stack px-lg-10 d-none">
							<!--begin::Languages-->
							<div class="me-0">
								<!--begin::Toggle-->
								<button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
									<img class="rounded w-20px h-20px me-3" src="{{ asset('assets/media/flags/'.(app()->getLocale() == 'tr' ? 'turkey' : 'united-states').'.svg') }}" alt="" />
									<span class="me-1">{{ app()->getLocale() == 'tr' ? 'Türkçe' : 'English' }}</span>
									<i class="m-0 rotate-180 ki-duotone ki-down fs-5 text-muted"></i>
								</button>
								<div class="py-4 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
									<div class="px-3 menu-item">
										<a hd-toggle-lang='en' href="#" class="px-5 menu-link d-flex">
											<span class="symbol symbol-20px me-4">
												<img class="rounded-1" src="{{ asset('assets/media/flags/united-states.svg') }}" alt="" />
											</span>
											<span>English</span>
										</a>
									</div>
									<div class="px-3 menu-item">
										<a hd-toggle-lang='tr' href="#" class="px-5 menu-link d-flex">
											<span class="symbol symbol-20px me-4">
												<img class="rounded-1" src="{{ asset('assets/media/flags/turkey.svg') }}" alt="" />
											</span>
											<span>Türkçe</span>
										</a>
									</div>
								</div>
								<!--end::Menu-->
							</div>
							<!--end::Languages-->
							<!--begin::Links-->
							<div class="gap-5 d-flex fw-semibold text-primary fs-base">
								<a href="../../demo9/dist/pages/team.html" target="_blank">Terms</a>
								<a href="../../demo9/dist/pages/pricing/column.html" target="_blank">Plans</a>
								<a href="../../demo9/dist/pages/contact.html" target="_blank">Contact Us</a>
							</div>
							<!--end::Links-->
						</div>
						<!--end::Footer-->
					</div>
					<!--end::Card-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->
		<!--end::Main-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Custom Javascript(used for this page only)-->
        <script>
            $(document).ready(function () {
                const errors = $('.invalid-feedback')
                $.each(errors, function (index, element) {
                    $(element).parents('.form-group').find('.form-control').toggleClass('is-invalid', true)
                });
            });
        </script>
        @routes()
        @vite('resources/js/app.js')
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>