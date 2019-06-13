<?php declare(strict_types=1);

namespace openapitest;

use Psr\Http\Message\RequestInterface;

class Method
{

    private $responses;

    public function __construct($method, ResponseSchemaCollection $responses)
    {
        $this->responses = $responses;
    }

    public function createRequest(array $params): RequestInterface
    {

    }

    public function getResponseSchema(int $code = null, string $contentType = null)
    {
        return $this->responses->subset($code, $contentType);
    }

}