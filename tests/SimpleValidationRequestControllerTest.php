<?php

namespace Lorisleiva\RequestController\Tests;

class SimpleValidationRequestControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['router']->post('/', SimpleValidationRequestController::class);
    }

    /** @test */
    public function it_passes_authorization_and_validation()
    {
        $this->post('/', ['foo' => 'required'])
            ->assertOk()
            ->assertSee('Done');
    }

    /** @test */
    public function it_fails_authorization()
    {
        $this->post('/', ['authorized' => false])
            ->assertStatus(403)
            ->assertSee('This action is unauthorized');
    }

    /** @test */
    public function it_fails_validation()
    {
        $this->postJson('/', ['bar' => 'some text'])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'foo' => 'The foo field is required.',
                'bar' => 'The bar must be an integer.',
            ]);
    }

    /** @test */
    public function it_revalidates_at_each_call()
    {
        $this->postJson('/', ['authorized' => false])
            ->assertStatus(403);

        $this->postJson('/', ['foo' => 'some text'])
            ->assertStatus(200);

        $this->postJson('/', ['bar' => 'some text'])
            ->assertStatus(422);
    }
}
