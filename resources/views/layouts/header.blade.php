<nav class="app-header navbar navbar-expand bg-body">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Start Navbar Links-->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="bi bi-list"></i>
        </a>
      </li>
      <!-- <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
      <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li> -->
    </ul>
    <!--end::Start Navbar Links-->
    <!--begin::End Navbar Links-->
    <ul class="navbar-nav ms-auto">
      <!--begin::Fullscreen Toggle-->
      <li class="nav-item">
        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
          <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
          <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
        </a>
      </li>
      <!--end::Fullscreen Toggle-->
      <!--begin::User Menu Dropdown-->
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <!-- <img
            src="{{asset('dashboard/images/img/user2-160x160.jpg')}}"
            class="user-image rounded-circle shadow"
            alt="User Image" /> -->
          <span class="d-md-inline">{{Auth::user()->name}}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <!--begin::User Image-->
          <li class="text-bg-secondary text-center">
            @php
            $user = auth()->user();
            $subscription = $user->subscription('default');
            $monthly = config('services.stripe.monthly_price_id');
            $yearly = config('services.stripe.yearly_price_id');
            @endphp

            <small>
              @if ($subscription)
              @php
              $stripeSubscription = $subscription->asStripeSubscription();
              $nextPaymentDate = \Carbon\Carbon::createFromTimestamp(
              $stripeSubscription->current_period_end
              )->format('F j, Y');
              @endphp
              @endif

              @if ($user ->role == 'admin' || $user->role == 'editor')
              <p class="bg-success">You have lifetime access.</p>

              @elseif ($subscription && $subscription->onGracePeriod())
              <p class="bg-warning text-dark">Your subscription was cancelled.</p>
              <p class="text-white">Ends on: {{ optional($subscription->ends_at)->format('F j, Y') }}</p>

              @elseif ($subscription && $subscription->ended())
              <p class="bg-danger">Your subscription has ended.</p>
              @elseif ($subscription && $subscription->stripe_price === $monthly)
              <p class="bg-success">You're on the Monthly Plan.</p>
              <p class="text-white">Next payment date: {{ $nextPaymentDate }}</p>

              @elseif ($subscription && $subscription->stripe_price === $yearly)
              <p class="bg-success">You're on the Yearly Plan.</p>
              <p class="text-white">Next payment date: {{ $nextPaymentDate }}</p>

              @elseif ($subscription && $subscription->valid())
              <p class="bg-success">You're subscribed.</p>
              <p class="text-white">Next payment date: {{ $nextPaymentDate }}</p>

              @else
              <p class="bg-danger">You are not subscribed.</p>
              @endif
            </small>
          </li>

          <li class="user-footer">
            <a href="{{route('profile.edit')}}" class="btn btn-default btn-flat">Profile</a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline float-end">
              @csrf
              <button type="submit" class="btn btn-default btn-flat">Sign out</button>
            </form>
          </li>
          <!--end::Menu Footer-->
        </ul>
      </li>
      <!--end::User Menu Dropdown-->
    </ul>
    <!--end::End Navbar Links-->
  </div>
  <!--end::Container-->
</nav>