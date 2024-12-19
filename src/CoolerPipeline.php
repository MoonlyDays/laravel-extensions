<?php

namespace MoonlyDays\LaravelPipelinesExceptTheyreCooler;

use Closure;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Throwable;

class CoolerPipeline extends Pipeline
{
    /**
     * The parameters that will be sent alongside the passable object.
     */
    protected array $with = [];

    /**
     * Set the parameters that will be sent alongside the passable object.
     *
     * @param  array|mixed  $parameters
     * @return $this
     */
    public function with(mixed $parameters): static
    {
        $this->with = Arr::wrap($parameters);

        return $this;
    }

    /**
     * Get a Closure that represents a slice of the application onion.
     */
    protected function carry(): Closure
    {
        return function ($stack, $pipe) {
            return function ($passable) use ($stack, $pipe) {
                try {
                    if (is_callable($pipe)) {
                        // If the pipe is a callable, then we will call it directly, but otherwise we
                        // will resolve the pipes out of the dependency container and call it with
                        // the appropriate method and arguments, returning the results back out.
                        return $pipe($passable, $stack, ...$this->with);
                    }

                    if (! is_object($pipe)) {
                        [$name, $parameters] = $this->parsePipeString($pipe);

                        // If the pipe is a string we will parse the string and resolve the class out
                        // of the dependency injection container. We can then build a callable and
                        // execute the pipe function giving in the parameters that are required.
                        $pipe = $this->getContainer()->make($name);

                        $parameters = array_merge([$passable, $stack], $parameters);
                    } else {
                        // If the pipe is already an object we'll just make a callable and pass it to
                        // the pipe as-is. There is no need to do any extra parsing and formatting
                        // since the object we're given was already a fully instantiated object.
                        $parameters = [$passable, $stack];
                    }

                    $parameters = array_merge($parameters, $this->with);

                    $carry = method_exists($pipe, $this->method)
                        ? $pipe->{$this->method}(...$parameters)
                        : $pipe(...$parameters);

                    return $this->handleCarry($carry);
                } catch (Throwable $e) {
                    return $this->handleException($passable, $e);
                }
            };
        };
    }
}
