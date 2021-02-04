<?php

namespace Library\Model;

interface EntityInterface
{
    public function getFields(): array;
    public function fetchOne(int $id);
    public function save(array $data);
    public function delete();
}