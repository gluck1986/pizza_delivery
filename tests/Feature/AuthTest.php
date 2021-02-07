<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase;
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testToken()
    {
        $password = 'pass';
        /** @var User $user */
        $user = User::factory()->create(['password' => \Hash::make($password)]);
        $data = [
            'email' => $user->email,
            'password' => $password,
            'device_name' => 'phpunit',
        ];
        $response = $this->postJson('/api/auth/token', $data);
        $response->assertStatus(200);
    }

    public function testAlReadyLoggedIn()
    {
        $password = 'pass';
        /** @var User $user */
        $user = User::factory()->create(['password' => \Hash::make($password)]);

        $this->be($user);

        $data = [
            'email' => $user->email,
            'password' => $password,
            'device_name' => 'phpunit',
        ];
        $response = $this->postJson('/api/auth/token', $data);;
        $response->assertStatus(422);
        $respData = $response->json();

        $this->assertEquals('already logged in', $respData['errors']['user'][0]);
    }

    public function testGetTokenTwice()
    {
        $password = 'pass';
        /** @var User $user */
        $user = User::factory()->create(['password' => \Hash::make($password)]);
        $data = [
            'email' => $user->email,
            'password' => $password,
            'device_name' => 'phpunit',
        ];
        $response = $this->postJson('/api/auth/token', $data);
        $response->assertStatus(200);
        $response = $this->postJson('/api/auth/token', $data);
        $response->assertStatus(200);
    }

    public function testLogOutGuest()
    {
        $response = $this->postJson('/api/auth/logout');
        $response->assertStatus(401);
    }

    public function testLogOut()
    {
        $password = 'pass';
        /** @var User $user */
        $user = User::factory()->create(['password' => \Hash::make($password)]);
        $data = [
            'email' => $user->email,
            'password' => $password,
            'device_name' => 'phpunit',
        ];
        $response = $this->postJson('/api/auth/token', $data);
        $token = $response->json('token');
        $response->assertStatus(200);
        $response = $this->postJson('/api/auth/logout',
            $data,
            ['Authorization' => 'Bearer ' . $token]
        );
        $response->assertOk();
        $this->assertEquals(true, $response->json('success'));
    }
}
