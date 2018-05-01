<?php

namespace Tests\Feature\Endpoints;

use App\User as UserModel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\TestResponse;

abstract class AbstractEndpointTest extends TestCase
{
    /**
     * @var UserModel
     */
    protected $loggedInUser;

    protected function setUp()
    {
        parent::setUp();

        $this->loggedInUser = factory(UserModel::class)->create();
    }

    /**
     * Unit test the unauthenticated user attempt to the API endpoint.
     * @return mixed
     */
    abstract public function testUnauthenticatedUser();

    /**
    * Endpoint that's going to be called for the unit test.
    * @return string
    **/
    abstract protected function endpoint(): string;

    /**
     * Assert the basic structure of the endpoint.
     * @return void
     **/
    abstract protected function assertEndpointBaseStructure(TestResponse $response);

    protected function authenticationHeaders(array $headers = []): array
    {
        return array_merge(
            [
                'Authorization' => 'Bearer ' . $this->jwtToken(),
                'Content-Type' => 'application/json'
            ],
            $headers
        );
    }

    private function jwtToken()
    {
        return auth()->tokenById($this->loggedInUser->getJWTIdentifier());
    }
}
