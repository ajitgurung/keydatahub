<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Subscription;
use App\Models\User;
use App\Models\Make;
use Stripe\Stripe;
use Stripe\Invoice;
use Carbon\Carbon;

    
class AdminDashboardController extends Controller
{
    public function index()
    {
        if(auth()->user()->isAdmin())
        {
        $monthlyPriceId = env('SUB_MONTHLY');
        $yearlyPriceId = env('SUB_YEARLY');
        
        $users = User::all();
        $totalUser = $users->count();

        // Total active (active or trialing, not ended)
        $totalSubscribers = Subscription::whereIn('stripe_status', ['active', 'trialing'])
            ->where(function ($query) {
                $query->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->count();

        // Monthly active subscribers
        $monthlySubscribers = Subscription::where('stripe_price', $monthlyPriceId)
            ->whereIn('stripe_status', ['active', 'trialing'])
            ->where(function ($query) {
                $query->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->count();

        // Yearly active subscribers
        $yearlySubscribers = Subscription::where('stripe_price', $yearlyPriceId)
            ->whereIn('stripe_status', ['active', 'trialing'])
            ->where(function ($query) {
                $query->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->count();

        // Grace period: canceled but still within paid period
        $gracePeriod = Subscription::whereNotNull('ends_at')
            ->where('ends_at', '>', now())
            ->count();

        // Canceled subscribers (ended subscriptions)
        $canceledSubscribers = Subscription::where('stripe_status', 'canceled')
    ->where('ends_at', '<=', now())
    ->distinct('user_id')
    ->count('user_id');


        // Users who never subscribed
        $neverSubscribed = User::whereDoesntHave('subscriptions')->count();

        // Total unsubscribed (canceled + never subscribed)
        $unsubscribed = $canceledSubscribers + $neverSubscribed;

        return view('dashboard', compact(
            'totalSubscribers',
            'monthlySubscribers',
            'yearlySubscribers',
            'gracePeriod',
            'canceledSubscribers',
            'neverSubscribed',
            'unsubscribed',
            'totalUser'
        ));
        }
        else
        {
            $makes = Make::all();
        return view('user-dashboard', compact('makes'));
        }
    }
    
    public function income(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('cashier.secret'));

        // Optional: filter by date
        $startDate = Carbon::parse($request->input('start_date', now()->startOfMonth()));
        $endDate = Carbon::parse($request->input('end_date', now()));

        $invoices = \Stripe\Invoice::all([
            'limit' => 100,
            'created' => [
                'gte' => $startDate->timestamp,
                'lte' => $endDate->timestamp,
            ],
        ]);

        $monthlyTotal = 0;
        $yearlyTotal = 0;
        $allInvoices = [];

        foreach ($invoices->data as $invoice) {
            if ($invoice->paid && $invoice->status === 'paid') {
                $amount = $invoice->amount_paid / 100; // Stripe stores in cents
                $planInterval = $invoice->lines->data[0]->plan->interval ?? null;

                if ($planInterval === 'month') {
                    $monthlyTotal += $amount;
                } elseif ($planInterval === 'year') {
                    $yearlyTotal += $amount;
                }

                $allInvoices[] = [
                    'customer' => $invoice->customer_email,
                    'amount' => $amount,
                    'date' => Carbon::createFromTimestamp($invoice->created)->toDateString(),
                    'interval' => $planInterval,
                ];
            }
        }

        $totalIncome = $monthlyTotal + $yearlyTotal;

        return view('income', compact('monthlyTotal', 'yearlyTotal', 'totalIncome', 'allInvoices', 'startDate', 'endDate'));
    }
}
