<?php


namespace App\Vendor\NestedSet;


use Illuminate\Database\Query\Builder;

class AncestorsRelation extends \Kalnoy\Nestedset\AncestorsRelation
{
    public function addEagerConstraints(array $models)
    {
        optional(reset($models))->applyNestedSetScope($this->query);

        $this->query->whereNested(function (Builder $inner) use ($models) {
            $outer = $this->parent->newQuery()->setQuery($inner);
            foreach ($models as $model) {
                $this->addEagerConstraint($outer, $model);
            }
        });
    }
}
