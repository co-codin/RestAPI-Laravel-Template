<?php

namespace Modules\Review\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Response;
use Modules\Review\Http\Requests\ProductReviewUpdateRequest;
use Modules\Review\Models\ProductReview;

class ProductReviewController extends Controller
{
    public function update(ProductReviewUpdateRequest $request, ProductReview $productReview): Renderable
    {
        //
    }

    public function destroy(ProductReview $productReview): Response
    {
        $productReview->delete();

        return \response()->noContent();
    }
}
