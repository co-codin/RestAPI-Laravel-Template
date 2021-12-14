@php
/**
 * @var ProductQuestion $productQuestion
 * @var string $comment
 * @var string $approvedText
 */

use Modules\Product\Models\ProductQuestion;

@endphp

<div>
    Ваш вопрос, оставленный к товару
    <a href='{{ $productQuestion->product->getSiteUrlAttribute() }}'>{{ $productQuestion->product->name }}</a>
    {{ $approvedText }}.
</div>
<br>
<div>Комментарий: {{ $comment }}</div>
