<?php

namespace App\Console\Commands\Migration;

use App\Console\Commands\Migration\Exceptions\BrandMigrateException;
use App\Models\FieldValue;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Brand\Models\Brand;
use Modules\Seo\Models\SeoRule;

class MigrateSeoRule extends Command
{
    protected $signature = 'migrate:seo-rule';

    protected $description = 'Migrate seo rules';

    public function handle()
    {
        Model::unguard();

        $oldSeoRules = DB::connection('old_medeq_mysql')
            ->table('seo_rules')
            ->get();

        foreach ($oldSeoRules as $oldSeoRule) {
            try {
                $data = $this->transform($oldSeoRule);
            } catch (BrandMigrateException $e) {
                continue;
            }

            SeoRule::query()->insert($data);
        }
    }

    /**
     * @throws \Exception
     */
    protected function transform(object $item): array
    {
        return [
            'id' => $item->id,
            'name' => $item->title,
            'url' => $this->getNewUrl($item->url),
            'assigned_by_id' => 1,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }

    /**
     * @throws \Exception
     */
    private function getNewUrl(string $url): string
    {
        $newUrl = [];
        $exploded = explode('/', $url);

        foreach ($exploded as $str) {
            if (str_contains($str, 'brand-')) {
                $newUrl[] = $this->getBrandFilter($str);
            } else {
                $newUrl[] = $this->getByFieldValueFilter($str);
            }
        }

        return implode('/', $newUrl);
    }

    /**
     * @throws \Exception
     */
    private function getBrandFilter(string $str): string
    {
        preg_match('~brand-(.+)~', $str, $matches);
        $brandSlug = $matches[1];

        $brandId = Brand::query()
                ->where('slug', $brandSlug)
                ->first()
                ?->id ?? throw new BrandMigrateException("Brand with slug - \"$brandSlug\" not found");

        return "brand-$brandId";
    }

    private function getByFieldValueFilter(string $str): string
    {
        preg_match('~-(.+)~', $str, $matches);

        if (empty($matches)) {
            return $str;
        }
        $slug = $matches[1];

        $fieldValueId = FieldValue::query()
            ->where('slug', $slug)
            ->first()
            ?->id;

        if (is_null($fieldValueId)) {
            $bookItemTitle = DB::connection('old_medeq_mysql')
                    ->table('book_items')
                    ->where('slug', $slug)
                    ->first()
                    ?->title;

            if (is_null($bookItemTitle)) {
                return $str;
            }

            $fieldValueId = FieldValue::query()
                    ->where('value', $bookItemTitle)
                    ->first()
                    ?->id;

            if (is_null($fieldValueId)) {
                return $str;
            }
        }

        preg_match('~^(?>[^-]*)~', $str, $matches);

        return "$matches[0]-$fieldValueId";
    }
}
