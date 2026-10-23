@extends('layouts.auth')

@section('title', 'Reset password')

@section('content')
	<form class="login-form" method="POST" action="{{ route('password.update') }}">
		@csrf
		<input type="hidden" name="token" value="{{ $token }}">

		<div class="card mb-0">
			<div class="card-body">
				<div class="text-center mb-3">
					<div class="d-inline-flex bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-3 mb-3 mt-1">
						<i class="ph-lock-key ph-2x"></i>
					</div>
					<h5 class="mb-0">Set new password</h5>
					<span class="d-block text-muted">Enter your email and a new password</span>
				</div>

				<div class="mb-3">
					<label class="form-label">Your email</label>
					<div class="form-control-feedback form-control-feedback-start">
						<input type="email" name="email" value="{{ old('email', $email) }}" class="form-control @error('email') is-invalid @enderror" required>
						<div class="form-control-feedback-icon">
							<i class="ph-at text-muted"></i>
						</div>
					</div>
					@error('email')
						<div class="text-danger fs-sm mt-1">{{ $message }}</div>
					@enderror
				</div>

				<div class="mb-3">
					<label class="form-label">New password</label>
					<div class="form-control-feedback form-control-feedback-start">
						<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
						<div class="form-control-feedback-icon">
							<i class="ph-lock text-muted"></i>
						</div>
					</div>
					@error('password')
						<div class="text-danger fs-sm mt-1">{{ $message }}</div>
					@enderror
				</div>

				<div class="mb-3">
					<label class="form-label">Confirm password</label>
					<div class="form-control-feedback form-control-feedback-start">
						<input type="password" name="password_confirmation" class="form-control" required>
						<div class="form-control-feedback-icon">
							<i class="ph-lock text-muted"></i>
						</div>
					</div>
				</div>

				<button type="submit" class="btn btn-primary w-100">Update password</button>
			</div>
		</div>
	</form>
@endsection
