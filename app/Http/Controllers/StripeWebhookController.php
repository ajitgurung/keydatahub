<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Subscription as StripeSubscription;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use App\Models\User;
use Carbon\Carbon;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\Exception $e) {
            Log::error('Stripe webhook verification failed: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature or payload'], 400);
        }

        switch ($event->type) {
            case 'customer.subscription.created':
            case 'customer.subscription.updated':
            case 'customer.subscription.deleted':
                $this->syncSubscription($event->data->object);
                break;

            default:
                Log::info('Unhandled Stripe event: ' . $event->type);
        }

        return response()->json(['status' => 'success'], 200);
    }

    protected function syncSubscription(object $stripeSub)
    {
        $user = User::where('stripe_id', $stripeSub->customer)->first();

        if (! $user) {
            Log::warning("No user found for Stripe customer ID {$stripeSub->customer}");
            return;
        }

        // Fetch the full subscription from Stripe to ensure all items are present
        $liveSub = StripeSubscription::retrieve([
            'id' => $stripeSub->id,
            'expand' => ['items.data.price', 'latest_invoice.payment_intent'],
        ]);

        // Sync with Cashier
        $user->syncStripeSubscription($liveSub);

        // Update ends_at manually for deleted or canceled subs
        if ($liveSub->status === 'canceled' || $liveSub->cancel_at_period_end) {
            $user->subscription($liveSub->metadata->name ?? 'default')
                ->fill([
                    'ends_at' => $liveSub->cancel_at ? Carbon::createFromTimestamp($liveSub->cancel_at) : now(),
                ])->save();
        }

        Log::info("Synced Stripe subscription {$liveSub->id} for user {$user->id}");
    }
}
