<?php

namespace Modules\Search\Contracts;

interface SearchIndex
{
    public function name(): string;

    public function repository(): string;

    public function resource(): string;

    public function settings(): array;

    public function mappings(): array;

    public function create(?string $indexName = null): void;

    public function delete(?string $indexName = null): void;
}
