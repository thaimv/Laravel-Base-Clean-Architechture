<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Infrastructure\Persistence\Eloquent\Models\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    private UserModel $authenticatedUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authenticatedUser = UserModel::factory()->create();
    }

    public function test_authenticated_user_can_list_users(): void
    {
        UserModel::factory()->count(5)->create();

        $response = $this->actingAs($this->authenticatedUser, 'api')
            ->getJson('/api/v1/users');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'data',
                    'meta' => [
                        'total',
                        'per_page',
                        'current_page',
                        'last_page',
                    ],
                ],
            ]);
    }

    public function test_unauthenticated_user_cannot_list_users(): void
    {
        $response = $this->getJson('/api/v1/users');

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_get_user_by_id(): void
    {
        $user = UserModel::factory()->create();

        $response = $this->actingAs($this->authenticatedUser, 'api')
            ->getJson("/api/v1/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'name',
                    'email',
                ],
            ]);
    }

    public function test_authenticated_user_can_create_user(): void
    {
        $response = $this->actingAs($this->authenticatedUser, 'api')
            ->postJson('/api/v1/users', [
                'name' => 'New User',
                'email' => 'newuser@example.com',
                'password' => 'password123',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
        ]);
    }

    public function test_authenticated_user_can_update_user(): void
    {
        $user = UserModel::factory()->create();

        $response = $this->actingAs($this->authenticatedUser, 'api')
            ->putJson("/api/v1/users/{$user->id}", [
                'name' => 'Updated Name',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_authenticated_user_can_delete_user(): void
    {
        $user = UserModel::factory()->create();

        $response = $this->actingAs($this->authenticatedUser, 'api')
            ->deleteJson("/api/v1/users/{$user->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}

