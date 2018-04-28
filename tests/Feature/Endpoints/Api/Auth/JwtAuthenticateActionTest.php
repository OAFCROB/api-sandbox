<?php

namespace Tests\Feature\Endpoints\Api;

use App\User as UserModel;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\Feature\Endpoints\AbstractEndpointTest;

class JwtAuthenticateActionTest extends AbstractEndpointTest
{
    /**
     * @var UserModel
     */
    private $user;

    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(UserModel::class)->create();
    }

    public function testUnauthenticatedUser()
    {
        $this->markTestSkipped('Do not need to implement for this test.');
    }

    public function testEmptyPayloadResultsInAnError()
    {
        $payload = [
            // An empty payload.
        ];

        // Call api /api/users.
        $this->postJson($this->endpoint(), $payload)->assertStatus(401)->assertExactJson([
            'error' => [
                'authentication' => 'Unauthorized.'
            ]
        ]);
    }

    public function testEmptyPayloadDataResultsInAnError()
    {
        $payload = [
            'email' => null,
            'password' => null,
        ];

        // Call api /api/users.
        $this->postJson($this->endpoint(), $payload)->assertStatus(401)->assertExactJson([
            'error' => [
                'authentication' => 'Unauthorized.'
            ]
        ]);
    }

    public function testInvalidEmailResultsInAnError()
    {
        $payload = [
            'email' => 'invalid-email@example.co.uk',
            'password' => $this->user->password,
        ];

        // Call api /api/users.
        $this->postJson($this->endpoint(), $payload)->assertStatus(401)->assertExactJson([
            'error' => [
                'authentication' => 'Unauthorized.'
            ]
        ]);
    }

    public function testInvalidPasswordResultsInAnError()
    {
        $payload = [
            'email' => $this->user->email,
            'password' => 'invalid password',
        ];

        // Call api /api/users.
        $this->postJson($this->endpoint(), $payload)->assertStatus(401)->assertExactJson([
            'error' => [
                'authentication' => 'Unauthorized.'
            ]
        ]);
    }

    public function testSuccessfulJwtAuthentication()
    {
        $payload = [
            'email' => $this->user->email,
            'password' => 'password_123',
        ];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload);
        $json = $response->json();
        $this->assertNotNull($json['data']['token']);
        $this->assertNotNull($json['data']['token_type']);
        $this->assertNotNull($json['data']['expires_in']);

        $this->assertEquals('bearer', $json['data']['token_type']);
    }

    protected function endpoint(): string
    {
        return '/api/auth';
    }

    protected function assertEndpointBaseStructure(TestResponse $response)
    {
        $response->assertJsonStructure([
            'data' => [
                'token',
                'token_type',
                'expires_in',
            ]
        ]);
    }

    private function createUser(array $overrides = [])
    {
        factory(UserModel::class)->create($overrides);
    }
}
