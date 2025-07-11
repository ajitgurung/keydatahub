<section class="mb-5">
    <header class="mb-3">
        <h2 class="h5 text-dark">Profile Information</h2>
        <p class="text-muted small">
            Update your account's profile information and email address.
        </p>
    </header>

    {{-- Form to resend verification email --}}
    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Profile update form --}}
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 small text-muted">
                    Your email address is unverified.
                    <button type="submit" form="send-verification" class="btn btn-link p-0 align-baseline">
                        Click here to re-send the verification email.
                    </button>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <div class="text-success small mt-1">
                        A new verification link has been sent to your email address.
                    </div>
                @endif
            @endif
        </div>

        {{-- Save button --}}
        <div class="mt-4 d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary">Save</button>

            @if (session('status') === 'profile-updated')
                <div class="text-success small ms-3">
                    Profile updated successfully.
                </div>
            @endif
        </div>
    </form>
</section>
