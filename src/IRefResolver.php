<?php declare(strict_types=1);

namespace openapitest;

interface IRefResolver
{

    public function resolveAll($data);

    public function resolveRef($refName): ?object;
}