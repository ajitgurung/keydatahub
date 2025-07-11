<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('users.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // expects password_confirmation field
            'role' => ['required', Rule::in(['user', 'editor', 'admin'])],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Fire registered event to send verification email
        event(new Registered($user));

        if (in_array($validated['role'], ['admin', 'editor'])) {
            // Replace 'lifetime-plan-id' with your Stripe plan ID for lifetime access
            $user->lifetime_subscribed = 1;
            $user->save();
        }


        return redirect()->route('users.index')->with('status', 'User created successfully. Verification email sent.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['user', 'admin', 'editor'])],
        ]);

        $oldEmail = $user->email;

        $user->fill($validated);

        if (in_array($validated['role'], ['admin', 'editor'])) {
            // Replace 'lifetime-plan-id' with your Stripe plan ID for lifetime access
            $user->lifetime_subscribed = 1;
        }


        // If email was changed, mark it as unverified
        if ($oldEmail !== $user->email) {
            $user->email_verified_at = null;
            $user->save();

            // Send verification email
            event(new Registered($user));
        } else {
            $user->save();
        }

        return redirect()->route('users.index')->with('status', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function cancelSubscription(User $user)
    {
        $subscription = $user->subscription('default');

        if ($subscription && $subscription->valid()) {
            $subscription->cancel();
            return back()->with('status', 'Subscription cancelled successfully.');
        }

        return back()->with('status', 'User is not subscribed.');
    }

    public function sendResetLink(User $user)
    {
        Password::sendResetLink(['email' => $user->email]);

        return back()->with('status', 'Password reset link sent to user email.');
    }
}
