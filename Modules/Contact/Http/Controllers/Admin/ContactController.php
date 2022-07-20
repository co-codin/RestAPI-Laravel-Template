<?php

namespace Modules\Contact\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Contact\Dto\ContactDto;
use Modules\Contact\Http\Requests\ContactCreateRequest;
use Modules\Contact\Http\Requests\ContactSortRequest;
use Modules\Contact\Http\Requests\ContactUpdateRequest;
use Modules\Contact\Http\Resources\ContactResource;
use Modules\Contact\Models\Contact;
use Modules\Contact\Repositories\ContactRepository;
use Modules\Contact\Services\ContactStorage;

class ContactController extends Controller
{
    public function __construct(
        protected ContactStorage $contactStorage,
        protected ContactRepository $contactRepository
    ) {}

    public function store(ContactCreateRequest $request)
    {
        $this->authorize('create', Contact::class);

        $contact = $this->contactStorage->store(ContactDto::fromFormRequest($request));

        return new ContactResource($contact);
    }

    public function update(int $contact, ContactUpdateRequest $request)
    {
        $contact = $this->contactRepository->find($contact);

        $this->authorize('update', $contact);

        $contact = $this->contactStorage->update($contact, ContactDto::fromFormRequest($request));

        return new ContactResource($contact);
    }

    public function destroy(int $contact)
    {
        $contact = $this->contactRepository->find($contact);

        $this->authorize('delete', $contact);

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
