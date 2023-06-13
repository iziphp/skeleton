<?php

namespace Shared\Presentation\HTTP\Response;

use Laminas\Diactoros\Exception\InvalidArgumentException;
use Laminas\Diactoros\Response as BaseResponse;
use PhpStandard\Http\Message\StatusCodeEnum;
use Psr\Http\Message\ResponseInterface;

/** @package Shared\UI\Response */
class Response extends BaseResponse implements ResponseInterface
{
    /**
     * @inheritDoc
     * @param string $body 
     * @param StatusCodeEnum $status 
     * @param array $headers 
     * @return void 
     * @throws InvalidArgumentException 
     */
    public function __construct(
        $body = 'php://memory',
        StatusCodeEnum $status = StatusCodeEnum::OK,
        array $headers = []
    ) {
        parent::__construct($body, $status->value, $headers);
    }
}
