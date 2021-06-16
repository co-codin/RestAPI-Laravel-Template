<?php


namespace App\Http\Filters;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class DateFilter implements Filter
{
    public function __invoke(Builder $query, $date, string $property)
    {
        $dateFrom = \Arr::get($date, 'from');
        $dateTo = \Arr::get($date, 'to');

        if ($dateFrom === $dateTo && (!is_null($dateFrom) || !is_null($dateTo))) {
            $query->whereDate($property, '=', $dateFrom);
            return;
        }

        $i = 0;

        if (!is_null($dateFrom)) {
            $startDate = Carbon::parse($dateFrom)
                ->startOfDay()
                ->format('Y-m-d H:i:s');

            $i++;
        }

        if (!is_null($dateTo)) {
            $endDate = Carbon::parse($dateTo)
                ->endOfDay()
                ->format('Y-m-d H:i:s');

            $i++;
        }

        switch ($i) {
            case 1:
                if (!is_null($startDate)) {
                    $query->where($property, '>=', $startDate);
                } else {
                    $query->where($property, '<=', $endDate);
                }
                break;
            case 2:
                $query->whereBetween($property, [$startDate, $endDate]);
                break;
            default:
                throw new \Exception("'from' or 'to' parameters don't exist");
        }
    }
}
