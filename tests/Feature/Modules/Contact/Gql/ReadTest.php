<?php


namespace Tests\Feature\Modules\Contact\Gql;

use Modules\Contact\Models\Contact;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_contacts_can_be_viewed()
    {
        $contact = Contact::factory()->create();

        $response = $this->graphQL('
            {
                contacts {
                    data {
                        id
                        first_name
                        last_name
                        job_position
                        email
                        image
                        position
                        is_enabled
                    }
                    paginatorInfo {
                        currentPage
                        lastPage
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'contacts' => [
                    'data' => [
                        [
                            'id' => $contact->id,
                            'first_name' => $contact->first_name,
                        ]
                    ],
                    'paginatorInfo' => [
                        'currentPage' => 1,
                        'lastPage' => 1,
                    ]
                ]
            ],
        ]);

        $response = $this->graphQL('
            {
                contacts(where: { column: ID, operator: EQ, value: ' . $contact->id .'  }) {
                    data {
                        id
                        first_name
                        last_name
                        job_position
                        email
                        image
                        position
                        is_enabled
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'contacts' => [
                    'data' => [
                        [
                            'id' => $contact->id,
                            'first_name' => $contact->first_name,
                        ]
                    ],
                ]
            ],
        ]);
    }
}
