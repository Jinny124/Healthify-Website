<?php

use App\Models\Thread;
use App\Models\User;

test('the layout ships a viewport meta tag', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('name="viewport"', escape: false)
        ->assertSee('width=device-width', escape: false);
});

test('the sidebar rail is hidden below the lg breakpoint', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('app-sidebar d-none d-lg-flex', escape: false);
});

test('there is a single navbar toggle and it carries the sidebar links', function () {
    $html = $this->get('/')->assertOk()->getContent();

    // Exactly one hamburger, and it drives the navbar collapse.
    expect(substr_count($html, '<button class="navbar-toggler'))->toBe(1);
    expect($html)->toContain('data-bs-target="#mainNavbar"')
        ->and($html)->toContain('navbar-expand-lg')
        ->and($html)->not->toContain('offcanvas');

    // The sidebar destinations are reachable from that menu on small screens.
    expect($html)->toContain('navbar-nav d-lg-none');
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
