<?php

namespace App\Http\Controllers;

class DownloadFileController extends \Illuminate\Routing\Controller
{
    public function download()
    {
        abort_unless(request()->has('file'), 404);

        try {
            $file = \Storage::disk('s3')->response(request()->input('file'), null, [
                'Content-Type' => 'application/pdf'
            ]);

            throw_if(!$file);

            return $file;
        }
        catch (\Throwable) {
            abort(404);
        }
    }
}
