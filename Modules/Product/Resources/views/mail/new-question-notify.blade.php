@php
    /**
     * @var ProductQuestion $productQuestion
     */

    use Modules\Product\Models\ProductQuestion;
@endphp

<div>
    Добавлен новый вопрос к товару - {{ $productQuestion->product->brand->name . ' ' . $productQuestion->product->name }}
</div>
