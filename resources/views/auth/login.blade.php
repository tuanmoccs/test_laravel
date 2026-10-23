@extends('layouts.auth')

@section('title', 'Login')

@section('content')
	<form class="login-form" method="POST" action="{{ route('login') }}">
		@csrf
		<div class="card mb-0">
			<div class="card-body">
				<div class="text-center mb-3">
					<div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
						<img src="{{ asset('assets/images/logo_icon.svg') }}" class="h-48px" alt="">
					</div>
					<h5 class="mb-0">Login to your account</h5>
					<span class="d-block text-muted">Enter your credentials below</span>
				</div>

				@if (session('status'))
					<div class="alert alert-success">{{ session('status') }}</div>
				@endif

				<div class="mb-3">
					<label class="form-label">Email</label>
					<div class="form-control-feedback form-control-feedback-start">
						<input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="john@doe.com" required autofocus>
						<div class="form-control-feedback-icon">
							<i class="ph-user-circle text-muted"></i>
						</div>
					</div>
					@error('email')
						<div class="text-danger fs-sm mt-1">{{ $message }}</div>
					@enderror
				</div>

				<div class="mb-3">
					<label class="form-label">Password</label>
					<div class="form-control-feedback form-control-feedback-start">
						<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="•••••••••••" required>
						<div class="form-control-feedback-icon">
							<i class="ph-lock text-muted"></i>
						</div>
					</div>
					@error('password')
						<div class="text-danger fs-sm mt-1">{{ $message }}</div>
					@enderror
				</div>

				<div class="mb-3">
					<label class="form-check">
						<input type="checkbox" name="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
						<span class="form-check-label">Remember me</span>
					</label>
				</div>

				<div class="mb-3">
					<button type="submit" class="btn btn-primary w-100">Sign in</button>
				</div>

				<div class="text-center">
					<a href="{{ route('password.request') }}">Forgot password?</a>
				</div>
			</div>
		</div>
	</form>
@endsection
