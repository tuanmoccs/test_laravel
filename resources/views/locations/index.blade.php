@extends('layouts.app')

@section('title', 'Locations')
@section('page-title')
	Locations - <span class="fw-normal">List</span>
@endsection

@section('page-actions')
	<a href="{{ route('locations.create') }}" class="btn btn-primary">
		<i class="ph-plus me-2"></i>
		Create location
	</a>
@endsection

@push('vendor-scripts')
	<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@section('content')
	<div class="card">
		<div class="card-header">
			<h5 class="mb-0">Locations</h5>
		</div>

		<table class="table datatable-locations">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Lat</th>
					<th>Lng</th>
					<th>Status</th>
					<th>Created at</th>
					<th class="text-center">Actions</th>
				</tr>
			</thead>
		</table>
	</div>
@endsection

@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const csrf = document.querySelector('meta[name="csrf-token"]').content;
			const escape = value => $('<div>').text(value ?? '').html();

			const table = $('.datatable-locations').DataTable({
				processing: true,
				serverSide: true,
				autoWidth: false,
				ajax: '{{ route('api.locations.index') }}',
				order: [[0, 'asc']],
				dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
				language: {
					search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
					searchPlaceholder: 'Type to filter...',
					lengthMenu: '<span class="me-3">Show:</span> _MENU_',
					paginate: { first: 'First', last: 'Last', next: '&rarr;', previous: '&larr;' }
				},
				columns: [
					{ data: 'id' },
					{ data: 'name', render: escape },
					{ data: 'lat', render: escape },
					{ data: 'lng', render: escape },
					{
						data: 'status',
						render: status => {
							if (!status) return '';
							const color = status === 'active' ? 'success' : 'warning';
							return `<span class="badge bg-${color} bg-opacity-10 text-${color}">${escape(status)}</span>`;
						}
					},
					{ data: 'created_at' },
					{
						data: null,
						orderable: false,
						searchable: false,
						className: 'text-center',
						render: row => `
							<div class="d-inline-flex">
								<a href="${row.edit_url}" class="text-body mx-1" title="Edit"><i class="ph-pen"></i></a>
								<a href="#" data-url="${row.delete_url}" class="text-danger mx-1 btn-delete" title="Delete"><i class="ph-trash"></i></a>
							</div>`
					}
				]
			});

			$('.datatable-locations').on('click', '.btn-delete', function (e) {
				e.preventDefault();
				if (!confirm('Delete this location?')) return;

				$.ajax({
					url: $(this).data('url'),
					type: 'DELETE',
					headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
				}).done(() => table.ajax.reload(null, false))
					.fail(() => alert('Could not delete this location.'));
			});
		});
	</script>
@endpush
