<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\EnsureAdminIsAuthenticated::class,
        ]);

        //
         $middleware->web(\App\Http\Middleware\HandleInertiaRequests::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Session expirée / jeton CSRF invalide (419) : au lieu de planter,
        // on renvoie l'utilisateur en arrière avec un message clair, il n'a
        // plus qu'à réessayer — la nouvelle page qu'il vient de recharger
        // contient un jeton CSRF frais.
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, \Illuminate\Http\Request $request) {
            if ($request->header('X-Inertia')) {
                return back()->with('error', 'Votre session a expiré. Veuillez réessayer.');
            }
        });

        // Pages d'erreur Inertia génériques pour la production (404, 403,
        // 419, 500, 503...), affichées avec l'identité visuelle du site
        // plutôt que la page d'erreur brute de Laravel/Apache.
        $exceptions->respond(function (\Symfony\Component\HttpFoundation\Response $response, \Throwable $exception, \Illuminate\Http\Request $request) {
            if (! config('app.debug') && in_array($response->getStatusCode(), [403, 404, 419, 429, 500, 503])) {
                return \Inertia\Inertia::render('Error', ['status' => $response->getStatusCode()])
                    ->toResponse($request)
                    ->setStatusCode($response->getStatusCode());
            }

            return $response;
        });
    })->create();
