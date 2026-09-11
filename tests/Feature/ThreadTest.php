<?php

use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('anyone can view the thread list', function () {
    Thread::factory()->for(User::factory())->create(['title' => 'Public thread']);

    $this->get('/')
        ->assertOk()
        ->assertSee('Public thread');
});

test('a guest cannot open the thread create page', function () {
    $this->get(route('threads.thread.create'))
        ->assertRedirect(route('login'));
});

test('an authenticated user can create a thread', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('threads.thread.store'), [
        'title' => 'How much water per day?',
        'body' => 'Asking for a rough daily target.',
    ]);

    $thread = Thread::firstWhere('title', 'How much water per day?');

    expect($thread)->not->toBeNull()
        ->and($thread->user_id)->toBe($user->id);

    $response->assertRedirect(route('threads.thread.show', $thread));
});

test('a thread image is stored on the local disk when Azure is not configured', function () {
    Storage::fake('public');
    config(['filesystems.disks.azure.key' => null]);

    $user = User::factory()->create();

    $this->actingAs($user)->post(route('threads.thread.store'), [
        'title' => 'Any tips for a sunburn?',
        'body' => 'Got a bad one this weekend.',
        'threads_image' => UploadedFile::fake()->create('rash.jpg', 10, 'image/jpeg'),
    ])->assertRedirect();

    $thread = Thread::firstWhere('title', 'Any tips for a sunburn?');

    expect($thread->threads_image)->not->toBeNull()
        ->and($thread->threads_image)->toContain('/storage/threads/');

    Storage::disk('public')->assertExists('threads/'.basename($thread->threads_image));
});

test('creating a thread requires a title and body', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->from(route('threads.thread.create'))
        ->post(route('threads.thread.store'), ['title' => '', 'body' => ''])
        ->assertSessionHasErrors(['title', 'body']);
});

test('a user can delete their own thread', function () {
    $user = User::factory()->create();
    $thread = Thread::factory()->for($user)->create();

    $this->actingAs($user)
        ->delete(route('threads.destroy', $thread))
        ->assertRedirect(route('threads.search'));

    $this->assertModelMissing($thread);
});

test('a user cannot delete a thread owned by someone else', function () {
    $thread = Thread::factory()->for(User::factory())->create();

    $this->actingAs(User::factory()->create())
        ->delete(route('threads.destroy', $thread))
        ->assertForbidden();

    $this->assertModelExists($thread);
});
