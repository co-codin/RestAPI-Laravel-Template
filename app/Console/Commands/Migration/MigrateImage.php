<?php

namespace App\Console\Commands\Migration;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\Product;

class MigrateImage extends Command
{
    protected $signature = 'migrate:image';

    protected $description = 'Migrate images';

    protected $imageAbleLookupTable = [
        "Modules\Product\Entities\Product" => Product::class,
    ];

    public function handle()
    {
        Model::unguard();

        $images = DB::connection('old_medeq_mysql')
            ->table('images')
            ->get();

        foreach ($images as $image) {
            Image::query()->insert(
                $this->transform($image)
            );
        }
    }

    protected function transform($item)
    {
        return [
            'imageable_type' => $this->imageAbleLookupTable[$item->imageable_type],
            'imageable_id' => $item->imageable_id,
            'image' => ltrim($item->image, '/'),
            'position' => $item->position,
            'caption' => $item->caption,
        ];
    }
}
