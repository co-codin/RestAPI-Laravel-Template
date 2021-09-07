<?php

namespace App\Services;

use Google_Client;
use Google_Service_Drive;

class GoogleDriveService
{
    public function getDriveService(): Google_Service_Drive
    {
        $client = new Google_Client([
            'application_name' => 'Google Drive API PHP Quickstart',
            'scopes' => Google_Service_Drive::DRIVE,
            'access_type' => 'offline',
            'prompt' => 'select_account consent',
            'client_id' => config('services.google-api.client_id'),
            'client_secret' => config('services.google-api.client_secret'),
        ]);

        return new Google_Service_Drive(
            $client
        );
    }
}
