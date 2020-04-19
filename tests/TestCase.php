<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    private $oldExceptionHandler;

    protected function setUp(): void
    {
        parent::setUp();

//        $this->disableExceptionHandling();
    }


    protected function signIn($user = null) {

        $user = $user ?: create('App\User');

        return $this->actingAs($user);
    }


    protected function disableExceptionHandling()
    {

        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}

            public function report(\Exception $exception) {}

            public function render($request, \Exception $exception)
            {
                throw $exception;
            }

        });

    }


    public function withExceptionHandling()
    {

        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);

        return $this;

    }
}
