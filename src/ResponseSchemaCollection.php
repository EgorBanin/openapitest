<?php declare(strict_types=1);

namespace openapitest;

use Psr\Http\Message\ResponseInterface;

class ResponseSchemaCollection implements IResponseSchema
{

    private $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function add(int $code, string $contentType, IResponseSchema $responseSchema): self
    {
        $this->items[$code][$contentType] = $responseSchema;

        return $this;
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

    public function subset(?int $code, ?string $contentType)
    {
        if (isset($code)) {
            $subset = array_filter($this->items, function ($key) use ($code) {
                return $key === $code;
            }, ARRAY_FILTER_USE_KEY);
        } else {
            $subset = $this->items;
        }

        if (isset($contentType)) {
            foreach ($subset as $key => $content) {
                $subset[$key] = array_filter($content, function ($key) use ($contentType) {
                    return $key === $contentType;
                }, ARRAY_FILTER_USE_KEY);
            }
        }

        return new self($subset);
    }

}