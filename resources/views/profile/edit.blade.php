@extends('layouts.app')

@section('title', 'Profile')
@section('page-title')
	Profile - <span class="fw-normal">Edit</span>
@endsection

@section('content')
	<div class="card">
		<div class="card-header">
			<h5 class="mb-0">Account information</h5>
		</div>

		<div class="card-body">
			<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
				@csrf
				@method('PUT')

				<div class="mb-3">
					<label class="form-label">Name:</label>
					<input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
					@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
				</div>

				<div class="mb-3">
					<label class="form-label">Email:</label>
					<input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
					@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
				</div>

				<div class="mb-3">
					<label class="form-label">Gender:</label>
					<div>
						@foreach (['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $value => $label)
							<label class="form-check form-check-inline">
								<input type="radio" class="form-check-input" name="gender" value="{{ $value }}" {{ old('gender', $user->gender) === $value ? 'checked' : '' }}>
								<span class="form-check-label">{{ $label }}</span>
							</label>
						@endforeach
					</div>
					@error('gender')<div class="text-danger fs-sm">{{ $message }}</div>@enderror
				</div>

				<div class="mb-3">
					<label class="form-label">Your avatar:</label>
					@if ($user->avatar)
						<div class="mb-2">
							<img src="{{ asset('storage/' . $user->avatar) }}" class="w-64px h-64px rounded-pill" alt="">
						</div>
					@endif
					<input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror">
					<div class="form-text text-muted">Accepted formats: gif, png, jpg. Max file size 2Mb</div>
					@error('avatar')<div class="invalid-feedback">{{ $message }}</div>@enderror
				</div>

				<div class="mb-3">
					<label class="form-label">New password:</label>
					<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Leave blank to keep current password">
					@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
				</div>

				<div class="mb-3">
					<label class="form-label">Confirm password:</label>
					<input type="password" name="password_confirmation" class="form-control">
				</div>

				<div class="text-end">
					<button type="submit" class="btn btn-primary">Save changes <i class="ph-paper-plane-tilt ms-2"></i></button>
				</div>
			</form>
		</div>
	</div>
@endsection
