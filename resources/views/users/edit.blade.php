@extends('layouts.app')

@section('content')
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit User</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" id="role" class="form-select">
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                        <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>Editor</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    @error('role')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary">Update User</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                </div>
                            </form>

                            @php
                            $subscription = $user->subscription('default');
                            @endphp

                            @if($subscription)
                                @if($subscription->onGracePeriod())
                                <form action="{{ route('users.end-grace-period', $user->id) }}" method="POST" class="mt-3">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100">
                                        End Subscription Now
                                    </button>
                                </form>
                                @elseif($subscription->valid())
                                <form action="{{ route('users.cancel-subscription', $user->id) }}" method="POST" class="mt-3">
                                    @csrf
                                    <button type="submit" class="btn btn-warning w-100">
                                        Cancel Subscription
                                    </button>
                                </form>
                                @endif
                            @endif

                            <form action="{{ route('users.send-reset-link', $user->id) }}" method="POST" class="mt-3">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary w-100">
                                    Send Password Reset Link
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content-->
</main>
@endsection
