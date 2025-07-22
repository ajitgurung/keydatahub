<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $intent = $user->createSetupIntent();

        if ($request->has('status') && $request->has('message')) {
            if ($request->status === 'success') {
                session()->flash('success', $request->message);
            } elseif ($request->status === 'error') {
                session()->flash('error', $request->message);
            }
        }

        return view('subscription', [
            'intent' => $intent,
            'subscription' => $user->subscription('default'),
        ]);
    }

    /**
     * Recurring subscription
     */
    public function process(Request $request, string $plan = 'price_1RhG9JQkR7DfrGf25ZvqS3X2')
    {
        $user = $request->user();

        // Check if there's an active subscription to the same plan that is NOT on grace period
        $existingSubscription = $user->subscriptions()
            ->where('stripe_price', $plan)
            ->get()
            ->first(function ($sub) {
                return $sub->valid() && !$sub->ended();
            });

        if ($existingSubscription) {
            return back()->with('error', 'You already have an active subscription for this plan.');
        }

        // If only subscriptions on grace period or none, allow new one
        return $user
            ->newSubscription('default', $plan)
            ->allowPromotionCodes()
            ->checkout([
                'success_url' => route('subscription', [
                    'status' => 'success',
                    'message' => 'Subscription successful!'
                ]),
                'cancel_url' => route('subscription', [
                    'status' => 'error',
                    'message' => 'Failed to subscribe.'
                ]),
            ]);
    }

    /**
     * One-time payment (Lifetime)
     */
    public function onetime(Request $request)
    {
        $stripePriceId = 'price_1RhG9JQkR7DfrGf2pW9wBcAJ';

        return $request->user()->checkout([$stripePriceId => 1], [
            'success_url' => route('onetime.success'),
            'cancel_url' => route('subscription'),
            'metadata' => [
                'type' => 'lifetime',
            ],
        ]);
    }

    /**
     * Only shows confirmation — lifetime flag is set via webhook!
     */
    public function onetimeSuccess(Request $request)
    {
        return redirect()->route('subscription')->with('success', 'Thank you for your lifetime purchase!');
    }

    public function success()
    {
        return view('subscription.success');
    }

    public function cancel()
    {
        $user = Auth::user();

        if ($user->subscription('default') && $user->subscribed('default')) {
            if ($user->subscription('default')->cancel()) {
                return back()->with('success', 'Subscription cancelled successfully.');
            }
        } else {
            return back()->with('error', 'Subscription failed to cancel. Please contact the admin!');
        }
    }
}
