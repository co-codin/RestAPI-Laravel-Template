<?php

namespace Modules\Review\Http\PostValidators;

use App\Http\PostValidators\BasePostValidator;

class ProductReviewRatingsPostValidator extends BasePostValidator
{
    /**
     * @throws \JsonException
     */
    protected function check(): void
    {
        $request = $this->getRequest();

        if (!is_int($productId = $request->input('product_id'))) {
            $this->addError('product_id', 'Не верный идентификатор товара');
        }

        $category = \DB::table('product_category as pc')
            ->select('cat.review_ratings')
            ->join('categories as cat', 'cat.id', '=', 'pc.category_id')
            ->where('pc.is_main', true)
            ->where('pc.product_id', $productId)
            ->first();

        if (is_null($category)) {
            $this->addError('product_id', 'У товара нету основной категории');
        }

        $reviewRatings = json_decode($category?->review_ratings, true, 512, JSON_THROW_ON_ERROR);
        $allowedReviewRatings = collect($reviewRatings)->pluck('name');

        $ratings = collect($request->input('ratings.*.name'));
        dd($request->input('ratings'));

        $reviewRatingAttributes = [];

        foreach ($ratings as $key => $name) {
            $reviewRatingAttributes["ratings.$key.name"] = $name;
            $reviewRatingAttributes["ratings.$key.rate"] = "Рейтинг у оценки $name";
        }

        $v = \Validator::make(
            ['ratings' => $request->input('ratings')],
            [
//            'ratings.*' => 'required|array|min:4',
                'ratings' => 'required|array',
                'ratings.*' => 'required|array|min:1',
                'ratings.*.name' => 'required|string|distinct|max:255',
                'ratings.*.rate' => 'required|int|min:1',
            ],
            [],
            $reviewRatingAttributes + ['ratings' => 'Оценки',]
        );

        if ($v->errors()->isNotEmpty()) {
            $fieldsMessages = $v->errors()->messages();

            foreach ($fieldsMessages as $fieldPath => $fieldMessages) {
                foreach ($fieldMessages as $message) {
                    $this->addError($fieldPath, $message);
                }
            }
        }

        if ($allowedReviewRatings->isEmpty()) {
            $this->addError('product_id', 'У категории товара нету разрешенных оценок для отзывов');
        }

        $rejectedRatings = $ratings->diff($allowedReviewRatings);

        if ($rejectedRatings->isNotEmpty()) {
            foreach ($rejectedRatings as $key => $rating) {
                $this->addError("ratings.$key", "Оценка $rating не может быть добавлена к данному товару");
            }
        }

        $requiredRatings = $allowedReviewRatings->diff($ratings);

        if ($requiredRatings->isNotEmpty()) {
            foreach ($requiredRatings as $rating) {
                $this->addError("ratings", "Оценка $rating должна быть добавлена к данному товару");
            }
        }
    }
}
