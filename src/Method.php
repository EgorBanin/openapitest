<?php declare(strict_types=1);

namespace openapitest;

use Psr\Http\Message\RequestInterface;

class Method
{

    private $path;

    private $method;

    private $paramTypes;

    private $responses;

    public function __construct(string $path, string $method, array $paramTypes, ResponseSchemaCollection $responses)
    {
        $this->path = $path;
        $this->method = $method;
        $this->paramTypes = $paramTypes;
        $this->responses = $responses;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    public function createRequest(string $uri, array $params): RequestInterface
    {
        $uri .= $this->createUri($this->path, $this->getParamsInLocation($params, 'path'));
        $query = $this->getParamsInLocation($params, 'query');
        if ($query) {
            $uri .= '?' . http_build_query($query);
        }
        $request = new Request($this->method, $uri);


        return $request;
    }

    public function getResponseSchema(int $code = null, string $contentType = null)
    {
        return $this->responses->subset($code, $contentType);
    }

    private function createUri(string $path, array $params): string
    {
        $replaces = [];
        foreach ($params as $name => $value) {
            $replaces['{' . $name . '}'] = $value;
        }
        return strtr($path, $replaces);
    }

    private function getParamsInLocation($params, $location)
    {
        $pathParams = [];
        foreach ($this->paramTypes as $type) {
            $in = $type->in?? null;
            if ($in === $location) {
                $name = $type->name?? '';
                $pathParams[$name] = $params[$name]?? null;
            }
        }

        return $pathParams;
    }

}