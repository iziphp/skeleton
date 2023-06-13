<?php

namespace Shared\Presentation\HTTP\Response;

use Laminas\Diactoros\Exception\InvalidArgumentException;
use Laminas\Diactoros\Exception\UnwritableStreamException;
use Laminas\Diactoros\Exception\UnseekableStreamException;
use Laminas\Diactoros\Response\JsonResponse as BaseJsonResponse;
use PhpStandard\Http\Message\StatusCodeEnum;
use Psr\Http\Message\ResponseInterface;

/** @package Shared\UI\Response */
class JsonResponse extends BaseJsonResponse implements ResponseInterface
{
    /**
     * @inheritDoc
     * @param mixed $data 
     * @param StatusCodeEnum $status 
     * @param array $headers 
     * @param int $encodingOptions 
     * @return void 
     * @throws InvalidArgumentException 
     * @throws UnwritableStreamException 
     * @throws UnseekableStreamException 
     */
    public function __construct(
        $data,
        StatusCodeEnum $status = StatusCodeEnum::OK,
        array $headers = [],
        private int $encodingOptions = self::DEFAULT_JSON_FLAGS
    ) {
        parent::__construct(
            $data,
            $status->value,
            $headers,
            $encodingOptions
        );
    }
}
