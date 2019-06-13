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
        foreach ($paths as $pathName => $pathData) {
            foreach ($pathData as $methodName => $methodData) {
                $method = new Method(
                    $pathName,
                    $methodName,
                    $methodData->parameters?? [],
                    $this->createResponseSchema($methodData)
                );

                yield $method;
            }
        }
    }

    private function createResponseSchema($methodData): ResponseSchemaCollection
    {
        $responseSchema = new ResponseSchemaCollection();

        $responses = $methodData->responses?? [];
        foreach ($responses as $code => $responseData) {
            $content = $responseData->content?? [];
            foreach ($content as $contentType => $contentData) {
                $description = $responseData->description?? '';
                $schema = $contentData->schema?? ((object)[]);
                $responseSchema->add((int) $code, $contentType, new ResponseSchema($description, $schema));
            }
        }

        return $responseSchema;
    }
}