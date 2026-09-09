<?php

use App\Models\Thread;
use App\Models\Upvote;
use App\Models\User;

test('a user can upvote a thread', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->from(route('threads.thread.show', $thread))
        ->post(route('vote', ['type' => 'thread', 'id' => $thread->id]), ['vote_type' => 'upvote']);

    $this->assertDatabaseHas('upvotes', [
        'user_id' => $user->id,
        'votable_id' => $thread->id,
        'votable_type' => Thread::class,
        'vote_type' => 'upvote',
    ]);
});

test('voting again flips the vote instead of creating a duplicate', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->for(User::factory())->create();

    $vote = fn (string $type) => $this->actingAs($user)
        ->from(route('threads.thread.show', $thread))
        ->post(route('vote', ['type' => 'thread', 'id' => $thread->id]), ['vote_type' => $type]);

    $vote('upvote');
    $vote('downvote');

    expect(Upvote::count())->toBe(1)
        ->and(Upvote::first()->vote_type)->toBe('downvote');
});

test('a guest cannot vote', function () {
    $thread = Thread::factory()->for(User::factory())->create();

    $this->post(route('vote', ['type' => 'thread', 'id' => $thread->id]), ['vote_type' => 'upvote'])
        ->assertRedirect(route('login'));

    $this->assertDatabaseCount('upvotes', 0);
});

test('an invalid vote type is rejected', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->from(route('threads.thread.show', $thread))
        ->post(route('vote', ['type' => 'thread', 'id' => $thread->id]), ['vote_type' => 'sideways'])
        ->assertSessionHasErrors('vote_type');
});
