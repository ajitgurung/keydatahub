@extends('layouts.app')
@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Info</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('infos.index') }}">Info List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Info</li>
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
                            <div class="card-title">Edit Info</div>
                        </div>
                        <form method="POST" action="{{route('infos.update', $info->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Make</label>
                                        <input class="form-control" value="{{ $info->year->model->make->name }}" readonly />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Model</label>
                                        <input class="form-control" value="{{ $info->year->model->name }}" readonly />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Year</label>
                                        <input class="form-control" value="{{ $info->year->year }}" readonly />
                                    </div>
                                </div>
                                <div id="infoSectionsContainer">
                                    @php
                                        $sections = json_decode($info->info, true);
                                        $sectionIndex = 0;
                                    @endphp
                                    @foreach($sections as $title => $entries)
                                    <div class="border p-3 mb-3">
                                        <div class="mb-2">
                                            <label class="form-label">Section Title</label>
                                            <input type="text" name="sections[section_{{ $sectionIndex }}][title]" value="{{ $title }}" class="form-control" required>
                                        </div>
                                        <div id="section_{{ $sectionIndex }}_fields">
                                            @foreach($entries as $key => $value)
                                            <div class="input-group mb-2">
                                                <input type="text" name="sections[section_{{ $sectionIndex }}][keys][]" class="form-control" value="{{ $key }}" placeholder="Key">
                                                <input type="text" name="sections[section_{{ $sectionIndex }}][values][]" class="form-control" value="{{ $value }}" placeholder="Value">
                                                <button type="button" class="btn btn-outline-danger" onclick="this.parentNode.remove()">&minus;</button>
                                            </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="addField('section_{{ $sectionIndex }}')">+ Add Field</button>
                                        <button type="button" class="btn btn-outline-danger btn-sm mt-2" onclick="this.parentElement.remove()">Remove Section</button>
                                    </div>
                                    @php $sectionIndex++; @endphp
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-outline-primary mt-2" onclick="addInfoSection()">Add Info Section</button>

                                <br><br>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" id="inputGroupFile02" name="image" />
                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                </div>
                                @if($info->image)
                                    <div class="mt-3">
                                        <p>Current Image:</p>
                                        <img src="{{ asset('storage/' . $info->image) }}" alt="Info Image" class="img-fluid rounded" style="max-height:150px;">
                                    </div>
                                @endif
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
<script>
    let sectionIndex = {{ $sectionIndex ?? 0 }};

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
                <button type="button" class="btn btn-outline-danger" onclick="this.parentNode.remove()">&minus;</button>
            </div>
        </div>
        <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="addField('${sectionId}')">+ Add Field</button>
        <button type="button" class="btn btn-outline-danger btn-sm mt-2" onclick="this.parentElement.remove()">Remove Section</button>
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
        <button type="button" class="btn btn-outline-danger" onclick="this.parentNode.remove()">&minus;</button>
    `;
        fieldContainer.appendChild(div);
    }
</script>
@endsection
