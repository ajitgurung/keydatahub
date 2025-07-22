@extends('layouts.app')
@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Year</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('years.index') }}">Year List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Year</li>
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
                            <div class="card-title">Update Year</div>
                        </div>

                        <form method="POST" action="{{ route('years.update', $year->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-6">
                                        <label for="makeSelect" class="form-label">Make</label>
                                        <select class="form-select" name="make_id" id="makeSelect" required>
                                            <option disabled value="">Choose the make</option>
                                            @foreach($makes as $make)
                                            <option value="{{ $make->id }}" {{ $make->id == $year->make_id ? 'selected' : '' }}>
                                                {{ $make->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Please select a valid make.</div>
                                    </div>

                                    <div class="col-md-6 mb-6">
                                        <label for="modelSelect" class="form-label">Model</label>
                                        <select class="form-select" name="model_id" id="modelSelect" required>
                                            <option disabled value="">Choose the model</option>
                                            <option value="{{ $year->model->id }}" selected>
                                                {{ $year->model->name }}
                                            </option>
                                        </select>
                                        <div class="invalid-feedback">Please select a valid model.</div>
                                    </div>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="exampleInputMake" class="form-label">Year</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="exampleInputMake"
                                        name="year"
                                        value="{{ old('year', $year->year) }}"
                                        required />
                                    <div id="yearHelp" class="form-text">
                                        Enter a single year only (editing individual year entry).
                                    </div>
                                </div>
                            </div>
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

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

<script>
    document.getElementById('makeSelect').addEventListener('change', function() {
        const makeId = this.value;

        fetch(`/get-models/${makeId}`)
            .then(response => response.json())
            .then(data => {
                const modelSelect = document.getElementById('modelSelect');
                modelSelect.innerHTML = '<option disabled selected value="">Choose the model</option>';
                data.forEach(model => {
                    const option = document.createElement('option');
                    option.value = model.id;
                    option.textContent = model.name;
                    modelSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Fetch error:', error));
    });
</script>
@endsection