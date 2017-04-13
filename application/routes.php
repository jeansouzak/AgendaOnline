<?php
$route = new League\Route\RouteCollection();
$authMiddleware = [new \Application\AuthenticateMiddleware(), 'checkAuthenticate'];


$route->map('GET', '/', '\Application\Controller\ApplicationController::index');
$route->map('GET', '/destroy', '\Application\Controller\UserController::destroy');
$route->map('POST', '/user/create', '\Application\Controller\UserController::create');
$route->map('POST', '/user/login', '\Application\Controller\UserController::login');

$route->group('/contact', function ($route) {
    $route->map('GET', '/', '\Application\Controller\ContactController::index');
    $route->map('GET', '/create', '\Application\Controller\ContactController::create');
    $route->map('GET', '/edit/{id:number}', '\Application\Controller\ContactController::edit');
    $route->map(['POST', 'PUT'], '/save', '\Application\Controller\ContactController::save');
    $route->map(['GET', 'DELETE'], '/delete/{id}', '\Application\Controller\ContactController::delete');

})->middleware($authMiddleware);

//API
$route->group('/api/user', function ($route) {
    $route->map('POST', '/create', '\Application\Controller\Api\UserController::create');
    $route->map('POST', '/login', '\Application\Controller\Api\UserController::login');
    $route->map('GET', '/user/destroy', '\Application\Controller\Api\UserController::destroy');
});

$route->group('/api/contact', function ($route) {
    $route->map('GET', '/', '\Application\Controller\Api\ContactController::index');
    $route->map('POST', '/save', '\Application\Controller\Api\ContactController::save');
    $route->map('POST', '/update', '\Application\Controller\Api\ContactController::update');
    $route->map('DELETE', '/delete/{id}', '\Application\Controller\Api\ContactController::delete');
})->middleware($authMiddleware);


$response = $route->dispatch(
    Zend\Diactoros\ServerRequestFactory::fromGlobals(
        $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
    )
, new Zend\Diactoros\Response());

$emitter = new \Zend\Diactoros\Response\SapiEmitter();
$emitter->emit($response);
