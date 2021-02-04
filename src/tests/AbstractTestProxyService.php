<?php

namespace Tests;

abstract class AbstractTestProxyService
    extends AbstractTestCaseService
{
    public function getEntitiesFields(array $data): array
    {
        return array_map(fn($datum) => $datum->getFields(), $data);
    }
}