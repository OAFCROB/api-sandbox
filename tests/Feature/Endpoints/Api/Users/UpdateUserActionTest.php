<?php

namespace Tests\Feature\Endpoints\Api;

use App\User as UserModel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\Feature\Endpoints\AbstractEndpointTest;

class UpdateUserActionTest extends AbstractEndpointTest
{
    /**
     * @var int $userId
     */
    private $userId;

    /**
     * @var UserModel
     */
    private $user;

    use DatabaseMigrations;

    // @todo - Unauthorised request.
    protected function setUp()
    {
        parent::setUp();
        $this->userId = 123;
        $this->user = $this->createUser([
            'id' => $this->userId,
            'name' => 'John Doe',
            'email' => 'john.doe@example.co.uk',
            'created_at' => '2018-04-27 17:53:00',
            'updated_at' => '2018-04-27 17:53:00',
        ]);
    }

    public function testNameValidationRequired()
    {
        $payload = [];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldRequired('name', $response->json()['errors']);
    }

    public function testEmailValidationRequired()
    {
        $payload = [];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldRequired('email', $response->json()['errors']);
    }

    public function testPasswordValidationRequired()
    {
        $payload = [];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldRequired('email', $response->json()['errors']);
    }

    public function testNameValidationString()
    {
        $field = 'name';

        // Payload of an numeric value.
        $payload = ['name' => 1234];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldString($field, $response->json()['errors']);

        // Payload of an array.
        $payload = [
            $field => (array)['invalid data']
        ];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldString($field, $response->json()['errors']);

        // Payload of an object.
        $payload = [
            $field => (object)['invalid data']
        ];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldString($field, $response->json()['errors']);

        // Payload of the string.
        $payload = [$field => 'valid string payload'];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload);
        $this->assertArrayNotHasKey($field, $response->json()['errors']);
    }

    public function testPasswordValidationString()
    {
        $field = 'password';

        // Payload of an numeric value.
        $payload = [$field => 1234];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldString($field, $response->json()['errors']);

        // Payload of an array.
        $payload = [
            $field => (array)['invalid data']
        ];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldString($field, $response->json()['errors']);

        // Payload of an object.
        $payload = [
            $field => (object)['invalid data']
        ];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldString($field, $response->json()['errors']);

        // Payload of the string.
        $payload = [
            $field => 'valid string payload',
            $field . '_confirmation' => 'valid string payload',
        ];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload);
        $this->assertArrayNotHasKey($field, $response->json()['errors']);
    }

    public function testNameValidationMaxLength()
    {
        $field = 'name';
        $maxLength = 255;

        // Payload of above max length.
        $payload = [$field => str_random($maxLength + 1)];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldMaxLength($field, $maxLength, $response->json()['errors']);

        // Payload of the max length.
        $payload = [$field => str_random($maxLength)];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload);
        $this->assertArrayNotHasKey($field, $response->json()['errors']);
    }

    public function testEmailValidationMaxLength()
    {
        $field = 'email';
        $maxLength = 255;

        // Email structure to satisfy the RFC 822 email lengths.
        $emailComponent = '.' . str_repeat('a', 64);
        $emailPayload = $emailComponent . $emailComponent . '@' . $emailComponent . $emailComponent;

        // Payload of an numeric value.
        $payload = [$field => $emailPayload];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldMaxLength($field, $maxLength, $response->json()['errors']);

        // Payload below the max length.
        $payload = [$field =>  'below-max-length@test.com'];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload);

        $this->assertArrayNotHasKey($field, $response->json()['errors']);
    }

    public function testPasswordValidationMaxLength()
    {
        $field = 'password';
        $minLength = 6;

        // Payload below the min length.
        $payload = [$field => str_random($minLength - 1)];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorFieldMinLength($field, $minLength, $response->json()['errors']);

        // Payload of the min length.
        $password = str_random($minLength);
        $payload = [
            $field => $password,
            $field . '_confirmation' => $password,
        ];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload);
        $this->assertArrayNotHasKey($field, $response->json()['errors']);
    }

    public function testPasswordConfirmedValidation()
    {
        $field = 'password';

        // Payload without a confirmed password.
        $payload = [
            'password' => str_random(16),
        ];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorPasswordConfirmed($field, $response->json()['errors']);

        // Payload with non matching confirmed password.
        $payload = [
            'password' => str_random(16),
            'password_confirmation' => str_random(16),
        ];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorPasswordConfirmed($field, $response->json()['errors']);

        $password = str_random(16);
        // Payload with matching confirmed password.
        $payload = [
            'password' => $password,
            'password_confirmation' => $password,
        ];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $response = $this->putJson($this->endpoint(), $payload);
        $this->assertArrayNotHasKey($field, $response->json()['errors']);
    }

    public function testEmailAddressValidation()
    {
        $field = 'email';

        // Payload with an invalid email address.
        $payload = [
            'email' => 'this-is-not-an-email',
        ];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $this->assertValidationErrorEmail($field, $response->json()['errors']);

        $payload = [
            'email' => 'this-is-a-valid-email@example.co.uk',
        ];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(422);

        $this->assertValidationErrorBaseStructure($response);
        $response = $this->putJson($this->endpoint(), $payload);
        $this->assertArrayNotHasKey($field, $response->json()['errors']);
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

    public function testSuccessfullyUpdatingUser()
    {
        $password = str_random();
        $payload = [
            'name' => 'Peter Parker',
            'email' => 'peter.parker@example.co.uk',
            'password' => $password,
            'password_confirmation' => $password
        ];

        // Call api /api/users.
        $response = $this->putJson($this->endpoint(), $payload)->assertStatus(200);

        $this->assertEndpointBaseStructure($response);

        // Check that the user has been updated in the database.
        $databaseUser = UserModel::find($this->userId);

        $this->assertNotNull($databaseUser);
        $this->assertEquals($payload['name'], $databaseUser->name);
        $this->assertEquals($payload['email'], $databaseUser->email);
        $this->assertEquals($payload['password'], $databaseUser->password);
        $this->assertNotEquals($this->user->updated_at, $databaseUser->updated_at);

        $responseUser = $response->json()['data'];

        $this->assertEquals($databaseUser->id, $responseUser['id']);
        $this->assertEquals($payload['name'], $responseUser['name']);
        $this->assertEquals($payload['email'], $responseUser['email']);
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

    private function createUser(array $overrides = []): UserModel
    {
        return factory(UserModel::class)->create($overrides);
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

    private function assertValidationErrorPasswordConfirmed(string $field, array $errors)
    {
        $this->assertArrayHasKey($field, $errors);
        $this->assertInternalType('array', $errors[$field]);
        $this->assertEquals(
            sprintf('The %s confirmation does not match.', $field),
            $errors[$field][0]
        );
    }

    private function assertValidationErrorEmail(string $field, array $errors)
    {
        $this->assertArrayHasKey($field, $errors);
        $this->assertInternalType('array', $errors[$field]);
        $this->assertEquals(
            sprintf('The %s must be a valid email address.', $field),
            $errors[$field][0]
        );
    }
}
