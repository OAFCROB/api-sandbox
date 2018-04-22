<?php

namespace Tests\Feature\Endpoints\Api;

use App\User as UserModel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\Endpoints\AbstractEndpointTest;

class ListUsersActionTest extends AbstractEndpointTest
{
    use DatabaseMigrations;

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

        // Call api /api/users and check the basic api structure.
        $response = $this->getJson($this->endpoint());
        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        'users'
                    ]
                ]
            )
            ->assertJsonCount(2, 'data.users');


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

    protected function endpoint(): string
    {
        return '/api/users';
    }

    private function createUser(array $overrides = [])
    {
        factory(UserModel::class)->create($overrides);
    }
}
