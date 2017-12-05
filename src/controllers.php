<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

/*  - have one route :
        * HTTP GET /admin/users
        * Display the list of users as JSON response
*/
$app->get('/admin/users', 'Controller\UsersController::getAll')
    ->bind('allUsers');


/*  - have one route :
        * HTTP POST /admin/user
        * Create a new user
*/
$app->post('/admin/user','Controller\UsersController::createUser')
    ->bind('createUser');


/*
- have one route :
    * HTTP delete /admin/user/userId
    * Delete a user
*/
$app->delete('/admin/user/{id}', 'Controller\UsersController::deleteUser')
    ->bind('deleteUser');



$app->get('/admin', 'Controller\UsersController::getHomepage')
    ->bind('homepage');


$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig',
        [
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ]
    );
});

/*$app->get('/admin', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})
    ->bind('homepage')
;
*/


$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
