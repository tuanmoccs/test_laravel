@extends('layouts.app')

@section('title', 'Edit Location')
@section('page-title')
	Locations - <span class="fw-normal">Edit</span>
@endsection

@section('content')
	<div class="card">
		<div class="card-header">
			<h5 class="mb-0">Edit location #{{ $location->id }}</h5>
		</div>

		<div class="card-body">
			<form method="POST" action="{{ route('locations.update', $location) }}">
				@csrf
				@method('PUT')
				@include('locations._form')
			</form>
		</div>
	</div>
@endsection
