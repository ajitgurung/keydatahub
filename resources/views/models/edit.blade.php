@extends('layouts.app')
@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Model</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('models.index') }}">Model List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Model</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title">Update Model</div>
                        </div>

                        <form method="POST" action="{{ route('models.update', $model->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="mb-6">
                                    <label for="validationCustom04" class="form-label">Make</label>
                                    <select class="form-select" id="validationCustom04" name="make_id" required>
                                        <option disabled value="">Choose the make</option>
                                        @foreach($makes as $make)
                                            <option value="{{ $make->id }}" {{ $make->id == $model->make_id ? 'selected' : '' }}>
                                                {{ $make->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a valid make.</div>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="exampleInputMake" class="form-label">Model Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="exampleInputMake"
                                        name="name"
                                        value="{{ old('name', $model->name) }}"
                                        required />
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
