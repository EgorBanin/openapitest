<?php declare(strict_types=1);

namespace openapitest;

use Psr\Http\Message\ResponseInterface;

interface IResponseSchema
{
    public function test(ResponseInterface $response): TestResult;
}