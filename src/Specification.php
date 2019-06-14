<?php declare(strict_types=1);

namespace openapitest;

class Specification
{

    private $data;

    private $refResolver;

    public function __construct(object $data, IRefResolver $refResolver)
    {
        $this->data = $data;
        $this->refResolver = $refResolver;
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
                $responseSchema->add(
                    (int) $code,
                    $contentType,
                    new ResponseSchema($description, $this->refResolver->resolveAll($schema))
                );
            }
        }

        return $responseSchema;
    }
}