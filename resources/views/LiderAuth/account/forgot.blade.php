@extends('LiderAuth.layouts.appLogin')
@section('content')
<div style="background-color:rgb(16, 37, 77); background-image: url(assets/media/bg/bg-2.jpg);padding:10rem;">
		<!-- begin:: Page -->
		<div class="kt-grid kt-grid--ver kt-grid--root kt-page col-md-12">
			<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v1" id="kt_login">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">

					<!--begin::Content-->
					<div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">

						<!--begin::Head-->
						

						<!--end::Head-->

						<!--begin::Body-->
						<div class="kt-login__body">

							<!--begin::Signin-->
							<div class="kt-login__form">
								<div class="kt-login__title">
									<h3>Redefinir senha</h3>
								</div>

								<!--begin::Form-->
								
								<form method="POST" class="kt-form col-md-8" action="{{ route('forgotPost') }}">
									@csrf
			
									<div class="form-group">										
                                        <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="{{ __('Usuário') }}">
			
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
									</div>
			
									
			
									<div class="form-group row">
										{{-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label> --}}
			
										
											<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Digite a senha mais recente que você lembra') }}">
			
											@error('password')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										
									</div>
			
									<div class="form-group">
                                        <div class="kt-login__actions" style="text-align:center;">
                                            <button type="submit" id="kt_login_signin_submit" style="width:100%" class="btn btn-primary btn-elevate kt-login__btn-primary">
                                                {{ __('Redefinir') }}
                                            </button>
                                        </div>
                                        <p style="width:100%; text-align:center">&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;&ndash; 
                                            Ou &ndash;&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;
                                        </p>
                                        <div class="kt-login__actions">
                                            <a href="mailto:leandro.freitas@liderancacobrancas.com.br" style="width:100%" type="button" id="kt_login_signin_submit" class="btn btn-dark btn-elevate kt-login__btn-primary" role="button">
                                                {{ __('Abrir chamado via e-mail') }}
                                            </a>
                                        </div>
										
									</div>
								</form>

								<!--end::Form-->

								<!--begin::Divider-->
								<div class="kt-login__divider">
								
								</div>
</div>
@endsection