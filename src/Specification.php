<?php declare(strict_types=1);

namespace openapitest;

class Specification
{

    private $data;

    public function __construct($data, $refResolver = null)
    {
        $this->data = $data;
    }

    /**
     * @return iterable
     */
    public function generateMethods(): iterable
    {
        $paths = $this->data->paths?? [];
        foreach ($paths as $methodName => $methodData) {
            $method = new Method($methodName, $this->createResponses($methodData));

            yield $method;
        }
    }

    private function createResponses($methodData): array
    {

    }
}