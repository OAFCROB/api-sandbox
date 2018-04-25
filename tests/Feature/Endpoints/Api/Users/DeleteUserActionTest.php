<?php

namespace Tests\Feature\Endpoints\Api;

use App\User as UserModel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\Feature\Endpoints\AbstractEndpointTest;

class DeleteUserActionTest extends AbstractEndpointTest
{
    /**
     * @var int $userId
     */
    private $userId;

    use DatabaseMigrations;

    // @todo - Unauthorised request.

    public function testSuccessfullyCreatingUser()
    {
        $this->userId = 123;

        $user = [
            'id' => $this->userId,
            'name' => 'John Doe',
            'email' => 'john.doe@example.co.uk',
        ];

        $this->createUser($user);

        // Call api /api/users.
        $response = $this->deleteJson($this->endpoint(), [])->assertStatus(200);
        $this->assertEndpointBaseStructure($response);
        $this->assertSoftDeleted('users', ['id' => $this->userId]);
    }

    public function testAttemptToDeleteUserWhoDoesNotExist()
    {
        $this->userId = 666;
        $this->getJson($this->endpoint())->assertStatus(404)->assertExactJson([
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
                'deleted',
            ]
        ]);
    }

    private function createUser(array $overrides = [])
    {
        factory(UserModel::class)->create($overrides);
    }
}
