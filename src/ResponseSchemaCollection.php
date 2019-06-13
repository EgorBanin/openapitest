<?php declare(strict_types=1);

namespace openapitest;

use Psr\Http\Message\ResponseInterface;

class ResponseSchemaCollection implements IResponseSchema
{

    private $items = [];

    public function add(int $code, string $contentType, IResponseSchema $responseSchema): self
    {
        $this->items[$code][$contentType] = $responseSchema;
    }

    public function test(ResponseInterface $response): TestResult
    {
        $code = $response->getStatusCode();
        $contentType = $response->getHeader('Content-Type')[0];
        $responseType = $this->items[$code][$contentType]?? null;

        if ($responseType) {
            $result = $responseType->test($response);
        } else {
            $result = new TestResult;
            $result->addError('Не определёна схема ответа для ' . $code . ' ' . $contentType);
        }

        return $result;
    }

}