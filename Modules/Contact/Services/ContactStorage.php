<?php

namespace Modules\Contact\Services;

use Modules\Contact\Dto\ContactDto;
use Modules\Contact\Models\Contact;

class ContactStorage
{
    public function store(ContactDto $contactDto)
    {
        return Contact::query()->create($contactDto->toArray());
    }

    public function update(Contact $contact, ContactDto $contactDto)
    {
        $attributes = $contactDto->toArray();

        if (!$contact->update($attributes)) {
            throw new \LogicException('can not update contact');
        }

        return $contact;
    }

    public function destroy(Contact $contact)
    {
        if (!$contact->delete()) {
            throw new \LogicException('can not delete contact');
        }
    }

    public function sort(array $contacts)
    {
        foreach ($contacts as $contact) {
            Contact::query()
                ->where('id', $contact['id'])
                ->update(['position' => $contact['position']]);
        }
    }
}
