<?php

namespace Lorisleiva\RequestController;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RequestController extends FormRequest
{
    use DispatchesJobs;
    use ValidatesRequests;

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
}
