<?php


namespace Modules\Review\Http\Builders;


use App\Http\Builders\BaseBuilder;
use App\Http\Filters\DateFilter;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Concerns\SortsQuery;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;

class ProductReviewBuilder extends BaseBuilder
{
    public function builder(Model|Builder|string $model): SortsQuery|SpatieQueryBuilder
    {
        return SpatieQueryBuilder::for($this->getQuery($model))
            ->allowedFields($this->getFields())
            ->defaultSort('-id')
            ->allowedSorts($this->getSorts())
            ->allowedFilters($this->getFilters())
            ->allowedIncludes([
                'product',
                'client'
            ]);
    }

    /**
     * @param array|null $columns
     * @return string[]
     */
    public function getFields(?array $columns = null): array
    {
        $fields = [
            'id',
            'product_id',
            'client_id',
            'experience',
            'advantages',
            'disadvantages',
            'comment',
            'status',
            'is_confirmed',
            'ratings',
            'like',
            'dislike',
            'created_at',
            'updated_at',
            'answered_at',
        ];

        return $this->filter($fields, $columns)
            ->map($this->fieldWithRelationName())
            ->toArray();
    }

    /**
     * @param array|null $columns
     * @return array
     */
    public function getFilters(?array $columns = null): array
    {
        $filters = [
            'advantages',
            'disadvantages',
            'comment',
            'id' => AllowedFilter::exact('id'),
            'product_id' => AllowedFilter::exact('product_id'),
            'client_id' => AllowedFilter::exact('client_id'),
            'experience' => AllowedFilter::exact('experience'),
            'status' => AllowedFilter::exact('status'),
            'is_confirmed' => AllowedFilter::exact('is_confirmed'),
            'like' => AllowedFilter::exact('like'),
            'dislike' => AllowedFilter::exact('dislike'),
            'created_at' => AllowedFilter::custom('created_at', new DateFilter(), 'created_at'),
            'answered_at' => AllowedFilter::custom('answered_at', new DateFilter(), 'answered_at'),
            'updated_at' => AllowedFilter::custom('created_at', new DateFilter(), 'updated_at'),
        ];

        if (!is_null($this->relationDtoCollection)) {
            $filters = [];
        }

        return $this->filter($filters, $columns)->toArray();
    }

    /**
     * @param array|null $columns
     * @return array
     */
    public function getSorts(?array $columns = null): array
    {
        $sorts = [
            'id',
            'product_id',
            'client_id',
            'experience',
            'status',
            'is_confirmed',
            'like',
            'dislike',
            'answered_at',
        ];

        if (!is_null($this->relationDtoCollection)) {
            $sorts = [];
        }

        return $this->filter($sorts, $columns)->toArray();
    }
}
