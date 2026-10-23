@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
	<div class="row">
		<div class="col-sm-6 col-xl-4">
			<div class="card card-body">
				<div class="d-flex align-items-center">
					<i class="ph-map-pin ph-2x text-primary me-3"></i>
					<div class="flex-fill text-end">
						<h4 class="mb-0">{{ $total }}</h4>
						<span class="text-muted">Total locations</span>
					</div>
				</div>
			</div>
		</div>

		@foreach ($stats as $status => $count)
			<div class="col-sm-6 col-xl-4">
				<div class="card card-body">
					<div class="d-flex align-items-center">
						<i class="ph-flag ph-2x {{ $status === 'active' ? 'text-success' : 'text-warning' }} me-3"></i>
						<div class="flex-fill text-end">
							<h4 class="mb-0">{{ $count }}</h4>
							<span class="text-muted text-capitalize">{{ $status ?: 'No status' }}</span>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>

	<div class="card">
		<div class="card-body">
			Welcome back, <strong>{{ auth()->user()->name }}</strong>.
			<a href="{{ route('locations.index') }}">Manage locations</a>
		</div>
	</div>
@endsection
