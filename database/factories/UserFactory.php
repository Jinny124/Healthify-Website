<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'role' => 'normal_user',
            'profile_photo_path' => null,
            'doctor_certificate' => null,
            'doctor_verified_at' => null,
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the user is a doctor whose certificate has been approved.
     */
    public function doctor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'doctor',
            'doctor_certificate' => 'https://placehold.co/600x400?text=Doctor+Certificate',
            'doctor_verified_at' => now(),
        ]);
    }

    /**
     * Indicate that the user registered as a doctor but is awaiting approval.
     */
    public function pendingDoctor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'doctor',
            'doctor_certificate' => 'https://placehold.co/600x400?text=Doctor+Certificate',
            'doctor_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user is a site administrator.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
