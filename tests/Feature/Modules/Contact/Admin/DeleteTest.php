<?php


namespace Tests\Feature\Modules\Contact\Admin;

use Modules\Contact\Models\Contact;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_authenticated_can_delete_contact()
    {
        $this->authenticateUser();

        $contact = Contact::factory()->create();

        $response = $this->deleteJson(route('admin.contacts.destroy', $contact));

        $response->assertNoContent();

        $this->assertDeleted($contact);
    }
}
