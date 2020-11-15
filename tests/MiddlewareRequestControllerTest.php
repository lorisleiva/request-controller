<?php

namespace Lorisleiva\RequestController\Tests;

class MiddlewareRequestControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['router']->get('/', MiddlewareRequestController::class);
    }

    /** @test */
    public function it_can_provide_middleware()
    {
        $this->get('/?authorized=0')
            ->assertStatus(403)
            ->assertSee('Unauthorized from the middleware');
    }

    /** @test */
    public function it_reaches_the_invoke_method()
    {
        $this->get('/?authorized=1')
            ->assertOk()
            ->assertSee('Done');
    }
}
