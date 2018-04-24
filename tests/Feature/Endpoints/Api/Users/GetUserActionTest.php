<?php

namespace Tests\Feature\Endpoints\Api;

use App\User as UserModel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\Feature\Endpoints\AbstractEndpointTest;

class GetUserActionTest extends AbstractEndpointTest
{
    /**
    * @var int $userId
    **/
    private $userId;

    use DatabaseMigrations;

    // @todo - Unauthorised request

    public function testSuccessfullyGetUser()
    {
        $this->userId = 123;

        $this->createUser([
            'id' => $this->userId,
            'name' => 'John Doe',
            'email' => 'john.doe@example.co.uk',
        ]);

        // Call api /api/users.
        $response = $this->getJson($this->endpoint())->assertStatus(200);

        // Check the basic api endpoint structure.
        $this->assertEndpointBaseStructure($response);

        $user = $response->json()['data'];

        $this->assertEquals($this->userId, $user['id']);
        $this->assertEquals('John Doe', $user['name']);
        $this->assertEquals('john.doe@example.co.uk', $user['email']);
    }

    public function testUnableToFindUser()
    {
        $this->userId = 666;

        // Call api /api/users.
        $response = $this->getJson($this->endpoint())->assertStatus(404)->assertExactJson([
            'error' => [
                'user' => sprintf('User [%d] not found.', $this->userId )
            ]
        ]);
    }

    protected function endpoint(): string
    {
        return '/api/users/' . $this->userId;
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

    private function createUser(array $overrides = [])
    {
        factory(UserModel::class)->create($overrides);
    }
}
