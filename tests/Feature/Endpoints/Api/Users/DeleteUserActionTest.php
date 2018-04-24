<?php

namespace Tests\Feature\Endpoints\Api;

use Illuminate\Foundation\Testing\TestResponse;
use Tests\Feature\Endpoints\AbstractEndpointTest;

class DeleteUserActionTest extends AbstractEndpointTest
{
    /**
     * @var int $userId
     */
    private $userId;

    // @todo - Unauthorised request.

    public function testSuccessfullyCreatingUser()
    {
        $this->userId = 123;

        // Call api /api/users.
        $response = $this->deleteJson($this->endpoint(), [])->assertStatus(201);
    }

    protected function endpoint(): string
    {
        return '/api/users/' . $this->userId;
    }

    protected function assertEndpointBaseStructure(TestResponse $response)
    {
        // @todo - Decide on the structure later.
    }
}
