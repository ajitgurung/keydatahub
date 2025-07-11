@extends('layouts.app')

@section('content')
<main class="app-main py-5">
    <div class="container">
        <h2 class="mb-4 text-center">Profile</h2>

        <div class="row justify-content-center">
            <div class="col-md-8">
                {{-- Update Profile Info --}}
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">Update Profile Information</div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- Update Password --}}
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">Update Password</div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- Delete Account --}}
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">Delete Account</div>
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
