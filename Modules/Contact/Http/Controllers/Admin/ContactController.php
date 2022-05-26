<?php

namespace Modules\Contact\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Contact\Dto\ContactDto;
use Modules\Contact\Http\Requests\ContactCreateRequest;
use Modules\Contact\Http\Requests\ContactUpdateRequest;
use Modules\Contact\Http\Resources\ContactResource;
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
        $contactDto = ContactDto::fromFormRequest($request);

        $contact = $this->contactStorage->store($contactDto);

        return new ContactResource($contact);
    }

    public function update(int $contact, ContactUpdateRequest $request)
    {
        $contactModel = $this->contactRepository->find($contact);

        $contactModel = $this->contactStorage->update($contactModel, ContactDto::fromFormRequest($request));

        return new ContactResource($contactModel);
    }

    public function destroy(int $contact)
    {
        $contactModel = $this->contactRepository->find($contact);

        $this->contactStorage->delete($contactModel);

        return response()->noContent();
    }
}
