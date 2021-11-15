<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Spatie\QueryBuilder\Filters\Filter;

class ContentFilter extends BaseQueryFilter implements Filter
{
    protected string $module;

    protected bool $no_unique_content = false;

    public function __construct(string $module, $no_unique_content = false)
    {
        $this->module = $module;
        $this->no_unique_content = $no_unique_content;
    }

    public function __invoke(Builder $query, $value, string $property)
    {
        $contents = $this->getContents($value);

        $ids = array_unique(Arr::pluck($contents, 'object'));

        if($this->no_unique_content) {
            $query->whereNotIn('id', $ids);
        }
        else {
            $query->whereIn('id', $ids);
        }
    }

    protected function getContents($value)
    {
        $response = Http::withToken(request()->bearerToken())
            ->baseUrl(config('services.content.domain'))
            ->asJson()
            ->acceptJson()
            ->get('/unique-content', [
                'filter' => [
                    'field' => $value,
                    'module' => $this->module,
                ],
                'fields' => [
                    'unique_contents' => 'object'
                ],
            ]);

        return $response->json();
    }
}
