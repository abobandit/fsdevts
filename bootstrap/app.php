<?php

use App\ApiHelper;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);
        $middleware->api(prepend: [
            EnsureFrontendRequestsAreStateful::class,
        ]);
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, Request $request) {
            $apiHelper = new ApiHelper();
            $beforeRedirectError = $e->getPrevious();

            if (!$apiHelper->isApiRequest($request)) {
                return null;
            }
            return match (true) {
                $e instanceof AuthenticationException => $apiHelper->handleAuthenticationException(),
                $e instanceof MethodNotAllowedHttpException => $apiHelper->handleMethodNotAllowedException(),
                $beforeRedirectError instanceof ModelNotFoundException => $apiHelper->handleModelNotFoundException($beforeRedirectError->getModel()),
                $e instanceof NotFoundHttpException, $e instanceof RouteNotFoundException => $apiHelper->handleNotFoundException(),
                $e instanceof ValidationException => $apiHelper->handleValidationException($e),
                default => $apiHelper->handleGenericException($e),
            };
        });
    })->create();
