# Use FormRequests as invokable controllers

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lorisleiva/request-controller.svg)](https://packagist.org/packages/lorisleiva/request-controller)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/lorisleiva/request-controller/Tests?label=tests)](https://github.com/lorisleiva/request-controller/actions?query=workflow%3ATests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/lorisleiva/request-controller.svg)](https://packagist.org/packages/lorisleiva/request-controller)

Aren't you tired of having to create a `FormRequest` class for almost every invokable `Controller` you create?

It turns out, [with a few tweaks](https://lorisleiva.com/if-formrequests-and-invokable-controllers-had-a-baby/), you can use a `FormRequest` class as a controller.

This package provides only one class: a `RequestController` class that extends the `FormRequest` class we all know and adapt it slightly so it works as an invokable `Controller`.

## Installation

```bash
composer require lorisleiva/request-controller
```

## Usage

``` php
class MyController extends RequestController
{
    public function middleware()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    public function __invoke()
    {
        // ...
    }
}
```

Note that the `middleware`, `authorize` and `rules` methods are all optional and default to the value displayed in the example.

Since `RequestController` extends `FormRequest`, you have access to all the methods you are used to, like:
- `$this->get($attribute)` — To access a request attribute.
- `$this->route($attribute)` — To access a route parameter.
- `$this->validated()` — To access the validated data.
- `$this->user()` — To access the user.
- Etc.

Similarly, you can override the same `FormRequest` methods you are used to, in order to customize the validation logic:
- `attributes()` — To provide user-friendly names to your attributes.
- `message()` — To customize your validation messages.
- `withValidator()` — To extends the current validator.
- `validator()` — To take full control over the validator created.
- Etc.

Enjoy! ✨
