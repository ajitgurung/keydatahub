<?php

use App\Http\Controllers\InfoController;
use App\Http\Controllers\MakeController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\YearController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;
use App\Http\Controllers\AdminDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user-dashboard', [UserDashboardController::class, 'view'])->middleware(['subscribed'])->name('user.dashboard');

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->middleware(['subscribed'])
        ->name('dashboard');

    Route::get('/get-models/{make}', [YearController::class, 'getModels']);
    Route::get('/get-years/{model}', [InfoController::class, 'getYears']);
    Route::get('info/{year}', [UserDashboardController::class, 'info']);

    Route::middleware(['isEditor'])->group(function () {
        Route::resource('makes', MakeController::class);
        Route::resource('models', ModelController::class);
        Route::resource('years', YearController::class);
        Route::resource('infos', InfoController::class);

        Route::get('/check-info/{year}', function ($yearId) {
            return response()->json([
                'exists' => \App\Models\Info::where('year_id', $yearId)->exists()
            ]);
        });
    });

      Route::middleware('isAdmin')->group(function () {
        Route::resource('users', UserController::class);
        Route::post('/users/{user}/cancel-subscription', [UserController::class, 'cancelSubscription'])->name('users.cancel-subscription');
        Route::post('/users/{user}/end-graceperiod', [UserController::class, 'endGracePeriod'])->name('users.end-grace-period');
        Route::post('/users/{user}/send-reset-link', [UserController::class, 'sendResetLink'])->name('users.send-reset-link');
        Route::get('/admin/revenue', [AdminDashboardController::class, 'income'])->name('admin.income');

    });

    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    Route::post('/subscription/process/{plan}', [SubscriptionController::class, 'process'])->name('subscription.process');

    Route::post('/subscription/one-time', [SubscriptionController::class, 'onetime'])->name('subscription.onetime');
    Route::get('/one-time/success', [SubscriptionController::class, 'onetimeSuccess'])->name('onetime.success');

    Route::view('subscription-success', 'subscription-success')->name('subscription.success');
});

require __DIR__ . '/auth.php';
