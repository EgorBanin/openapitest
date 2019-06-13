<?php declare(strict_types=1);

namespace openapitest;

use Psr\Http\Message\ResponseInterface;

class ResponseSchema implements IResponseSchema
{
    private $description;

    private $content;

    public function __construct($description, $content)
    {
        $this->description = $description;
        $this->content = $content;
    }

    public function test(ResponseInterface $response): TestResult
    {
        $result = new TestResult();

        return $result;
    }

}