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
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => ['required', 'in:normal_user,doctor'],
        'doctor_certificate' => ['nullable', 'file', 'mimes:jpeg,png,pdf', 'max:2048'],
    ]);

    $doctorCertificatePath = null;

    if ($request->role === 'doctor' && $request->hasFile('doctor_certificate')) {

        $filePath = $request->file('doctor_certificate')->store(
            '', 
            'azure' 
        );


        $doctorCertificatePath = config('filesystems.disks.azure.url') . '/' . $filePath;
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'password' => Hash::make($request->password),
        'doctor_certificate' => $doctorCertificatePath,
    ]);

    Auth::login($user);

        return redirect(route('threads.search', absolute: false));
}

}
