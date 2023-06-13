<?php

namespace Shared\Presentation\HTTP\Response;

use Laminas\Diactoros\Exception\InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse as BaseResponse;
use PhpStandard\Http\Message\StatusCodeEnum;
use Psr\Http\Message\ResponseInterface;

/** @package Shared\UI\Response */
class HtmlResponse extends BaseResponse implements ResponseInterface
{
    /**
     * @inheritDoc
     * @param mixed $html 
     * @param StatusCodeEnum $status 
     * @param array $headers 
     * @return void 
     * @throws InvalidArgumentException 
     */
    public function __construct(
        $html,
        StatusCodeEnum $status = StatusCodeEnum::OK,
        array $headers = []
    ) {
        parent::__construct(
            $html,
            $status->value,
            $headers
        );
    }
}
