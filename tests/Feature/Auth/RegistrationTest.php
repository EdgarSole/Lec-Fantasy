<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'nombre' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'foto_url' => ''
    ]);

    $response->assertRedirect(route('index', absolute: false));
});
