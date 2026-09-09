<?php

use App\Models\Comment;
use App\Models\Thread;
use App\Models\User;

test('an authenticated user can comment on a thread', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->post(route('comments.store', $thread), ['body' => 'Great question.'])
        ->assertRedirect(route('threads.thread.show', $thread));

    $this->assertDatabaseHas('comments', [
        'thread_id' => $thread->id,
        'user_id' => $user->id,
        'body' => 'Great question.',
        'parent_comment_id' => null,
    ]);
});

test('a comment can be a reply to another comment', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->for(User::factory())->create();
    $parent = Comment::factory()->for($thread)->for(User::factory())->create();

    $this->actingAs($user)->post(route('comments.store', $thread), [
        'body' => 'Agreed.',
        'parent_comment_id' => $parent->id,
    ]);

    $reply = Comment::firstWhere('body', 'Agreed.');

    expect($reply->parent_comment_id)->toBe($parent->id)
        ->and($parent->childComments)->toHaveCount(1);
});

test('a guest cannot comment', function () {
    $thread = Thread::factory()->for(User::factory())->create();

    $this->post(route('comments.store', $thread), ['body' => 'Hi'])
        ->assertRedirect(route('login'));

    $this->assertDatabaseCount('comments', 0);
});

test('an empty comment is rejected', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->from(route('threads.thread.show', $thread))
        ->post(route('comments.store', $thread), ['body' => ''])
        ->assertSessionHasErrors('body');
});

test('a user can delete their own comment', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->for(User::factory())->create();
    $comment = Comment::factory()->for($thread)->for($user)->create();

    $this->actingAs($user)->delete(route('comments.destroy', $comment));

    $this->assertModelMissing($comment);
});
