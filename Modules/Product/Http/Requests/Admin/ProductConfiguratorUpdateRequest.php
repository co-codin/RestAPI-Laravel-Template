<?php


namespace Modules\Product\Http\Requests\Admin;


use App\Http\RequestFilters\SanitizesInput;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;
use Modules\Product\Enums\Availability;
use Modules\Product\Enums\SupplierEnum;
use Modules\Product\Rules\ConfiguratorIsEnabledRule;

class ProductConfiguratorUpdateRequest extends BaseFormRequest
{
    use SanitizesInput;

    public function filters(): array
    {
        return [
            'variations.*.is_update_from_links' => 'nullable-cast:boolean',
            'variations.*.links.*.id' => 'nullable-cast:integer',
            'variations.*.links.*.supplier' => 'nullable-cast:integer',
            'variations.*.links.*.is_default' => 'nullable-cast:boolean',
            'variations.*.links.*.currency_id' => 'nullable-cast:integer',
            'variations.*.links.*.price' => 'nullable-cast:integer',
            'variations.*.links.*.availability' => 'nullable-cast:integer',
        ];
    }

    public function rules(): array
    {
        $rules = [
            'variations' => [
                'required',
                'array',
                new ConfiguratorIsEnabledRule,
            ],
            'variations.*.id' => 'distinct|integer|exists:product_variations,id',
            'variations.*.name' => 'required|string|max:255',
            'variations.*.price' => 'required_if:variations.*.is_price_visible,true|nullable|numeric|gt:0',
            'variations.*.previous_price' => 'nullable|numeric|gt:0',
            'variations.*.currency_id' => 'required|integer|exists:currencies,id',
            'variations.*.condition_id' => 'required|integer|exists:field_values,id',
            'variations.*.is_price_visible' => 'boolean',
            'variations.*.is_enabled' => [
                'boolean',
            ],
            'variations.*.availability' => [
                'required',
                'integer',
                new EnumValue(Availability::class, false),
            ],
            'variations.*.stock_type' => 'sometimes|nullable|string|max:255',

            // TODO incoming tasks
//            'options' => 'required|array',
//            'attributes' => 'required|array',

            'variations.*.is_update_from_links' => 'sometimes|nullable|boolean'
        ];

        return array_merge(
            $rules,
            $this->getVariationLinkRules('variations.*.')
        );
    }

    protected function getVariationLinkRules(string $prefix = ''): array
    {
        $rules = [
            'links' => 'required|array',
            'links.*' => 'required|array',
            'links.*.id' => 'sometimes|nullable|int|distinct|exists:variation_links,id',
            'links.*.supplier' => 'required|int|enum_value:' . SupplierEnum::class,
            'links.*.resource' => 'required|string|max:255',
            'links.*.is_default' => 'required|boolean',
            'links.*.check' => 'sometimes|nullable|array',
            'links.*.check.*' => 'required|array',
            'links.*.check.*.element' => 'required|string',
            'links.*.check.*.value' => 'required|string|max:255',
            'links.*.currency_id' => 'required|int|exists:currencies,id',
            'links.*.price' => 'required|int|min:1',
            'links.*.availability' => 'required|int|enum_value:' . Availability::class,
            'links.*.info_updated_at' => 'required|date',
        ];

        return $this->prefix($rules, $prefix)->toArray();
    }
}
