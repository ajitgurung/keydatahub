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
                <!--begin::Col-->
                <div class="col-lg-3 col-6">
                    <!--begin::Small Box Widget 1-->
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>150</h3>
                            <p>New Orders</p>
                        </div>
                        <svg
                            class="small-box-icon"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path
                                d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"></path>
                        </svg>
                        <a
                            href="#"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                    <!--end::Small Box Widget 1-->
                </div>
                <!--end::Col-->
                <div class="col-lg-3 col-6">
                    <!--begin::Small Box Widget 2-->
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>53<sup class="fs-5">%</sup></h3>
                            <p>Bounce Rate</p>
                        </div>
                        <svg
                            class="small-box-icon"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path
                                d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"></path>
                        </svg>
                        <a
                            href="#"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                    <!--end::Small Box Widget 2-->
                </div>
                <!--end::Col-->
                <div class="col-lg-3 col-6">
                    <!--begin::Small Box Widget 3-->
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>44</h3>
                            <p>User Registrations</p>
                        </div>
                        <svg
                            class="small-box-icon"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path
                                d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"></path>
                        </svg>
                        <a
                            href="#"
                            class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                    <!--end::Small Box Widget 3-->
                </div>
                <!--end::Col-->
                <div class="col-lg-3 col-6">
                    <!--begin::Small Box Widget 4-->
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>65</h3>
                            <p>Unique Visitors</p>
                        </div>
                        <svg
                            class="small-box-icon"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path
                                clip-rule="evenodd"
                                fill-rule="evenodd"
                                d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"></path>
                            <path
                                clip-rule="evenodd"
                                fill-rule="evenodd"
                                d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"></path>
                        </svg>
                        <a
                            href="#"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                    <!--end::Small Box Widget 4-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-7 connectedSortable">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Sales Value</h3>
                        </div>
                        <div class="card-body">
                            <div id="revenue-chart"></div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.Start col -->
                <!-- Start col -->
                <div class="col-lg-5 connectedSortable">
                    <div class="card text-white bg-primary bg-gradient border-primary mb-4">
                        <div class="card-header border-0">
                            <h3 class="card-title">Sales Value</h3>
                            <div class="card-tools">
                                <button
                                    type="button"
                                    class="btn btn-primary btn-sm"
                                    data-lte-toggle="card-collapse">
                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="world-map" style="height: 220px"></div>
                        </div>
                        <div class="card-footer border-0">
                            <!--begin::Row-->
                            <div class="row">
                                <div class="col-4 text-center">
                                    <div id="sparkline-1" class="text-dark"></div>
                                    <div class="text-white">Visitors</div>
                                </div>
                                <div class="col-4 text-center">
                                    <div id="sparkline-2" class="text-dark"></div>
                                    <div class="text-white">Online</div>
                                </div>
                                <div class="col-4 text-center">
                                    <div id="sparkline-3" class="text-dark"></div>
                                    <div class="text-white">Sales</div>
                                </div>
                            </div>
                            <!--end::Row-->
                        </div>
                    </div>
                </div>
                <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->

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