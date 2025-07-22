@extends('layouts.app')

@section('content')
<main class="app-main">

    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Make Table</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Make Table</li>
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
                            <a href="{{ route('makes.create') }}">
                                <button class="btn btn-primary">Add New</button>
                            </a>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 40px;">#</th>
                                        <th>Name</th>
                                        <th class="d-none d-md-table-cell">Image</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($makes as $make)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $make->name }}</td>
                                        <td class="d-none d-md-table-cell">
                                            @if ($make->image)
                                            <img src="{{ asset('storage/' . $make->image) }}" alt="{{ $make->name }}" class="img-size-50 rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                            <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex flex-wrap justify-content-end gap-1">
                                                <a href="{{ route('makes.edit', $make->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                                <form action="{{ route('makes.destroy', $make->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this make?');">
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

                        @if ($makes->hasPages())
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-center justify-content-md-end">
                                {{ $makes->links('pagination::bootstrap-5') }}
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
