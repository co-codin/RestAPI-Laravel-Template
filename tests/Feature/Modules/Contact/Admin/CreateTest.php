<?php


namespace Tests\Feature\Modules\Contact\Admin;

use Modules\Contact\Models\Contact;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_authenticated_can_create_contact()
    {
        $this->authenticateUser();

        $contactData = Contact::factory()->raw();

        $response = $this->json('POST', route('admin.contacts.store'), $contactData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "first_name",
                "last_name",
                "job_position",
                "image",
                "is_enabled",
                "created_at",
                "updated_at",
            ],
        ]);

        $this->assertDatabaseHas('contacts', [
            'last_name' => $contactData['last_name'],
            'is_enabled' => $contactData['is_enabled'],
        ]);
    }
}
