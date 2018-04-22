<?php

namespace Tests\Feature\Endpoints;

use Tests\TestCase;
use Illuminate\Foundation\Testing\TestResponse;

abstract class AbstractEndpointTest extends TestCase
{
    /**
    * Endpoint that's going to be called for the unit test.
    * @return string
    **/
    abstract protected function endpoint(): string;
}
