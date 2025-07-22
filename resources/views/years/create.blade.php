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
                    <h3 class="mb-0">General Form</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{route('years.index')}}">Year List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">General Form</li>
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
            <div class="row g-4">
                <!--begin::Col-->
                <div class="col-md-12">
                    <!--begin::Quick Example-->
                    <div class="card card-primary card-outline mb-4">
                        <!--begin::Header-->
                        <div class="card-header">
                            <div class="card-title">Add Year</div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Form-->
                        <form method="POST" action="{{route('years.store')}}">
                            @csrf
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="row">
                                <div class="col-md-6 mb-6">
                                    <label for="validationCustom04" class="form-label">Make</label>
                                    <select class="form-select" name="make_id" id="makeSelect" required>
                                        <option selected disabled value="">Choose the make</option>
                                        @foreach($makes as $make)
                                        <option value="{{$make->id}}">{{$make->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a valid make.</div>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label for="validationCustom04" class="form-label">Model</label>
                                    <select class="form-select" name="model_id" id="modelSelect" required>
                                        <option selected disabled value="">Choose the model</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a valid make.</div>
                                </div>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="exampleInputMake" class="form-label">Year</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="exampleInputMake"
                                        name="year" />
                                    <div id="yearHelp" class="form-text">
                                        Enter multiple years separated by commas. Example: 1998, 1999, 2000.
                                    </div>
                                
                                </div>
                            </div>
                            <!--end::Body-->
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <!--begin::Footer-->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <!--end::Footer-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Quick Example-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
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