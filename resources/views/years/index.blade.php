@extends('layouts.app')

@section('content')
<main class="app-main">

    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Year Table</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Year Table</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <a href="{{ route('years.create') }}">
                                <button class="btn btn-primary">Add New</button>
                            </a>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th class="d-none d-md-table-cell" style="width: 30%;">Make</th>
                                        <th style="width: 30%;">Model</th>
                                        <th style="width: 10%;">Year</th>
                                        <th style="width: 25%;" class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($years as $year)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="d-none d-md-table-cell">{{ $year->model->make->name ?? '—' }}</td>
                                        <td>{{ $year->model->name ?? '—' }}</td>
                                        <td>{{ $year->year }}</td>
                                        <td class="text-end">
                                            <div class="d-flex flex-wrap justify-content-end gap-1">
                                                <a href="{{ route('years.edit', $year->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                                <form action="{{ route('years.destroy', $year->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this year?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($years->hasPages())
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-center justify-content-md-end">
                                {{ $years->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content-->

</main>
@endsection
