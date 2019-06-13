<?php declare(strict_types=1);

namespace openapitest;

interface IRefResolver
{
    public function resolve($refName): ?object;
}