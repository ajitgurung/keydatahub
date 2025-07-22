@extends('layouts.app')

@section('content')
<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Info Table</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Info Table</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <a href="{{ route('infos.create') }}">
                                <button class="btn btn-primary">Add New</button>
                            </a>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th class="d-none d-md-table-cell" style="width: 30%">Make</th>
                                        <th style="width: 30%">Model</th>
                                        <th style="width: 10%">Year</th>
                                        <th style="width: 25%" class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($infos as $info)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="d-none d-md-table-cell">{{ $info->year->model->make->name ?? '-' }}</td>
                                        <td>{{ $info->year->model->name ?? '-' }}</td>
                                        <td>{{ $info->year->year ?? '-' }}</td>
                                        <td class="text-end">
                                            <div class="d-flex flex-wrap justify-content-end gap-1">
                                                <button class="btn btn-sm btn-outline-secondary view-info-btn" data-info-id="{{ $info->id }}">View</button>
                                                <a href="{{ route('infos.edit', $info->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                                <form action="{{ route('infos.destroy', $info->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($infos->hasPages())
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-center justify-content-md-end">
                                {{ $infos->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Info View Modal -->
                    <div class="modal fade" id="infoViewModal" tabindex="-1" aria-labelledby="infoViewModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="infoViewModalLabel">Info Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="infoContent">Loading...</div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<!-- Info Modal Script -->
<script>
    document.querySelectorAll('.view-info-btn').forEach(button => {
        button.addEventListener('click', () => {
            const infoId = button.getAttribute('data-info-id');
            const modal = new bootstrap.Modal(document.getElementById('infoViewModal'));

            document.getElementById('infoContent').innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>`;

            fetch(`/infos/${infoId}`)
                .then(response => response.json())
                .then(data => {
                    let html = `
                        <div class="mb-4 text-center">
                            <h4 class="fw-bold">${data.make_name} - ${data.model_name} (${data.year})</h4>
                        </div>`;

                    for (const [section, keyValues] of Object.entries(data.info)) {
                        html += `
                            <div class="mb-4">
                                <h5 class="text-primary border-start border-4 ps-3 mb-3">${section.replace('_', ' ').toUpperCase()}</h5>
                                <dl class="row">`;

                        for (const [key, value] of Object.entries(keyValues)) {
                            html += `
                                <dt class="col-sm-4 text-muted">${key}</dt>
                                <dd class="col-sm-8">${value}</dd>`;
                        }

                        html += `</dl><hr></div>`;
                    }

                    document.getElementById('infoContent').innerHTML = html;
                })
                .catch(() => {
                    document.getElementById('infoContent').innerHTML = `
                        <div class="alert alert-danger text-center" role="alert">
                            Failed to load info. Please try again later.
                        </div>`;
                });

            modal.show();
        });
    });
</script>
@endsection
