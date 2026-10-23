<div class="mb-3">
	<label class="form-label">Name: <span class="text-danger">*</span></label>
	<input type="text" name="name" value="{{ old('name', $location->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Singapore">
	@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="row">
	<div class="col-md-6 mb-3">
		<label class="form-label">Latitude: <span class="text-danger">*</span></label>
		<input type="text" name="lat" value="{{ old('lat', $location->lat) }}" class="form-control @error('lat') is-invalid @enderror" placeholder="1.3">
		@error('lat')<div class="invalid-feedback">{{ $message }}</div>@enderror
	</div>

	<div class="col-md-6 mb-3">
		<label class="form-label">Longitude: <span class="text-danger">*</span></label>
		<input type="text" name="lng" value="{{ old('lng', $location->lng) }}" class="form-control @error('lng') is-invalid @enderror" placeholder="103.8">
		@error('lng')<div class="invalid-feedback">{{ $message }}</div>@enderror
	</div>
</div>

<div class="mb-3">
	<label class="form-label">Status:</label>
	<select name="status" class="form-select @error('status') is-invalid @enderror">
		<option value="">-- None --</option>
		@foreach (\App\Models\Location::STATUSES as $status)
			<option value="{{ $status }}" @selected(old('status', $location->status) === $status)>{{ ucfirst($status) }}</option>
		@endforeach
	</select>
	@error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="d-flex">
	<a href="{{ route('locations.index') }}" class="btn btn-light">Cancel</a>
	<button type="submit" class="btn btn-primary ms-auto">Save <i class="ph-paper-plane-tilt ms-2"></i></button>
</div>
