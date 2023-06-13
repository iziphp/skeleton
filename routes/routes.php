<?php

use PhpStandard\Router\Group;
use Common\Presentation\UI\RequestHandlers\IndexRequestHandler;
use Common\Presentation\UI\RequestHandlers\NotFoundRequestHandler;

$group = new Group();

$group->map('GET', '/', IndexRequestHandler::class);

// Not found handler. Should be set as the lastest route
$group->map('GET', '*', NotFoundRequestHandler::class);

return $group;
