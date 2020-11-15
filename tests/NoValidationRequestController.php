<?php

namespace Lorisleiva\RequestController\Tests;

use Lorisleiva\RequestController\RequestController;

class NoValidationRequestController extends RequestController
{
    public function __invoke(SomeInjectedService $service, $param = null)
    {
        return [
            'method' => $this->method(),
            'data' => $this->all(),
            'validated' => $this->validated(),
            'param' => $param,
            'service_injected' => $service instanceof SomeInjectedService,
        ];
    }
}
