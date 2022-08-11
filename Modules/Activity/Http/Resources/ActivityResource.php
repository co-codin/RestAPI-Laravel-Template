<?php

namespace Modules\Activity\Http\Resources;

use App\Http\Resources\BaseJsonResource;
use Illuminate\Support\Str;
use Modules\Activity\Enums\ActivityAction;
use Modules\Activity\Enums\SubjectType;
use Modules\Activity\Models\Activity;
use Modules\User\Http\Resources\UserResource;

/**
 * Class ActivityResource
 * @package Modules\Activity\Http\Resources
 * @mixin Activity
 */
class ActivityResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'subject_type' => $this->whenRequested('subject_type', function() {
                $subjectType = explode('\\', $this->subject_type);
                $subjectType = array_pop($subjectType);
                return SubjectType::getDescription($subjectType);
            }),
            'event' => $this->whenRequested('event', function() {
                return ActivityAction::getDescription($this->event);
            }),
            'causer_type' => $this->whenRequested('causer_type', function() {
                $causerType = explode('\\', $this->causer_type);
                return \Str::lower(array_pop($causerType));
            }),
            'subject' => $this->whenLoaded('subject', function() {
                return method_exists($this->subject, 'subject')
                    ? $this->subject->subject()
                    : $this->subject->toArray();
            }),
            'parent_subject' => $this->whenLoaded('parentSubject', function() {
                return method_exists($this->parentSubject, 'subject')
                    ? $this->parentSubject->subject()
                    : $this->parentSubject->toArray();
            }),
            'causer' => $this->whenLoaded('causer', function() {
                return [
                    'id' => $this->causer->id,
                    'name' => $this->causer->name,
                    'email' => $this->causer->email,
                ];
            }),
        ]);
    }
}
