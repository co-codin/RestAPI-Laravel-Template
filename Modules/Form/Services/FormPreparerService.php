<?php


namespace Modules\Form\Services;


use App\Helpers\CookieHelper;
use Illuminate\Support\Facades\Cookie;
use Modules\Form\Forms\Form;
use Modules\Form\Http\Requests\FormsRequest;

class FormPreparerService
{
    /**
     * @param FormsRequest $request
     * @return Form
     * @throws \Throwable
     */
    public function getPreparedForm(FormsRequest $request): Form
    {
        $form = $request->getForm();
        $validated = $request->validated();

        $data = array_merge(
            $validated,
            $request->getClientData(),
            $this->getAttachments($validated),
        );

        return $form
            ->setAttributes($data)
            ->setUtm($this->getUtm())
            ->setPage(url()->previous())
            ->setRoistatVisit($request->header('roistat'));
    }

    /**
     * @return mixed
     * @throws \JsonException
     */
    private function getUtm(): mixed
    {
        return Cookie::has('utm')
            ? CookieHelper::getDecodedJsonCookie(Cookie::get('utm'))
            : null;
    }

    /**
     * @param array $validated
     * @return string[]|null[]
     * @throws \Exception
     */
    private function getAttachments(array $validated): array
    {
        $attachments = [];

        if (!empty($allFiles = request()->allFiles())) {
            $validatedFiles = $this->getValidatedFiles($allFiles, $validated);

            $attachmentService = app(AttachmentService::class);
            $paths = $attachmentService->save($validatedFiles);

            $attachments = ['attachments' => $paths ?? null];
        }

        return $attachments;
    }

    /**
     * @param array $allFiles
     * @param array $validated
     * @return array
     */
    private function getValidatedFiles(array $allFiles, array $validated): array
    {
        $validatedFiles = array_intersect_key(
            $validated,
            $allFiles
        );

        if (count($allFiles) !== count($validatedFiles)) {
            abort(422, 'Недопустимый файл');
        }

        return $validatedFiles;
    }
}
