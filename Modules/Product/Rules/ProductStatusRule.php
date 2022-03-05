<?php

namespace Modules\Product\Rules;

use App\Enums\Status;
use Illuminate\Contracts\Validation\Rule;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductCategory;

class ProductStatusRule implements Rule
{
    public function passes($attribute, $value)
    {
        if (in_array($value, [Status::ACTIVE, Status::ONLY_URL])) {
            $product = Product::query()->where('id', '=', $this->route('product'))->first();
            $productCategory = ProductCategory::query()->where('product_id', '=', $this->route('product'))->exists();
            return $productCategory &&
                $product->brand_id &&
                $product->name &&
                $product->slug &&
                $product->group_id &&
                $product->short_description &&
                $product->full_description &&
                $product->image &&
                ($product->warranty_info || $product->arbitrary_warranty_info)
            ;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Вы не можете включить отображение товара, так как не заполнены обязательные поля";
    }
}
