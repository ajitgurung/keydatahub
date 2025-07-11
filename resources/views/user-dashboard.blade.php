@extends('layouts.app')
@section('content')
<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Vehicle Info</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Vehicle Info</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title">View Info</div>
                        </div>
                        <div class="card-body">
                            <!-- Make/Model/Year Select -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="makeSelect">Make</label>
                                    <select class="form-select" id="makeSelect" required>
                                        <option selected disabled value="">Choose the make</option>
                                        @foreach($makes as $make)
                                        <option value="{{ $make->id }}">{{ $make->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="modelSelect">Model</label>
                                    <select class="form-select" id="modelSelect" required disabled>
                                        <option selected disabled value="">Choose the model</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="yearSelect">Year</label>
                                    <select class="form-select" id="yearSelect" required disabled>
                                        <option selected disabled value="">Choose the year</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Info Output Section -->
                            <div id="infoDisplayContainer" class="mt-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<script>
    const makeSelect = document.getElementById('makeSelect');
    const modelSelect = document.getElementById('modelSelect');
    const yearSelect = document.getElementById('yearSelect');
    const infoDisplay = document.getElementById('infoDisplayContainer');

    makeSelect.addEventListener('change', function() {
        const makeId = this.value;
        fetch(`/get-models/${makeId}`)
            .then(res => res.json())
            .then(data => {
                modelSelect.innerHTML = '<option disabled selected>Choose the model</option>';
                data.forEach(model => {
                    modelSelect.innerHTML += `<option value="${model.id}">${model.name}</option>`;
                });
                modelSelect.disabled = false;
                yearSelect.disabled = true;
                yearSelect.innerHTML = '<option disabled selected>Choose the year</option>';
            });
    });

    modelSelect.addEventListener('change', function() {
        const modelId = this.value;
        fetch(`/get-years/${modelId}`)
            .then(res => res.json())
            .then(data => {
                yearSelect.innerHTML = '<option disabled selected>Choose the year</option>';
                data.forEach(year => {
                    yearSelect.innerHTML += `<option value="${year.id}">${year.year}</option>`;
                });
                yearSelect.disabled = false;
            });
    });

    yearSelect.addEventListener('change', function() {
        const yearId = this.value;
        fetch(`/info/${yearId}`)
            .then(res => res.json())
            .then(data => {
                let html = '';
                if (data && data.sections && Object.keys(data.sections).length > 0) {
                    // Loop over section groups
                    for (const sectionTitle in data.sections) {
                        html += `<div class="mb-4 p-3 border rounded bg-light shadow-sm">`;
                        html += `<h5 class="mb-3 text-primary">${sectionTitle.replace(/_/g, ' ').toUpperCase()}</h5>`;
                        const items = data.sections[sectionTitle];
                        html += `<table class="table table-sm table-borderless mb-0">`;
                        for (const key in items) {
                            html += `
            <tr>
                <th style="width: 30%; text-transform: capitalize;">${key.replace(/_/g, ' ')}</th>
                <td>${items[key]}</td>
            </tr>
        `;
                        }
                        html += `</table></div>`;
                    }
                    if (data.image_url) {
                        html += `
        <div class="mt-4 text-center">
            <img src="${data.image_url}" alt="Image" class="img-fluid rounded" style="max-height: 300px;">
        </div>
    `;
                    }

                } else {
                    html = `<p class="text-muted">No information available for this selection.</p>`;
                }
                infoDisplay.innerHTML = html;
            });
    });
</script>

@endsection