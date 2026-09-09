<?php

use App\Models\User;

test('a guest is redirected away from the admin area', function () {
    $this->get(route('admin.doctors.index'))->assertRedirect(route('login'));
});

test('a normal member cannot open the admin area', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('admin.doctors.index'))
        ->assertForbidden();
});

test('a verified doctor cannot open the admin area', function () {
    $this->actingAs(User::factory()->doctor()->create())
        ->get(route('admin.doctors.index'))
        ->assertForbidden();
});

test('an admin sees pending applications', function () {
    $pending = User::factory()->pendingDoctor()->create(['name' => 'dr. Pending Person']);
    User::factory()->doctor()->create(['name' => 'dr. Already Approved']);

    $this->actingAs(User::factory()->admin()->create())
        ->get(route('admin.doctors.index'))
        ->assertOk()
        ->assertSee('dr. Pending Person');
});

test('an admin can approve a pending doctor', function () {
    $admin = User::factory()->admin()->create();
    $applicant = User::factory()->pendingDoctor()->create();

    $this->actingAs($admin)
        ->patch(route('admin.doctors.approve', $applicant))
        ->assertRedirect();

    $applicant->refresh();

    expect($applicant->doctor_verified_at)->not->toBeNull()
        ->and($applicant->isDoctor())->toBeTrue();
});

test('an admin can reject a pending doctor, demoting them', function () {
    $admin = User::factory()->admin()->create();
    $applicant = User::factory()->pendingDoctor()->create();

    $this->actingAs($admin)
        ->patch(route('admin.doctors.reject', $applicant))
        ->assertRedirect();

    $applicant->refresh();

    expect($applicant->role)->toBe('normal_user')
        ->and($applicant->doctor_certificate)->toBeNull();
});

test('approving an already-verified doctor 404s', function () {
    $admin = User::factory()->admin()->create();
    $doctor = User::factory()->doctor()->create();

    $this->actingAs($admin)
        ->patch(route('admin.doctors.approve', $doctor))
        ->assertNotFound();
});

test('a non-admin cannot approve a doctor', function () {
    $applicant = User::factory()->pendingDoctor()->create();

    $this->actingAs(User::factory()->create())
        ->patch(route('admin.doctors.approve', $applicant))
        ->assertForbidden();

    expect($applicant->refresh()->doctor_verified_at)->toBeNull();
});
