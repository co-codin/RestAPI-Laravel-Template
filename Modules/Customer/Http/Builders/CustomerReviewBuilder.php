<?php


namespace Modules\Customer\Http\Builders;


use App\Http\Builders\BaseBuilder;
use App\Http\Filters\DateFilter;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Concerns\SortsQuery;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;

class CustomerReviewBuilder extends BaseBuilder
{
    public function builder(Model|Builder|string $model): SortsQuery|SpatieQueryBuilder
    {
        return SpatieQueryBuilder::for($this->getQuery($model))
            ->allowedFields($this->getFields())
            ->defaultSort('-id')
            ->allowedSorts($this->getSorts())
            ->allowedFilters($this->getFilters())
            ->allowedIncludes(['product'])
            ;
    }

    /**
     * @param array|null $columns
     * @return string[]
     */
    public function getFields(?array $columns = null): array
    {
        $fields = [
            'id',
            'company_name',
            'post',
            'author',
            'type',
            'video',
            'review_file',
            'is_in_home',
            'comment',
            'logo',
            'product_id',
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
            'company_name',
            'product_id',
            'post',
            'author',
            'comment',
            'id' => AllowedFilter::exact('id'),
            'is_in_home' => AllowedFilter::exact('is_in_home'),
            'type' => AllowedFilter::exact('type'),
            'created_at' => AllowedFilter::custom('created_at', new DateFilter(), 'created_at'),
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
            'company_name',
            'post',
            'author',
            'type',
            'is_in_home',
            'product_id',
        ];

        if (!is_null($this->relationDtoCollection)) {
            $sorts = [];
        }

        return $this->filter($sorts, $columns)->toArray();
    }
}
