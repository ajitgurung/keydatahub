@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Edit User</h2>
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">← Back to Users</a>
            </div>

            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    {{-- MAIN USER UPDATE FORM --}}
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

                    {{-- SEPARATE FORM: Cancel Subscription --}}
                    @if($user->subscription('default') && $user->subscription('default')->valid())
                    <form action="{{ route('users.cancel-subscription', $user->id) }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-warning w-100">
                            Cancel Subscription
                        </button>
                    </form>
                    @endif

                    {{-- SEPARATE FORM: Send Reset Link --}}
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
@endsection
