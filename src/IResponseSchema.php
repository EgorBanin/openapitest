<?php declare(strict_types=1);

namespace openapitest;

interface IResponseSchema
{
    public function test(Response $response): TestResult;
}