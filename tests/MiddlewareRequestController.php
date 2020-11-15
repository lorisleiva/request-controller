<?php

namespace Lorisleiva\RequestController\Tests;

use Closure;
use Illuminate\Http\Request;
use Lorisleiva\RequestController\RequestController;

class MiddlewareRequestController extends RequestController
{
    public function middleware()
    {
        return [
            function (Request $request, Closure $next) {
                if (! $request->get('authorized', true)) {
                    abort(403, 'Unauthorized from the middleware');
                }

                return $next($request);
            }
        ];
    }

    public function __invoke()
    {
        return 'Done';
    }
}
