<?php


namespace Tests\Feature\Modules\News\Admin;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\News\Models\News;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_authenticated_can_create_news()
    {
        $this->authenticateUser();

        $newsData = News::factory()->raw();

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
