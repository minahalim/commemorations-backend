<?php

declare (strict_types = 1);

use App\Application\Actions\Name\CreateNameAction;
use App\Application\Actions\Name\DeleteNameAction;
use App\Application\Actions\Name\ListNamesAction;
use App\Application\Actions\Name\UpdateNameAction;
use App\Application\Actions\Name\ViewNameAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->group('/names', function (Group $group) {
        $group->get('', ListNamesAction::class);
        $group->get('/{id}', ViewNameAction::class);
        $group->post('/create', CreateNameAction::class);
        $group->post('/update', UpdateNameAction::class);
        $group->post('/delete', DeleteNameAction::class);
    });
};