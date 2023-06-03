<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('can login', function () {
    $response = $this->postJson('/api/auth/sign-in', [
        'email' => $this->user->email,
        'password' => 'password',
    ], [
        'Accept' => 'application/json',
        'x-token' => env('APP_TOKEN'),
    ]);
    $response->assertStatus(200)->assertJson(['message' => 'login success', 'status' => 'success']);
});

it('error when email not supplied', function () {
    $response = $this->postJson('/api/auth/sign-in', [
        'password' => 'password',
    ], [
        'Accept' => 'application/json',
        'x-token' => env('APP_TOKEN'),
    ]);
    $response->assertStatus(422)->assertJson(['message' => 'The email field is required.']);
});

it('error when password not supplied', function () {
    $response = $this->postJson('/api/auth/sign-in', [
        'email' => $this->user->email,
    ], [
        'Accept' => 'application/json',
        'x-token' => env('APP_TOKEN'),
    ]);
    $response->assertStatus(422)->assertJson(['message' => 'The password field is required.']);
});

it('can sign up', function () {
    $user = User::factory()->raw();
    $user['profile_image_id'] = 1;
    $user['password'] = 'password';
    $response = $this->postJson('/api/auth/sign-up', $user, [
        'Accept' => 'application/json',
        'x-token' => env('APP_TOKEN'),
    ]);
    $response->assertStatus(200)->assertJson(['message' => 'register success', 'status' => 'success']);
});

it('error when profile image id not supplied', function () {
    $user = User::factory()->raw();
    unset($user['profile_image_id']);
    $response = $this->postJson('/api/auth/sign-up', $user, [
        'Accept' => 'application/json',
        'x-token' => env('APP_TOKEN'),
    ]);
    $response->assertStatus(422);
});

it('error when email is exists', function () {
    $user = User::factory()->raw([
        'email' => 'yanalshoubaki233@gmail.com',
    ]);
    $response = $this->postJson('/api/auth/sign-up', $user, [
        'Accept' => 'application/json',
        'x-token' => env('APP_TOKEN'),
    ]);
    $response->assertStatus(422)->assertJson(['message' => 'The email has already been taken.']);
});

it('error when usernanme is exists', function () {
    $user = User::factory()->raw([
        'username' => 'yanalshoubaki',
    ]);
    $response = $this->postJson('/api/auth/sign-up', $user, [
        'Accept' => 'application/json',
        'x-token' => env('APP_TOKEN'),
    ]);
    $response->assertStatus(422)->assertJson(['message' => 'The username has already been taken.']);
});
