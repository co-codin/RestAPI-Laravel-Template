<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\File\FileUploader;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;

class UploadController extends Controller
{
    protected array $dimensionRules = [
        "maxWidth",
        "maxHeight",
        "minWidth",
        "minHeight",
        "ratio",
    ];

    public function __invoke(FileUploader $uploader): string
    {
        Validator::make(request()->all(), $this->getRules())->validate();

        try {
            return $uploader->upload(request()->file('file'));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    protected function getRules(): array
    {
        $rules = [
            'required',
        ];

        $requestRules = request()->input('rules', '{}');

        $requestRules = json_decode($requestRules, true);

        if ($type = Arr::get($requestRules, 'type')) {
            $rules[] = $type;
            if($type == "image") {
                $rules[] = 'mimes:jpg,png';
            }
        }

        if ($dimensions = Arr::get($requestRules, 'dimensions')) {
            $dimensionsRule = Rule::dimensions();
            foreach ($this->dimensionRules as $rule) {
                if ($ruleParam = Arr::get($dimensions, $rule)) {
                    $dimensionsRule->{$rule}($ruleParam);
                }
            }
            $rules[] = $dimensionsRule;
        }

        return [
            'file' => $rules,
        ];
    }
}
