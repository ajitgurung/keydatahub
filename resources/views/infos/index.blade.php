@extends('layouts.app')
@section('content')
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
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
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-6">
                        <div class="card-header">
                            <a href="{{route('infos.create')}}"><button class="btn btn-primary">Add New</button></a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 30%">Make</th>
                                        <th style="width: 30%">Model</th>
                                        <th style="width: 10%">info</th>
                                        <th style="width: 25%">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($infos as $info)
                                    <tr class="align-middle">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$info->year->model->make->name}}</td>
                                        <td>{{$info->year->model->name}}</td>
                                        <td>{{$info->year->year}}</td>

                                        <td d-flex flex-wrap gap-2>
                                            <button class="btn btn-secondary view-info-btn" data-info-id="{{ $info->id }}">View</button>
                                            <a href="{{route('infos.edit', $info->id)}}"><button class="btn btn-primary">Edit</button></a>
                                            <form action="{{ route('infos.destroy', $info->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this info?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-end">
                                <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.card -->
                    <!-- Info View Modal -->
                    <div class="modal fade" id="infoViewModal" tabindex="-1" aria-labelledby="infoViewModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="infoViewModalLabel">Info Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Info content will be injected here -->
                                    <div id="infoContent">Loading...</div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>

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
                    <h4 class="fw-bold">${data.make_name} - ${data.model_name} (${data.year})</h4>`;

                    if (data.image) {
                        html += `<img src="${data.image}" alt="Info Image" class="img-fluid rounded shadow-sm mt-3" style="max-height: 200px;">`;
                    }

                    html += `</div>`;

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