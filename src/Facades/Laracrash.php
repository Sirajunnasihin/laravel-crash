<?php

namespace Laracrash\Facades;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void registerRenderHook(string $name, \Closure $callback)
 *
 * @see FilamentManager
 */
class Laracrash extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laracrash';
    }
}