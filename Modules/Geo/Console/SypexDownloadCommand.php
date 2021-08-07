<?php

namespace Modules\Geo\Console;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class SypexDownloadCommand extends Command
{
    protected $name = 'sypex:download';

    protected $description = 'Download sypex geo dataset';

    public function handle()
    {
        $url = 'https://sypexgeo.net/files/SxGeoCity_utf8.zip';

        $response = app(Client::class)->get($url);

        $fileZip = fopen(storage_path('app/SxGeoCity_utf8.zip'), 'wb');
        fwrite($fileZip, $response->getBody());
        fclose($fileZip);


        $zip = new \ZipArchive();
        $response = $zip->open(storage_path('app/SxGeoCity_utf8.zip'));
        if ($response === True) {
            $zip->extractTo(storage_path('app/'));
            $zip->close();
        }
    }
}
