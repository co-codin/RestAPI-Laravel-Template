<?php


namespace Tests\Feature\Modules\Contact\Admin;

use Modules\Contact\Models\Contact;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_authenticated_can_update_contact()
    {
        $this->authenticateUser();

        $contact = Contact::factory()->create([
            'is_enabled' => true,
        ]);

        $response = $this->json('PATCH', route('admin.contacts.update', $contact), [
            'last_name' => $newName = 'new name',
            'is_enabled' => false
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('contacts', [
            'last_name' => $newName,
            'is_enabled' => false
        ]);
    }
}
