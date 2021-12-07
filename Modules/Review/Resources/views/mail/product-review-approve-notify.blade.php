@php
/**
 * @var ProductReview $productReview
 * @var string $comment
 * @var string $approvedText
 */

use Modules\Review\Models\ProductReview;

@endphp

<div>
    Ваш отзыв, оставленный к товару
    <a href='{{ $productReview->product->getSiteUrlAttribute() }}'>{{ $productReview->product->name }}</a>
    {{ $approvedText }}.
</div>
<br>
<div>Комментарий: {{ $comment }}</div>
