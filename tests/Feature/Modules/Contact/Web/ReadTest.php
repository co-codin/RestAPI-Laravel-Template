<?php


namespace Tests\Feature\Modules\Contact\Web;

use Modules\Contact\Models\Contact;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_contacts()
    {
        Contact::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('contacts.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "first_name",
                    "last_name",
                    "job_position",
                    "image",
                    "position",
                    "is_enabled",
                    "created_at",
                    "updated_at",
                ]
            ],
            'links' => [
                "first",
                "last",
                "prev",
                "next",
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links' => [
                    [
                        'url',
                        'label',
                        'active',
                    ]
                ],
                'path',
                'per_page',
                'to',
                'total',
            ]
        ]);
    }

    public function test_user_can_view_single_contact()
    {
        $contact = Contact::factory()->create();

        $response = $this->json('GET', route('contacts.show', $contact));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "first_name",
                "last_name",
                "job_position",
                "image",
                "position",
                "is_enabled",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}
