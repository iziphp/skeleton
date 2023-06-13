<?php

namespace Shared\Presentation\HTTP\Response;

use Laminas\Diactoros\Exception\InvalidArgumentException;
use Laminas\Diactoros\Response\RedirectResponse as BaseResponse;
use PhpStandard\Http\Message\StatusCodeEnum;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/** @package Shared\UI\Response */
class RedirectResponse extends BaseResponse implements ResponseInterface
{
    /**
     * @inheritDoc
     * @param string|UriInterface $uri 
     * @param StatusCodeEnum $status 
     * @param array $headers 
     * @return void 
     * @throws InvalidArgumentException 
     */
    public function __construct(
        string|UriInterface $uri,
        StatusCodeEnum $status = StatusCodeEnum::FOUND,
        array $headers = []
    ) {
        parent::__construct($uri, $status->value, $headers);
    }
}
