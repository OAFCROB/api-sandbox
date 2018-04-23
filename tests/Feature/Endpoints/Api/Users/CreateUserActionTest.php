<?php

namespace Tests\Feature\Endpoints\Api;

use App\User as UserModel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\Feature\Endpoints\AbstractEndpointTest;

class GetUserActionTest extends AbstractEndpointTest
{
    use DatabaseMigrations;

    // @todo - Unauthorised request.
    // @todo - Request validation on payload.
    // @todo - Check the password field in the DB isn't plain string that's passed in.

    public function testSuccessfullyCreatingUser()
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.co.uk',
            'password' => str_random(),
        ];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload)->assertStatus(201);

        $this->assertEndpointBaseStructure($response);

        // Check the results in the database, reflect the payload given.
        $databaseUser = UserModel::first();

        $this->assertNotNull($databaseUser);
        $this->assertEquals($payload['name'], $databaseUser->name);
        $this->assertEquals($payload['email'], $databaseUser->email);
        $this->assertEquals($payload['password'], $databaseUser->password);

        $responseUser = $response->json()['data'];

        $this->assertEquals($databaseUser->id, $responseUser['id']);
        $this->assertEquals('John Doe', $responseUser['name']);
        $this->assertEquals('john.doe@example.co.uk', $responseUser['email']);
    }

    protected function endpoint(): string
    {
        return '/api/users';
    }

    protected function assertEndpointBaseStructure(TestResponse $response)
    {
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'created_at',
                'updated_at',
            ]
        ]);
    }
}
