<?php


use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class ExampleTest extends TestCase
{

    private static $spec;

    private static $requestData;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $specJson = file_get_contents(__DIR__ . '/../spec.json');
        self::$spec = new \openapitest\Specification(json_decode($specJson));
        self::$requestData = require __DIR__ . '/../requestData.php';
    }

    /**
     * @dataProvider provide_testSchema
     * @param RequestInterface $rq
     */
    public function testSchema(RequestInterface $rq, $schema)
    {
        $httpClient = new Client();
        $rs = $httpClient->send($rq);
        $result = $schema->testResponse($rs);

        $this->assertTrue(!$result->hasErrors());
    }

    public function provide_testSchema()
    {
        foreach (self::$spec->getMethods() as $method) {
            $set = self::$requestData[$method->getPath()][$method->getMethod()]?? [];
            foreach ($set as list($params, $expectedCode)) {
                yield [
                    $method->createRequest($params),
                    $method->getSchema($expectedCode)
                ];
            }
        }
    }



}