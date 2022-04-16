<?php

namespace App\Http\Controllers;


use App\Enums\BaseEnum;
use Cache;
use HaydenPierce\ClassFinder\ClassFinder;

class EnumController extends \Illuminate\Routing\Controller
{
    protected $namespaces = [
        'App\Enums',
        'Modules',
    ];

    public function index()
    {
        return [
            'enums' => Cache::rememberForever(
                'enums',
                fn() => $this->findEnumClassesInNamespaces($this->namespaces)
            ),
        ];
    }

    protected function findEnumClassesInNamespaces(array $namespaces): array
    {
        return collect($namespaces)
            ->map(fn($namespace) => ClassFinder::getClassesInNamespace($namespace, ClassFinder::RECURSIVE_MODE))
            ->flatten(1)
            ->filter(fn(string $class) => is_subclass_of($class, BaseEnum::class))
            ->mapWithKeys(fn($class) => [class_basename($class) => ['items' => $class::asSelectArray()]])
            ->toArray();
    }
}
