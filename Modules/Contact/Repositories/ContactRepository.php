<?php

namespace Modules\Contact\Repositories;

use App\Repositories\BaseRepository;
use Modules\Contact\Models\Contact;
use Modules\Contact\Repositories\Criteria\ContactRequestCriteria;

class ContactRepository extends BaseRepository
{
    public function model()
    {
        return Contact::class;
    }

    public function boot()
    {
        $this->pushCriteria(ContactRequestCriteria::class);
    }
}
