<?php

namespace Database\Factories;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'thread_id' => Thread::factory(),
            'parent_comment_id' => null,
            'body' => fake()->sentence(fake()->numberBetween(6, 20)),
        ];
    }

    /**
     * Indicate that the comment is a reply to another comment.
     */
    public function replyTo(int $parentId): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_comment_id' => $parentId,
        ]);
    }
}
