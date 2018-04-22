<?php

namespace Tests\Feature\Endpoints\Api;

use App\User as UserModel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\Feature\Endpoints\AbstractEndpointTest;

class ListUsersActionTest extends AbstractEndpointTest
{
    use DatabaseMigrations;

    // @todo - Unauthorised request
    // @todo - Paginate response
    // @todo - Filtering results i.e. email, name, created date etc.

    public function testSuccessfullyListingOutUsers()
    {
        $this->createUser([
            'name' => 'John Doe',
            'email' => 'john.doe@example.co.uk',
        ]);
        $this->createUser([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.co.uk',
        ]);

        // Call api /api/users.
        $response = $this->getJson($this->endpoint())->assertStatus(200);

        // Check the basic api endpoint structure.
        $this->assertEndpointBaseStructure($response);

        $expectedUsers = UserModel::orderBy('name', 'asc')->get();
        $users = $response->json()['data']['users'];

        // Check the user structure and that data is ordered as expected.
        foreach ($users as $key => $user) {
            $response->assertJsonStructure(
                [
                    'name',
                    'email',
                ],
                $user
            );
            $this->assertEquals($expectedUsers[$key]->name, $user['name']);
            $this->assertEquals($expectedUsers[$key]->email, $user['email']);
        }
    }

    public function testSuccessWithNoUsersToList()
    {
        // Call api /api/users and check the basic api structure.
        $response = $this->getJson($this->endpoint())->assertStatus(200);

        // Check the basic api endpoint structure.
        $this->assertEndpointBaseStructure($response);
    }

    protected function endpoint(): string
    {
        return '/api/users';
    }

    private function createUser(array $overrides = [])
    {
        factory(UserModel::class)->create($overrides);
    }

    private function assertEndpointBaseStructure(TestResponse $response)
    {
        $response->assertJsonStructure([
            'data' => [
                'users'
            ]
        ]);
    }
}
