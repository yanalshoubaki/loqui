<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('shown error when login and email not supplied', function () {
    $response = $this->postJson('/api/auth/sign-in', [
        'password' => 'password',
    ], [
        'Accept' => 'application/json',
        'x-token' => env('APP_TOKEN'),
    ]);
    $response->assertStatus(422)->assertJson(['message' => 'The email field is required.']);
});

it('shown error when login and password not supplied', function () {
    $response = $this->postJson('/api/auth/sign-in', [
        'email' => $this->user->email,
    ], [
        'Accept' => 'application/json',
        'x-token' => env('APP_TOKEN'),
    ]);
    $response->assertStatus(422)->assertJson(['message' => 'The password field is required.']);
});

it('can login', function () {

    /** @var Illuminate\Testing\TestResponse $response */
    $response = $this->postJson('/api/auth/sign-in', [
        'email' => $this->user->email,
        'password' => 'password',
    ], [
        'Accept' => 'application/json',
        'x-token' => env('APP_TOKEN'),
    ]);

    $response->assertSuccessful();
    $response->assertJson([
        'status' => 'success',
    ]);
});

it('shown error when sign up and profile image id not supplied', function () {
    $user = User::factory()->raw();
    unset($user['media_object_id']);
    $response = $this->postJson('/api/auth/sign-up', $user, [
        'Accept' => 'application/json',
        'x-token' => env('APP_TOKEN'),
    ]);
    $response->assertStatus(422);
});

it('shown error when sign up and email is exists', function () {
    $user = User::factory()->raw([
        'email' => 'yanalshoubaki233@gmail.com',
    ]);
    $response = $this->postJson('/api/auth/sign-up', $user, [
        'Accept' => 'application/json',
        'x-token' => env('APP_TOKEN'),
    ]);
    $response->assertStatus(422)->assertJson(['message' => 'The email has already been taken.']);
});

it('shown error when sign up and usernanme is exists', function () {
    $user = User::factory()->raw([
        'username' => 'yanalshoubaki',
    ]);
    $response = $this->postJson('/api/auth/sign-up', $user, [
        'Accept' => 'application/json',
        'x-token' => env('APP_TOKEN'),
    ]);
    $response->assertStatus(422)->assertJson(['message' => 'The username has already been taken.']);
});

it('can sign up', function () {
    $user = User::factory()->raw();
    unset($user['password']);
    $user['password'] = 'password';
    $response = $this->postJson('/api/auth/sign-up', $user, [
        'Accept' => 'application/json',
        'x-token' => env('APP_TOKEN'),
    ]);
    $response->assertSuccessful();
    $response->assertJson([
        'status' => 'success',
    ]);
});
