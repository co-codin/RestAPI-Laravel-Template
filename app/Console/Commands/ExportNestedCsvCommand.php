<?php

namespace App\Console\Commands;

use App\Enums\Status;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Modules\Brand\Models\Brand;
use Modules\Category\Models\Category;
use Modules\Product\Models\Product;

class ExportNestedCsvCommand extends Command
{
    protected $signature = 'export:nested-csv';

    protected $description = 'export.';

    private string $siteDomain;
    private string $adminDomain;
    /**
     * @var \Illuminate\Database\Eloquent\Builder[]|Collection|Category[]
     */
    private Collection $categories;

    public function handle()
    {
        $this->siteDomain = 'https://v2.medeq.ru';
        $this->adminDomain = 'https://control.medeq.ru';

        $path = \Storage::path('/export/all.csv');
        $handle = fopen($path, "wb+");

        if ($handle === false) {
            throw new \Exception('!!!!!!!');
        }

        $content = [
            'ID',
            'категория',
            'подкатегория',
            'подподкатегория',
            'производитель',
            'товар',
            'ссылка на сайт',
            'ссылка на редактирование',
        ];

        fputcsv($handle, $content, ';');

        /** @var Category[]|Collection $categories */
        $this->categories = Category::query()
            ->with([
                'products' => function ($q) {
                    $q
                        ->wherePivot('is_main', 1)
                        ->where('status', Status::ACTIVE)
                        ->whereNull('deleted_at');
                },
                'products.brand' => function ($q) {
                    $q
                        ->select(['id', 'name', 'slug'])
                        ->where('status', Status::ACTIVE)
                        ->whereNull('deleted_at');
                }
            ])
            ->where('status', Status::ACTIVE)
            ->get();

        /** @var Category[]|SupportCollection $rootCategories */
        $rootCategories = $this->categories->whereNull('parent_id');

        $content = [
            'id' => '',
            'category_1' => '',
            'category_2' => '',
            'category_3' => '',
            'brand' => '',
            'product' => '',
            'site' => '',
            'admin' => ''
        ];

        foreach ($rootCategories as $rootCategory) {
            $content1 = $this->categoryContent($content, $handle, $rootCategory, 1);
            $categories2 = $this->getSubcategories($rootCategory->id);

            foreach ($categories2 as $category2) {
                $content2 = $this->categoryContent($content1, $handle, $category2, 2);

                foreach ($category2->products as $product) {
                    $this->brandContent($content2, $handle, $product->brand);
                    $this->productContent($content2, $handle, $product);
                }

                $categories3 = $this->getSubcategories($rootCategory->id);

                foreach ($categories3 as $category3) {
                    $content3 = $this->categoryContent($content2, $handle, $category3, 3);

                    foreach ($category3->products as $product) {
                        $this->brandContent($content3, $handle, $product->brand);
                        $this->productContent($content3, $handle, $product);
                    }
                }
            }
        }

        fclose($handle);
    }

    /**
     * @return SupportCollection|Category[]
     */
    private function getSubcategories(int $id): SupportCollection
    {
        return $this->categories->where('parent_id', $id);
    }

    private function categoryContent(array $content, $handle, Category $category, int $depth): array
    {
        $content['id'] = $category->id;
        $content["category_$depth"] = $category->name;
        $content['site'] = $this->getCategorySiteUrl($category->slug);
        $content['admin'] = $this->getCategoryAdminUrl($category->id);
        fputcsv($handle, $content, ';');

        return $content;
    }

    private function brandContent(array $content, $handle, Brand $brand): array
    {
        $content['id'] = $brand->id;
        $content['brand'] = $brand->name;
        $content['site'] = $this->getBrandSiteUrl($brand->slug);
        $content['admin'] = $this->getBrandAdminUrl($brand->id);
        fputcsv($handle, $content, ';');

        return $content;
    }

    private function productContent(array $content, $handle, Product $product): array
    {
        $content['id'] = $product->id;
        $content['product'] = $product->name;
        $content['site'] = $this->getProductSiteUrl($product->slug, $product->id);
        $content['admin'] = $this->getProductAdminUrl($product->id);
        fputcsv($handle, $content, ';');

        return $content;
    }

    private function getCategoryAdminUrl(int $id): string
    {
        return "$this->adminDomain/categories/$id/update";
    }

    private function getBrandAdminUrl(int $id): string
    {
        return "$this->adminDomain/brands/$id/update";
    }

    private function getProductAdminUrl(int $id): string
    {
        return "$this->adminDomain/products/$id/update";
    }

    private function getCategorySiteUrl(string $slug): string
    {
        return "$this->siteDomain/store/$slug";
    }

    private function getBrandSiteUrl(string $slug): string
    {
        return "$this->siteDomain/brands/$slug";
    }

    private function getProductSiteUrl(string $slug, int $id): string
    {
        return "$this->siteDomain/product/$slug/$id";
    }
}
