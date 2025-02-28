<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskFeatureTest extends TestCase
{
    use RefreshDatabase;

    // public function test_new_users_can_register(): void
    // {
    //     $response = $this->post('/register', [
    //         'full_name' => 'Test User',
    //         'email' => 'test@example.com',
    //         'password' => 'password',
    //         'password_confirmation' => 'password',
    //     ]);

    //     $this->assertAuthenticated();
    //     $response->assertNoContent();
    // }

    // public function test_users_can_not_authenticate_with_invalid_password(): void
    // {
    //     $user = User::factory()->create();

    //     $this->post('/login', [
    //         'email' => $user->email,
    //         'password' => 'wrong-password',
    //     ]);

    //     $this->assertGuest();
    // }

    // public function test_users_can_logout(): void
    // {
    //     $user = User::factory()->create();

    //     $response = $this->actingAs($user)->post('/logout');

    //     $this->assertGuest();
    //     $response->assertNoContent();
    // }
}
