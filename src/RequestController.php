<?php

namespace Lorisleiva\RequestController;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Foundation\Http\FormRequest;

class RequestController extends FormRequest
{
    /** @var array */
    protected $middleware = [];

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        if (method_exists($this, 'middleware')) {
            $this->middleware = $this->middleware();
        }
    }

    protected function createDefaultValidator(ValidationFactory $factory)
    {
        $rules = method_exists($this, 'rules')
            ? $this->container->call([$this, 'rules'])
            : [];

        return $factory->make(
            $this->validationData(),
            $rules,
            $this->messages(),
            $this->attributes()
        );
    }

    public function getMiddleware()
    {
        return array_map(function ($middleware) {
            return [
                'middleware' => $middleware,
                'options' => [],
            ];
        }, $this->middleware);
    }

    public function callAction($method, $parameters)
    {
        $this->refreshRequestAndValidate();

        return $this->{$method}(...array_values($parameters));
    }

    public function validateResolved()
    {
        //
    }

    protected function refreshRequestAndValidate()
    {
        $this->validator = null;
        static::createFrom(request(), $this);
        parent::validateResolved();
    }
}
