<?php declare(strict_types=1);

namespace openapitest;

use Psr\Http\Message\ResponseInterface;

class ResponseSchema implements IResponseSchema
{
    private $description;

    private $data;

    public function __construct($description, $data)
    {
        $this->description = $description;
        $this->data = $data;
    }

    public function test(ResponseInterface $response): TestResult
    {
        $result = new TestResult();

        return $result;
    }

}