<?php

namespace Tests\Feature\Endpoints\Api;

use Tests\Feature\Endpoints\AbstractEndpointTest;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ListUsersActionTest extends AbstractEndpointTest
{
    use DatabaseMigrations;

    public function testSuccessfullyListingOutUsers()
    {
        // Call api /api/users
        // Get all the users from the database
        // List them out.
        $response = $this->getJson($this->endpoint());
        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        'users'
                    ]
                ]
            );

        dd($response, $response->content());
    }

    protected function endpoint(): string
    {
        return '/api/users';
    }
}
