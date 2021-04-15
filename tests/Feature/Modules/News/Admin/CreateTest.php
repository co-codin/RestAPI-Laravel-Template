<?php


namespace Tests\Feature\Modules\News\Admin;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\News\Models\News;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_unauthenticated_cannot_create_news()
    {
        //
    }

    public function test_authenticated_can_create_news()
    {
        Storage::fake('public');

        $newsData = News::factory()->raw([
            'image' => UploadedFile::fake()->image('test-file.jpg'),
        ]);

        $response = $this->json('POST', route('admin.news.store'), $newsData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'slug',
            ]
        ]);
        $this->assertDatabaseHas('news', [
            'name' => $newsData['name'],
        ]);
    }
}
