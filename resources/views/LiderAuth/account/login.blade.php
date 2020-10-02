@if(Auth::check())
 <meta http-equiv="refresh" content="0;URL=home/page">
@endif

@extends('LiderAuth.layouts.appLogin')
@section('content')
		<!-- begin:: Page -->
		<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
			<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v1" id="kt_login">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">

					<!--begin::Aside-->
					<div class="kt-grid__item kt-grid__item--order-tablet-and-mobile-2 kt-grid kt-grid--hor kt-login__aside" style="background-color:rgb(16, 37, 77); background-image: url(assets/media/bg/bg-2.jpg)">
						<div class="kt-grid__item">
							<a href="{{ asset('img/logo-topo21-white_pqno.png') }}" class="kt-login__logo">
							</a>
						</div>
						<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver">
							<div class="kt-grid__item kt-grid__item--middle">
                                <div class="col-md-8 kt-margin-50">
                                    <img src="{{ asset('img/logo-topo21-white_pqno.png') }}" class="col-md-10">
                                    <img src="{{ asset('img/bookLogo.png') }}" class="col-md-12">
                                </div>
							</div>
						</div>
						<div class="kt-grid__item">
							<div class="kt-login__info">
								<div class="kt-login__copyright">
									&copy {{ date('Y') }} {{str_replace('_',' ',env("APP_NAME"))}}
								</div>

							</div>
						</div>
					</div>

					<!--begin::Aside-->

					<!--begin::Content-->
					<div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">

						<!--begin::Head-->


						<!--end::Head-->

						<!--begin::Body-->
						<div class="kt-login__body">

							<!--begin::Signin-->
							<div class="kt-login__form">
								<div class="kt-login__title">
									<h3>Login</h3>
								</div>

								<!--begin::Form-->

								<form method="POST" class="kt-form col-md-8" action="{{ route('login') }}">
									@csrf

									<div class="form-group">
										{{-- <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Usuário') }}</label> --}}


											<input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="{{ __('Usuário') }}">

											@error('username')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>



									<div class="form-group row">
										{{-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label> --}}


											<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Senha') }}">

											@error('password')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror

									</div>

									<div class="form-group">

											<div class="kt-login__actions">
												<button type="submit" id="kt_login_signin_submit" class="btn btn-primary btn-elevate kt-login__btn-primary">
													{{ __('Login') }}
                                                </button>
                                                <a href="https://suporte.ativy.com" type="button" role="button" class="kt-link kt-login__link-forgot">
													Esqueceu sua senha?
												</a>
                                            </div>
                                            {{-- <div class="kt-login__actions">
                                                <a target="_blank" href="{{asset('storage/posts/J5vxWptNHOI6jEHsF3sRtv0lSAgHAtHxFgH2vNrT.pdf')}}" type="submit" class="btn btn-dark btn-elevate kt-login__btn-dark col-md-12">
													{{ __('POLITICA DE
                                                    SEGURANÇA DA
                                                    INFORMAÇÃO') }}
												</a>
                                            </div> --}}

									</div>
								</form>

								<!--end::Form-->

								<!--begin::Divider-->
								<div class="kt-login__divider">

								</div>

@endsection
