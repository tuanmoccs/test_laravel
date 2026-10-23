@extends('layouts.app')

@section('title', 'Create Location')
@section('page-title')
	Locations - <span class="fw-normal">Create</span>
@endsection

@section('content')
	<div class="card">
		<div class="card-header">
			<h5 class="mb-0">New location</h5>
		</div>

		<div class="card-body">
			<form method="POST" action="{{ route('locations.store') }}">
				@csrf
				@include('locations._form')
			</form>
		</div>
	</div>
@endsection
