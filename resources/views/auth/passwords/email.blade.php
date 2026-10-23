@extends('layouts.auth')

@section('title', 'Password recovery')

@section('content')
	<form class="login-form" method="POST" action="{{ route('password.email') }}">
		@csrf
		<div class="card mb-0">
			<div class="card-body">
				<div class="text-center mb-3">
					<div class="d-inline-flex bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-3 mb-3 mt-1">
						<i class="ph-arrows-counter-clockwise ph-2x"></i>
					</div>
					<h5 class="mb-0">Password recovery</h5>
					<span class="d-block text-muted">We'll send you instructions in email</span>
				</div>

				@if (session('status'))
					<div class="alert alert-success">{{ session('status') }}</div>
				@endif

				<div class="mb-3">
					<label class="form-label">Your email</label>
					<div class="form-control-feedback form-control-feedback-start">
						<input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="john@doe.com" required autofocus>
						<div class="form-control-feedback-icon">
							<i class="ph-at text-muted"></i>
						</div>
					</div>
					@error('email')
						<div class="text-danger fs-sm mt-1">{{ $message }}</div>
					@enderror
				</div>

				<button type="submit" class="btn btn-primary w-100">
					<i class="ph-arrow-counter-clockwise me-2"></i>
					Reset password
				</button>

				<div class="text-center mt-3">
					<a href="{{ route('login') }}">Back to login</a>
				</div>
			</div>
		</div>
	</form>
@endsection
