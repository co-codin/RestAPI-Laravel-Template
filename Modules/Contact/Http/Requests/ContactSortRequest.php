<?php

namespace Modules\Contact\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class ContactSortRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'contacts' => 'required|array',
            'contacts.*.id' => 'required|distinct|exists:contacts,id',
            'contacts.*.position' => 'required|distinct|integer|min:0',
        ];
    }
}
