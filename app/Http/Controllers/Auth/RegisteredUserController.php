<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:student,professor,admin'],
            'role_pin' => ['nullable','required_if:role,professor,admin'],
        ]);

        // Validate professor PIN if role is professor
        $role = $validated['role'] ?? 'student';
        if ($role === 'professor') {
            $expectedPin = env('PROFESSOR_PIN', '7890');
            if (($validated['role_pin'] ?? null) !== $expectedPin) {
                return back()->withErrors(['role_pin' => 'Invalid professor PIN.'])->withInput();
            }
        }

        if ($role === 'admin') {
            $expectedAdminPin = env('ADMIN_PIN', '9876');
            if (($validated['role_pin'] ?? null) !== $expectedAdminPin) {
                return back()->withErrors(['role_pin' => 'Invalid admin PIN.'])->withInput();
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $role,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        if ($user->role === 'professor') {
            return redirect()->intended(route('professor.dashboard', absolute: false));
        }

        return redirect()->intended(route('student.dashboard', absolute: false));
    }
}
