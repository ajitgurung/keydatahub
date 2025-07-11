@extends('layouts.app')

@section('content')
<main class="app-main">
    <div class="checkout-page container py-5">
        @php
            $user = auth()->user();
            $subscription = $user->subscription('default');

            $plans = [
                'monthly' => [
                    'title' => 'Monthly',
                    'price' => '$9.99',
                    'desc' => 'Billed every month',
                    'btn_class' => 'btn-outline-primary',
                    'header_class' => 'bg-primary text-white',
                    'price_id' => config('services.stripe.monthly_price_id'),
                ],
                'yearly' => [
                    'title' => 'Yearly',
                    'price' => '$79.95',
                    'desc' => 'Best value - billed once per year',
                    'btn_class' => 'btn-outline-success',
                    'header_class' => 'bg-success text-white',
                    'price_id' => config('services.stripe.yearly_price_id'),
                ],
            ];
        @endphp

        @if ($user->lifetime_subscribed)
            <div class="alert alert-success text-center">
                You have a lifetime subscription. Enjoy unlimited access!
            </div>

        @elseif ($subscription && $subscription->onGracePeriod())
            <div class="alert alert-warning text-center mb-4">
                Your subscription was cancelled and will end on: {{ $subscription->ends_at?->format('Y / F / d') ?? 'N/A' }}.
            </div>

        @elseif ($subscription && $subscription->valid())
            <div class="alert alert-info text-center text-black">
                Next payment date: 
                {{
                    $subscription->asStripeSubscription()->current_period_end
                        ? \Carbon\Carbon::createFromTimestamp($subscription->asStripeSubscription()->current_period_end)->format('Y / F / d')
                        : 'N/A'
                }}.
            </div>

            <form action="{{ route('subscription.cancel') }}" method="POST" class="text-center mt-3">
                @csrf
                <button class="btn btn-danger">Cancel Subscription</button>
            </form>

        @else
            <h2 class="text-center mb-4">Choose Your Plan</h2>
            <div class="row justify-content-center">
                @foreach ($plans as $key => $plan)
                    <div class="col-md-6 mb-4">
                        <div class="card text-center {{ $key === 'yearly' ? 'border-success' : '' }}">
                            <div class="card-header {{ $plan['header_class'] }}">
                                {{ $plan['title'] }}
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">{{ $plan['price'] }}</h3>
                                <p class="card-text">{{ $plan['desc'] }}</p>
                                <form method="POST" action="{{ route('subscription.process', ['plan' => $plan['price_id']]) }}">
                                    @csrf
                                    <input type="hidden" name="plan" value="{{ $key }}">
                                    <button class="btn {{ $plan['btn_class'] }} w-100">Choose {{ $plan['title'] }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</main>
@endsection
