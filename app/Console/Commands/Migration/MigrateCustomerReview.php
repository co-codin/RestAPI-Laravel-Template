<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Customer\Models\CustomerReview;

class MigrateCustomerReview extends Command
{
    protected $signature = 'migrate:customer-review';
    protected $description = 'Migrate customer reviews';

    public function handle()
    {
        Model::unguard();

        $oldCustomerReviews = DB::connection('old_medeq_mysql')
            ->table('client_reviews')
            ->get();

        $customerReviews = $oldCustomerReviews->map(
            fn (object $item): array => $this->transform($item)
        );

        CustomerReview::query()->insert($customerReviews->toArray());
    }

    private function transform(object $item): array
    {
        return [
            'id' => $item->id,
            'post' => $item->name,
            'author' => $item->author,
            'type' => $item->type,
            'video' => $item->video,
            'review_file' => ltrim($item->review_file, "/"),
            'is_home' => $item->in_home === 1,
            'comment' => $item->comment,
            'logo' => $item->image,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }
}
