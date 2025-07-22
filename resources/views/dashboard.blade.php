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
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    @php
    $makes = App\Models\Make::all();
    @endphp
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <!-- Total Active Subscribers -->
                <!--<div class="col-lg-3 col-6">-->
                <!--    <div class="small-box text-bg-primary">-->
                <!--        <div class="inner">-->
                <!--            <h3>{{ $totalSubscribers }}</h3>-->
                <!--            <p>Total Active Subscribers</p>-->
                <!--        </div>-->
                <!--        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">-->
                <!--            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zM8 11c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2 0-6 1-6 3v3h12v-3c0-2-4-3-6-3zM16 13c-.29 0-.62.02-.97.05a4.978 4.978 0 00-4.06 0C10.62 13.02 10.29 13 10 13c-2 0-6 1-6 3v3h12v-3c0-2-4-3-6-3z"/>-->
                <!--        </svg>-->
                <!--    </div>-->
                <!--</div>-->

                <!-- Monthly Subscribers -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>{{ $monthlySubscribers }}</h3>
                            <p>Monthly Subscribers</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M19 4h-1V2h-2v2H8V2H6v2H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2zm0 14H5V9h14v9zM12 12v5l4.28 2.54.72-1.21-3.5-2.08V12z" />
                        </svg>
                    </div>
                </div>

                <!-- Yearly Subscribers -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>{{ $yearlySubscribers }}</h3>
                            <p>Yearly Subscribers</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M17 3h-1V1h-2v2H10V1H8v2H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2zm0 16H7V8h10v11z" />
                        </svg>
                    </div>
                </div>

                <!-- Grace Period Subscribers -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-info">
                        <div class="inner">
                            <h3>{{ $gracePeriod }}</h3>
                            <p>Grace Period Subscribers</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M6 2v6h.01L10 11l-4 3.99V22h12v-7.01l-4-4.99 3.99-3.99H18V2H6zm8 14H10v-2h4v2z" />
                        </svg>
                    </div>
                </div>

                <!-- Canceled Subscribers -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>{{ $canceledSubscribers }}</h3>
                            <p>Canceled Subscribers</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.364 5.636a1 1 0 00-1.414 0L12 10.586 7.05 5.636a1 1 0 10-1.414 1.414L10.586 12l-4.95 4.95a1 1 0 101.414 1.414L12 13.414l4.95 4.95a1 1 0 001.414-1.414L13.414 12l4.95-4.95a1 1 0 000-1.414z" />
                        </svg>
                    </div>
                </div>
            </div>


            <!--end::Row-->

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
        <!--end::Container-->
    </div>
    <!--end::App Content-->
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