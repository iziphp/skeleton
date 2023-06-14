<?php

use Laminas\Diactoros\ServerRequestFactory;
use PhpStandard\Http\ResponseEmitter\EmitterInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Shared\Infrastructure\HTTP\ServerRequestHandler;

// Application start timestamp
define('APP_START', microtime(true));

/** @var ContainerInterface $container */
$container = include __DIR__ . '/../bootstrap/app.php';

/** @var ServerRequestHandler $handler */
$handler = $container->get(ServerRequestHandler::class);

/**
 * A server request captured from global PHP variables
 * @var ServerRequestInterface $request
 */
$request = ServerRequestFactory::fromGlobals();

/** @var ResponseInterface $response */
$response = $handler->handle($request);

/** @var EmitterInterface $emitter */
$emitter = $container->get(EmitterInterface::class);

// Emit response
$emitter->emit($response);