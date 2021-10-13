<?php
require __DIR__ . "/vendor/autoload.php";

// Package that handles routing for us
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $route) {
    // creating routes
    $route->addRoute('GET', '/', 'QuizController@showHome');
    $route->addRoute('POST', '/quiz', 'QuizController@checkQuiz');
    $route->addRoute('POST', '/answer', 'QuizController@saveAnswer');
    $route->addRoute('GET', '/finish/{results}', 'QuizController@showQuizResults');
});

// Fetch method and URI
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $params = $routeInfo[2];

        [$controller, $method] = explode('@', $handler);
        $controllerPath = '\quiz\Controllers\\' . $controller;
        echo (new $controllerPath)->{$method}($params);
        break;
}
