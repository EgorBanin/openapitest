<?php declare(strict_types=1);

namespace openapitest;

class SimpleRefResolver implements IRefResolver
{

    private $schemas;

    public function __construct(object $schemas)
    {
        $this->schemas = $schemas;
    }

    public function resolve($refName): ?object
    {
        $schema = $this->schemas->{$refName}?? null;


        return $schema;
    }

}