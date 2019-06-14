<?php declare(strict_types=1);

namespace openapitest;

class SimpleRefResolver implements IRefResolver
{

    private $schemas;

    public function __construct(object $schemas)
    {
        $this->schemas = $schemas;
    }

    public function resolveAll($data)
    {
        if (is_iterable($data) || ($data instanceof \StdClass)) {
            $refs = [];
            foreach ($data as $key => &$item) {
                if ($key === '$ref') {
                    $data = $this->resolveRef($item); // todo
                    break;
                } else {
                    $item = $this->resolveAll($item); // ! рекурсия
                }
             }
            $result = $data;
        } else {
            $result = $data;
        }

        return $result;
    }

    public function resolveRef($refName): ?object
    {
        $ref = str_replace('#/components/schemas/', '', $refName);
        $schema = $this->schemas->{$ref}?? null;


        return $schema;
    }

}