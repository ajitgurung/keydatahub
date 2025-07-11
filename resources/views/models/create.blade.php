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
                        <li class="breadcrumb-item"><a href="{{route('models.index')}}">Model List</a></li>
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
                            <div class="card-title">Add Model</div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Form-->
                        <form method="POST" action="{{route('models.store')}}">
                            @csrf
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="mb-6">
                                    <label for="validationCustom04" class="form-label">Make</label>
                                    <select class="form-select" id="validationCustom04" name="make_id" required>
                                        <option selected disabled value="">Choose the make</option>
                                        @foreach($makes as $make)
                                        <option value="{{$make->id}}">{{$make->name}}</option>
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
                                        name="name" />
                                    <div id="modelHelp" class="form-text">
                                        Enter multiple model names separated by commas. Example: Civic, Accord, CR-V.
                                    </div>      
                                </div>
                            </div>
                            <!--end::Body-->
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
@endsection