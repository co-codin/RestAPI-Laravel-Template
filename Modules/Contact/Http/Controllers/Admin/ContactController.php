<?php

namespace Modules\Contact\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Contact\Dto\ContactDto;
use Modules\Contact\Http\Requests\ContactCreateRequest;
use Modules\Contact\Http\Requests\ContactSortRequest;
use Modules\Contact\Http\Requests\ContactUpdateRequest;
use Modules\Contact\Http\Resources\ContactResource;
use Modules\Contact\Models\Contact;
use Modules\Contact\Services\ContactStorage;

class ContactController extends Controller
{
    public function __construct(
        protected ContactStorage $contactStorage,
    ) {
        $this->authorizeResource(Contact::class, 'contact');
    }

    public function store(ContactCreateRequest $request)
    {
        $contact = $this->contactStorage->store(ContactDto::fromFormRequest($request));

        return new ContactResource($contact);
    }

    public function update(Contact $contact, ContactUpdateRequest $request)
    {
        $contact = $this->contactStorage->update($contact, ContactDto::fromFormRequest($request));

        return new ContactResource($contact);
    }

    public function destroy(Contact $contact)
    {
        $this->contactStorage->destroy($contact);

        return response()->noContent();
    }

    public function sort(ContactSortRequest $request)
    {
        $this->authorize('sort', Contact::class);

        $this->contactStorage->sort($request->input('contacts'));

        return response()->noContent();
    }
}
