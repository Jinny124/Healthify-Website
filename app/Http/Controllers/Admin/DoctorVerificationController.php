<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DoctorVerificationController extends Controller
{
    /**
     * List doctor applications awaiting review, plus the already-approved ones.
     */
    public function index(): View
    {
        $pending = User::where('role', 'doctor')
            ->whereNull('doctor_verified_at')
            ->latest()
            ->get();

        $approved = User::where('role', 'doctor')
            ->whereNotNull('doctor_verified_at')
            ->latest('doctor_verified_at')
            ->get();

        return view('admin.doctor-verifications', compact('pending', 'approved'));
    }

    /**
     * Approve an application: the user keeps the doctor role and gets the badge.
     */
    public function approve(User $user): RedirectResponse
    {
        abort_unless($user->isPendingDoctor(), 404);

        $user->update(['doctor_verified_at' => now()]);

        return back()->with('status', "{$user->name} approved as a doctor.");
    }

    /**
     * Reject an application: demote the user to a normal member.
     */
    public function reject(User $user): RedirectResponse
    {
        abort_unless($user->isPendingDoctor(), 404);

        $user->update([
            'role' => 'normal_user',
            'doctor_certificate' => null,
            'doctor_verified_at' => null,
        ]);

        return back()->with('status', "{$user->name}'s doctor application was rejected.");
    }
}
