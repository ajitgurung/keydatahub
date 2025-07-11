@extends('layouts.app')
@section('content')
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Make</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('makes.index') }}">List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Make</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title">Edit Make</div>
                        </div>
                        <form method="POST" action="{{ route('makes.update', $make->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="exampleInputMake" class="form-label">Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="exampleInputMake"
                                        name="name"
                                        value="{{ old('name', $make->name) }}" />
                                </div>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" id="inputGroupFile02" name="image" aria-describedby="imageHelp" />
                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                </div>
                                <div id="imageHelp" class="form-text">
                                    Accepted formats: JPG, PNG, GIF, WEBP. Max size: 2MB.
                                </div>
                                @if($make->image)
                                    <div class="mt-3">
                                        <p>Current Image:</p>
                                        <img src="{{ asset('storage/' . $make->image) }}" alt="Make Image" class="img-fluid rounded" style="max-height:150px;">
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('makes.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
