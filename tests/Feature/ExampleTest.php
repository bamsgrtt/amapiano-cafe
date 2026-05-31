<?php

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('the reservation page returns a successful response', function () {
    $response = $this->get('/reservation');

    $response->assertStatus(200);
});
