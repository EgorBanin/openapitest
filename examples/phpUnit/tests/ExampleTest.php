<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use openapitest\IResponseSchema;
use openapitest\Method;
use openapitest\Specification;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class ExampleTest extends TestCase
{

    /**
     * @var Specification
     */
    private $spec;

    private $requestData;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $specJson = file_get_contents(__DIR__ . '/../spec.json');
        $this->spec = new Specification(json_decode($specJson));
        $this->requestData = require __DIR__ . '/../requestData.php';
    }

    /**
     * @dataProvider provide_testSchema
     * @param RequestInterface $rq
     * @param IResponseSchema $schema
     * @throws GuzzleException
     */
    public function testSchema(RequestInterface $rq, IResponseSchema $schema)
    {
        $httpClient = new Client();
        $rs = $httpClient->send($rq);
        $result = $schema->test($rs);

        $this->assertTrue(!$result->hasErrors(), implode("\n", $result->getErrors()));
    }

    public function provide_testSchema()
    {
        /** @var Method $method */
        foreach ($this->spec->generateMethods() as $method) {
            $set = $this->requestData[$method->getPath()][$method->getMethod()]?? [];
            foreach ($set as $opts) {
                yield [
                    $method->createRequest('http://httpbin.org/anything', $opts['params']),
                    $method->getResponseSchema($opts['expectedCode'])
                ];
            }
        }
    }

}