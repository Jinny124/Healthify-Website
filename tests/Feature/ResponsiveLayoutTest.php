<?php

use App\Models\Thread;
use App\Models\User;

test('the layout ships a viewport meta tag', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('name="viewport"', escape: false)
        ->assertSee('width=device-width', escape: false);
});

test('the sidebar is an off-canvas drawer below the lg breakpoint', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('offcanvas-lg offcanvas-start', escape: false)
        ->assertSee('id="sidebarOffcanvas"', escape: false);
});

test('the navbar exposes toggles for the sidebar and its own menu', function () {
    $response = $this->get('/')->assertOk();

    // Hamburger that opens the sidebar drawer.
    $response->assertSee('data-bs-target="#sidebarOffcanvas"', escape: false);

    // Collapsing navbar for search / language / auth controls.
    $response->assertSee('navbar-expand-lg', escape: false)
        ->assertSee('id="mainNavbar"', escape: false);
});

test('the layout does not hard-code pixel or viewport widths', function () {
    $html = $this->get('/')->assertOk()->getContent();

    expect($html)->not->toContain('width: 400px')
        ->and($html)->not->toContain('width: 300px')
        ->and($html)->not->toContain('20vw');
});

test('thread images use the responsive image class', function () {
    Thread::factory()->for(User::factory())->create([
        'threads_image' => 'https://example.com/x.jpg',
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee('thread-image', escape: false);
});

test('the auth pages use a fluid card instead of a viewport-width card', function () {
    foreach (['/login', '/register', '/forgot-password'] as $page) {
        $html = $this->get($page)->assertOk()->getContent();

        expect($html)->toContain('auth-card')
            ->and($html)->not->toContain('vw');
    }
});
