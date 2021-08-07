<?php


namespace Modules\Geo\Console;


use App\Api\Google\GoogleApi;
use Exception;
use Google_Client;
use Google_Service_Drive;
use Illuminate\Console\Command;
use Illuminate\Support\Collection as SupportCollection;
use LogicException;
use Modules\Client\Dto\ClientsGeographyDto;
use Modules\Client\Entities\SoldProduct;
use Modules\Client\Enums\ClientCsvKeys;
use Modules\Client\Services\Importers\CitiesImporter;
use Modules\Client\Services\Importers\SoldProductImporter;

/**
 * Class ClientsGeographyImport
 * @package Modules\Client\Console\Imports
 */
class ClientsGeographyImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:clients-geography';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import clients geography from csv file';

    private GoogleApi $googleApi;
    private SoldProductImporter $soldProductImporter;
    private CitiesImporter $citiesImporter;

    /**
     * ClientsGeographyImport constructor.
     * @param GoogleApi $googleApi
     * @param SoldProductImporter $soldProductImporter
     * @param CitiesImporter $citiesImporter
     */
    public function __construct(
        GoogleApi $googleApi,
        SoldProductImporter $soldProductImporter,
        CitiesImporter $citiesImporter
    )
    {
        parent::__construct();

        $this->googleApi = $googleApi;
        $this->soldProductImporter = $soldProductImporter;
        $this->citiesImporter = $citiesImporter;
    }

    /**
     * Execute the console command.
     *
     * @throws \Throwable
     */
    public function handle(): void
    {
        $serviceDrive = $this->getGoogleServiceDrive();

        $fileContent = $this->getFileContent($serviceDrive);

        $soldProducts = $this->getSoldProducts($fileContent);

        if ($soldProducts->isEmpty()) {
            throw new Exception('SoldProducts not found');
        }

        \DB::transaction(function () use ($soldProducts) {
            SoldProduct::query()->delete();
            $insert = SoldProduct::insert($soldProducts->toArray());

            if (!$insert) {
                throw new LogicException('Не удалось сохранить SoldProducts');
            }
        });
    }

    /**
     * @param string $fileContent
     * @return SupportCollection
     * @throws Exception
     */
    private function getSoldProducts(string $fileContent): SupportCollection
    {
        $stream = fopen('php://temp','r+');

        if (fwrite($stream, $fileContent) === false) {
            fclose($stream);
            throw new LogicException('Failed to write file content (soldProducts) to stream');
        }

        rewind($stream);

        $soldProducts = collect([]);
        $line = 0;

        while (($data = fgetcsv($stream, 1000, ",")) !== false) {
            if (!$line) {
                $line++;
                continue;
            }

            try {
                ClientCsvKeys::checkRequiredFields($data);
                ClientCsvKeys::checkProduct($data);
            } catch (Exception $e) {
                continue;
            }

            $dto = ClientsGeographyDto::create($data);

            $city = $this->citiesImporter->import($dto);
            $soldProducts->add($this->soldProductImporter->getSoldProduct($dto, $city));
        }

        fclose($stream);

        return $soldProducts
            ->groupBy('city_id')
            ->map(function (SupportCollection $soldProducts) {
                return $soldProducts->unique('title');
            })
            ->flatten(1);
    }

    /**
     * @param Google_Service_Drive $serviceDrive
     * @return string
     */
    private function getFileContent(Google_Service_Drive $serviceDrive): string
    {
        /** @var \GuzzleHttp\Psr7\Response $response */
        $response = $serviceDrive->files->export(
            config('services.google-api.drive.files.sold-products'),
            'text/csv',
            ['alt' => 'media']
        );

        $string = $response->getBody()->getContents();
        $response->getBody()->close();

        return $string;
    }

    /**
     * @return Google_Service_Drive
     * @throws \Google_Exception
     */
    private function getGoogleServiceDrive(): Google_Service_Drive
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Drive API PHP Quickstart');
        $client->setScopes(Google_Service_Drive::DRIVE);
        $client->setAuthConfig(base_path('secret-data/google/credentials.json'));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        $authClient = $this->googleApi->getAuthClient(
            $client,
            base_path('secret-data/google/token_drive.json')
        );

        return new Google_Service_Drive($authClient);
    }

    /**
     * @param Google_Service_Drive $serviceDrive
     * @param int $pageSize
     */
    private function showListFiles(Google_Service_Drive $serviceDrive, int $pageSize = 10): void
    {
        $optParams = array(
            'pageSize' => $pageSize,
            'fields' => 'nextPageToken, files(id, name)'
        );

        $results = $serviceDrive->files->listFiles($optParams);

        if (count($results->getFiles()) == 0) {
            print "No files found.\n";
        } else {
            print "Files:\n";
            foreach ($results->getFiles() as $file) {
                printf("%s (%s)\n", $file->getName(), $file->getId());
            }
        }
    }
}
