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
                    <h3 class="mb-0">Info Form</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{route('infos.index')}}">Info List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Info Form</li>
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
                            <div class="card-title">Add Info</div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Form-->
                        <form method="POST" action="{{route('infos.store')}}" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom04" class="form-label">Make</label>
                                        <select class="form-select" name="make_id" id="makeSelect" required>
                                            <option selected disabled value="">Choose the make</option>
                                            @foreach($makes as $make)
                                            <option value="{{$make->id}}">{{$make->name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Please select a valid make.</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom04" class="form-label">Model</label>
                                        <select class="form-select" name="model_id" id="modelSelect" required>
                                            <option selected disabled value="">Choose the model</option>
                                        </select>
                                        <div class="invalid-feedback">Please select a valid make.</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom04" class="form-label">Year</label>
                                        <select class="form-select" name="year_id" id="yearSelect" required>
                                            <option selected disabled value="">Choose the year</option>
                                        </select>
                                        <div class="invalid-feedback">Please select a valid make.</div>
                                    </div>
                                </div>
                                <div id="infoSectionsContainer"></div>
                                <button type="button" class="btn btn-outline-primary mt-2" onclick="addInfoSection()" id="addInfoBtn" disabled>Add Info Section</button>

                                <br>
                                <br>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" id="inputGroupFile02" name="image" aria-describedby="imageHelp" />
                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                </div>
                                <div id="imageHelp" class="form-text">
                                    Accepted formats: JPG, PNG, GIF, WEBP. Max size: 2MB.
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

    document.getElementById('modelSelect').addEventListener('change', function() {
        const modelId = this.value;
        console.log(modelId);

        fetch(`/get-years/${modelId}`)
            .then(response => response.json())
            .then(data => {
                const yearSelect = document.getElementById('yearSelect');
                yearSelect.innerHTML = '<option disabled selected value="">Choose the year</option>';
                data.forEach(year => {
                    const option = document.createElement('option');
                    option.value = year.id;
                    option.textContent = year.year;
                    yearSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Fetch error:', error));

    });

    // Add Section
    let sectionIndex = 0;

    function addInfoSection() {
        const container = document.getElementById('infoSectionsContainer');
        const sectionId = `section_${sectionIndex++}`;

        const section = document.createElement('div');
        section.className = 'border p-3 mb-3';
        section.innerHTML = `
        <div class="mb-2">
            <label class="form-label">Section Title</label>
            <input type="text" name="sections[${sectionId}][title]" class="form-control" placeholder="e.g. Primary Key Blank" required>
        </div>
        <div id="${sectionId}_fields">
            <div class="input-group mb-2">
                <input type="text" name="sections[${sectionId}][keys][]" class="form-control" placeholder="Key">
                <input type="text" name="sections[${sectionId}][values][]" class="form-control" placeholder="Value">
                <button type="button" class="btn btn-outline-secondary" onclick="addField('${sectionId}')">+</button>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="this.parentElement.remove()">Remove Section</button>
    `;

        container.appendChild(section);
    }

    function addField(sectionId) {
        const fieldContainer = document.getElementById(`${sectionId}_fields`);
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
        <input type="text" name="sections[${sectionId}][keys][]" class="form-control" placeholder="Key">
        <input type="text" name="sections[${sectionId}][values][]" class="form-control" placeholder="Value">
        <button type="button" class="btn btn-outline-danger" onclick="this.parentNode.remove()">−</button>
    `;
        fieldContainer.appendChild(div);
    }

    // Enable / Disable Add Info Button

    document.getElementById('yearSelect').addEventListener('change', function() {
        const yearId = this.value;
        const btn = document.getElementById('addInfoBtn');

        if (!yearId) {
            btn.disabled = true;
            return;
        }

        fetch(`/check-info/${yearId}`)
            .then(response => response.json())
            .then(data => {
                btn.disabled = data.exists;
            })
            .catch(error => {
                console.error('Error checking info:', error);
                btn.disabled = true;
            });
    });

    // Info Div 
    ['makeSelect', 'modelSelect', 'yearSelect'].forEach(id => {
        document.getElementById(id).addEventListener('change', function() {
            document.getElementById('infoSectionsContainer').innerHTML = '';
        });
    });
</script>
@endsection