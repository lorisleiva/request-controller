<?php

namespace Lorisleiva\RequestController\Tests;

class NoValidationRequestControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['router']->get('/{param?}', NoValidationRequestController::class);
        $this->app['router']->post('/', NoValidationRequestController::class);
    }

    /** @test */
    public function it_works_without_data()
    {
        $this->get('/')
            ->assertOk()
            ->assertExactJson([
                'method' => 'GET',
                'data' => [],
                'validated' => [],
                'param' => null,
                'service_injected' => true,
            ]);
    }

    /** @test */
    public function it_works_with_route_parameters()
    {
        $this->get('/some_parameter')
            ->assertOk()
            ->assertJson([
                'param' => 'some_parameter',
            ]);
    }

    /** @test */
    public function it_works_with_get_data()
    {
        $this->get('/?foo=bar')
            ->assertOk()
            ->assertJson([
                'data' => ['foo' => 'bar'],
            ]);
    }

    /** @test */
    public function it_works_with_post_data()
    {
        $this->post('/', ['foo' => 'bar'])
            ->assertOk()
            ->assertJson([
                'data' => ['foo' => 'bar'],
            ]);
    }
}
