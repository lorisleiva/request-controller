<?php

namespace Lorisleiva\RequestController;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Lorisleiva\RequestController\RequestController
 */
class RequestControllerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'request-controller';
    }
}
