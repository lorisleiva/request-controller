<?php

namespace Lorisleiva\RequestController\Tests;

use Lorisleiva\RequestController\RequestController;
use PHPUnit\Framework\TestCase as PHPUnit;

class SimpleValidationRequestController extends RequestController
{
    public function authorize()
    {
        return $this->get('authorized', true);
    }

    public function rules(SomeInjectedService $service)
    {
        PHPUnit::assertTrue($service instanceof SomeInjectedService);

        return [
            'foo' => ['required', 'string', 'min:3'],
            'bar' => ['integer'],
        ];
    }

    public function __invoke()
    {
        return 'Done';
    }
}
