<?php declare(strict_types=1);

namespace openapitest;

use Psr\Http\Message\ResponseInterface;

class Response
{

    private $statusCode;

    private $contentType;

    private $data;

    public function __construct(int $statusCode, string $contentType, object $data)
    {
        $this->statusCode = $statusCode;
        $this->contentType = $contentType;
        $this->data = $data;
    }

    public static function fromHttpResponse(ResponseInterface $response, callable $parser)
    {
        $contentType = $response->getHeader('Content-Type')[0];
        return new Response(
            $response->getStatusCode(),
            $contentType,
            $parser((string) $response->getBody())
        );
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @return object
     */
    public function getData(): object
    {
        return $this->data;
    }

}