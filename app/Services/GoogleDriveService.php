<?php

namespace App\Services;

use Google_Client;
use Google_Service_Drive;

class GoogleDriveService
{
    public function __construct(
        protected GoogleApiService $googleApiService,
    ) {}

    public function getDriveService(): Google_Service_Drive
    {
        $client = new Google_Client([
            'application_name' => 'Google Drive API PHP Quickstart',
            'scopes' => Google_Service_Drive::DRIVE,
            'access_type' => 'offline',
            'prompt' => 'select_account consent',
        ]);

        $client->setAuthConfig(storage_path('app/google/credentials/credentials.json'));

        return new Google_Service_Drive(
            $this->googleApiService->getAuthClient(
                $client,
                storage_path('app/google/credentials/token_drive.json')
            )
        );
    }
}
