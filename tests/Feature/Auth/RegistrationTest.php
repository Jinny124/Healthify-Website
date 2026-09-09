<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new members can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'normal_user',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('threads.search', absolute: false));

    expect(User::firstWhere('email', 'test@example.com'))
        ->role->toBe('normal_user');
});

test('a user registering as a doctor starts unverified', function () {
    $this->post('/register', [
        'name' => 'Dr Test',
        'email' => 'doctor@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'doctor',
    ]);

    $user = User::firstWhere('email', 'doctor@example.com');

    expect($user->role)->toBe('doctor')
        ->and($user->doctor_verified_at)->toBeNull()
        ->and($user->isPendingDoctor())->toBeTrue()
        ->and($user->isDoctor())->toBeFalse();
});
