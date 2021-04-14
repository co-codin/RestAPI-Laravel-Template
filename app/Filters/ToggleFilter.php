<?php


namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Spatie\QueryBuilder\Filters\Filter;

class ToggleFilter implements Filter
{
    public function __construct(
        protected string $module
    )
    {}

    public function __invoke(Builder $query, $value, string $property)
    {
        $modelIds = $this->getVerifiedModels($value);

        $modelIds = array_unique(Arr::pluck($modelIds, 'object'));

        $query->whereIn('id', $modelIds);
    }

    protected function getVerifiedModels($value)
    {
        $response = Http::withToken(request()->bearerToken())
            ->baseUrl(config('services.content.domain'))
            ->asJson()
            ->acceptJson()
            ->get('/toggles', [
                'filter' => [
                    'module' => $value
                ],
            ]);

        return $response->json();
    }
}
