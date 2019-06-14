<?php declare(strict_types=1);

namespace openapitest;

class ResponseSchema implements IResponseSchema
{

    const TYPE_OBJECT = 'object';

    const TYPE_ARRAY = 'array';

    const TYPE_STRING = 'string';

    const TYPE_INTEGER = 'integer';

    const TYPE_BOOLEAN = 'boolean';

    const TYPE_UNKNOWN = 'unknown';

    private $description;

    private $data;

    public function __construct($description, $data)
    {
        $this->description = $description;
        $this->data = $data;
    }

    public function test(Response $response): TestResult
    {
        $result = new TestResult();

        $responseType = $this->getType($response->getData());
        if ($this->data->type !== $responseType) {
            $result->addError('Тип ' . $responseType . ' не соответствует ожидаемому');
        }

        return $result;
    }

    private static function getType($data)
    {
        $phpType = gettype($data);
        switch ($phpType) {
            case 'object':
                $type = ResponseSchema::TYPE_OBJECT;
                break;
            case 'array':
                if (
                    empty($data)
                    || array_keys($data) === range(0, count($data) - 1)
                ) {
                    $type = ResponseSchema::TYPE_ARRAY;
                } else {
                    $type = ResponseSchema::TYPE_OBJECT;
                }
                break;
            case 'integer':
                $type = ResponseSchema::TYPE_INTEGER;
                break;
            case 'boolean':
                $type = ResponseSchema::TYPE_BOOLEAN;
                break;
            default:
                $type = ResponseSchema::TYPE_UNKNOWN;
        }

        return $type;
    }

}