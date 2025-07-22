@extends('layouts.app')

@section('content')
<main class="app-main">

    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">User Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">

            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form method="GET" action="{{ route('users.index') }}" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>

            <div class="card shadow-sm rounded">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th>Name</th>
                                <th class="d-none d-md-table-cell">Email</th>
                                <th>Role</th>
                                <th class="d-none d-md-table-cell">Verified</th>
                                <th class="d-none d-md-table-cell">Subscribed</th>
                                <th class="d-none d-md-table-cell">Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                            <tr>
                                <td>{{ $users->firstItem() + $index }}</td>
                                <td>{{ $user->name }}</td>
                                <td class="d-none d-md-table-cell">{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : 'secondary' }}">
                                        {{ ucfirst($user->role ?? 'User') }}
                                    </span>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    @if($user->email_verified_at)
                                    <span class="badge bg-success">Yes</span>
                                    @else
                                    <span class="badge bg-warning text-dark">No</span>
                                    @endif
                                </td>
                                <td class="d-none d-md-table-cell">
                                    @php $subscription = $user->subscription('default'); @endphp

                                    @if ($user->isAdmin() || $user->isEditor())
                                        <span class="badge bg-primary">Lifetime Access</span>
                                    @elseif ($subscription && $subscription->onGracePeriod())
                                        <span class="badge bg-danger">Cancelled</span>
                                    @elseif ($subscription && $subscription->ended())
                                        <span class="badge bg-danger">Expired</span>
                                    @elseif ($subscription && $subscription->valid())
                                        <span class="badge bg-success">Subscribed</span>
                                    @else
                                        <span class="badge bg-secondary">Not Subscribed</span>
                                    @endif
                                </td>
                                <td class="d-none d-md-table-cell">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="text-end">
                                    <div class="d-flex flex-wrap justify-content-end gap-1">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">No users found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-center">
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
    <!--end::App Content-->
</main>
@endsection
