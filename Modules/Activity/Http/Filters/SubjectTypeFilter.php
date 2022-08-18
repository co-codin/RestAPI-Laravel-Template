<?php

namespace Modules\Activity\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class SubjectTypeFilter implements Filter
{

    protected array $mappings = [
        'Product' => 'Товар',
        'Redirect' => 'Редирект',
        'Category' => 'Категория',
        'Brand' => 'Производитель',
        'Property' => 'Характеристика',
        'SeoRule' => 'SEO-правило',
        'News' => 'Новость',
        'Filter' => 'Фильтр',
        'CaseModel' => 'Кейс',
        'Cabinet' => 'Кабинет',
    ];


    public function __invoke(Builder $query, $value, string $property)
    {
        $search = array_search($value, $this->mappings);

        $query->where('subject_type', 'LIKE', "%{$search}%");
    }
}
