<?php

namespace Shared\Presentation\HTTP\Response;

use Laminas\Diactoros\Exception\InvalidArgumentException;
use Laminas\Diactoros\Response\EmptyResponse as BaseResponse;
use PhpStandard\Http\Message\StatusCodeEnum;
use Psr\Http\Message\ResponseInterface;

/** @package Shared\UI\Response */
class EmptyResponse extends BaseResponse implements ResponseInterface
{
    /**
     * @inheritDoc
     * @param StatusCodeEnum $status 
     * @param array $headers 
     * @return void 
     * @throws InvalidArgumentException 
     */
    public function __construct(
        StatusCodeEnum $status = StatusCodeEnum::NO_CONTENT,
        array $headers = []
    ) {
        parent::__construct($status->value, $headers);
    }
}
