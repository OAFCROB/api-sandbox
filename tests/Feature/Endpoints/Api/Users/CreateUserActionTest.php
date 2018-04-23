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

    public function testNameValidationRequired()
    {
        $payload = [];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldRequired('name', $response->json()['errors']);
    }

    public function testEmailValidationRequired()
    {
        $payload = [];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldRequired('email', $response->json()['errors']);
    }

    public function testPasswordValidationRequired()
    {
        $payload = [];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldRequired('email', $response->json()['errors']);
    }

    public function testNameValidationString()
    {
        $field = 'name';

        // Payload of an numeric value.
        $payload = ['name' => 1234];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldString($field, $response->json()['errors']);

        // Payload of an array.
        $payload = [
            $field => (array)['invalid data']
        ];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldString($field, $response->json()['errors']);

        // Payload of an object.
        $payload = [
            $field => (object)['invalid data']
        ];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldString($field, $response->json()['errors']);

        // Payload of the string.
        $payload = [$field => 'valid string payload'];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload);
        $this->assertArrayNotHasKey($field, $response->json()['errors']);
    }

    public function testEmailValidationString()
    {
        $field = 'email';

        // Payload of an numeric value.
        $payload = [$field => 1234];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldString($field, $response->json()['errors']);

        // Payload of an array.
        $payload = [
            $field => (array)['invalid data']
        ];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldString($field, $response->json()['errors']);

        // Payload of an object.
        $payload = [
            $field => (object)['invalid data']
        ];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldString($field, $response->json()['errors']);

        // Payload of the string.
        $payload = [$field => 'valid string payload'];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload);
        $this->assertArrayNotHasKey($field, $response->json()['errors']);
    }

    public function testPasswordValidationString()
    {
        $field = 'password';

        // Payload of an numeric value.
        $payload = [$field => 1234];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldString($field, $response->json()['errors']);

        // Payload of an array.
        $payload = [
            $field => (array)['invalid data']
        ];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldString($field, $response->json()['errors']);

        // Payload of an object.
        $payload = [
            $field => (object)['invalid data']
        ];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldString($field, $response->json()['errors']);

        // Payload of the string.
        $payload = [$field => 'valid string payload'];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload);
        $this->assertArrayNotHasKey($field, $response->json()['errors']);
    }

    public function testNameValidationMaxLength()
    {
        $field = 'name';
        $maxLength = 255;

        // Payload of above max length.
        $payload = [$field => str_random($maxLength + 1)];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldMaxLength($field, $maxLength, $response->json()['errors']);

        // Payload of the max length.
        $payload = [$field => str_random($maxLength)];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload);
        $this->assertArrayNotHasKey($field, $response->json()['errors']);
    }

    public function testEmailValidationMaxLength()
    {
        $field = 'email';
        $maxLength = 255;

        // Payload of an numeric value.
        $payload = [$field => str_random($maxLength + 1)];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldMaxLength($field, $maxLength, $response->json()['errors']);

        // Payload of the max length.
        $payload = [$field => str_random($maxLength)];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload);
        $this->assertArrayNotHasKey($field, $response->json()['errors']);
    }

    public function testPasswordValidationMaxLength()
    {
        $field = 'password';
        $minLength = 6;

        // Payload below the min length.
        $payload = [$field => str_random($minLength - 1)];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldMinLength($field, $minLength, $response->json()['errors']);

        // Payload of the min length.
        $payload = [$field => str_random($minLength)];

        // Call api /api/users.
        $response = $this->postJson($this->endpoint(), $payload);
        $this->assertArrayNotHasKey($field, $response->json()['errors']);
    }

    public function testSuccessfullyCreatingUser()
    {
        $password = str_random();
        $payload = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.co.uk',
            'password' => $password,
            'password_confirmation' => $password
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

    private function assertValidationErrorBaseStructure(TestResponse $response)
    {
        $response->assertJsonStructure([
            'message',
            'errors',
        ]);
    }

    private function assertValidationErrorFieldRequired(string $field, array $errors)
    {
        $this->assertArrayHasKey($field, $errors);
        $this->assertInternalType('array', $errors[$field]);
        $this->assertEquals(
            sprintf('The %s field is required.', $field),
            $errors[$field][0]
        );
    }

    private function assertValidationErrorFieldString(string $field, array $errors)
    {
        $this->assertArrayHasKey($field, $errors);
        $this->assertInternalType('array', $errors[$field]);
        $this->assertEquals(
            sprintf('The %s must be a string.', $field),
            $errors[$field][0]
        );
    }

    private function assertValidationErrorFieldMaxLength(string $field, int $maxLength = 255, array $errors)
    {
        $this->assertArrayHasKey($field, $errors);
        $this->assertInternalType('array', $errors[$field]);
        $this->assertEquals(
            sprintf('The %s may not be greater than %d characters.', $field, $maxLength),
            $errors[$field][0]
        );
    }

    private function assertValidationErrorFieldMinLength(string $field, int $minLength = 255, array $errors)
    {
        $this->assertArrayHasKey($field, $errors);
        $this->assertInternalType('array', $errors[$field]);
        $this->assertEquals(
            sprintf('The %s must be at least %d characters.', $field, $minLength),
            $errors[$field][0]
        );
    }
}