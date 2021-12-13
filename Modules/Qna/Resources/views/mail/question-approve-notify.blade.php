@php
/**
 * @var Question $question
 * @var string $comment
 * @var string $approvedText
 */

use Modules\Qna\Models\Question;

@endphp

<div>
    Ваш вопрос, оставленный к товару
    <a href='{{ $question->product->getSiteUrlAttribute() }}'>{{ $question->product->name }}</a>
    {{ $approvedText }}.
</div>
<br>
<div>Комментарий: {{ $comment }}</div>
