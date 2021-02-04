<?php

namespace Library\Model\Adapter;

interface AdapterServiceInterface
{
    public function getConnection();
    public function getFetchType(string $type): int;
    public function quote(string $val): string;
    public function getLastInsertedId(): int;
    public function execute(string $sql, array $bind = []);
    public function fetchAll(string $sql, array $bind = []): array;
    public function fetchColumn(string $sql, array $bind = []);
    public function fetchOne(string $sql, array $bind = []);
}