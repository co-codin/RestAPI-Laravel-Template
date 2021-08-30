<?php


namespace Modules\Geo\Console;


use App\Services\GoogleApiService;
use Exception;
use Google_Client;
use Google_Service_Drive;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection as SupportCollection;
use LogicException;
use Modules\Customer\Enums\District;
use Modules\Geo\Dto\ClientsGeographyDto;
use Modules\Geo\Models\SoldProduct;
use Modules\Geo\Enums\ClientCsvKeys;
use Modules\Geo\Services\Importers\CitiesImporter;
use Modules\Geo\Services\Importers\SoldProductImporter;
use Modules\Product\Models\Product;

/**
 * Class ClientsGeographyImport
 * @package Modules\Client\Console\Imports
 */
class ClientsGeographyImportCommand extends Command
{
    protected $signature = 'import:clients-geography';

    protected $description = 'Import clients geography from csv file';

    protected Google_Service_Drive $serviceDrive;

    protected string $fileContent;

    protected array $soldProducts;

    public function __construct(
        protected GoogleApiService    $googleApiService,
        protected SoldProductImporter $soldProductImporter,
        protected CitiesImporter      $citiesImporter
    )
    {
        parent::__construct();
        $this->getGoogleServiceDrive();
        $this->getFileContent();
        $this->transformCsv();
    }

    public function handle(): void
    {
//        $soldProducts = $this->getSoldProducts();
//
//        if ($soldProducts->isEmpty()) {
//            throw new Exception('SoldProducts not found');
//        }
//
//        \DB::transaction(function () use ($soldProducts) {
//            SoldProduct::query()->delete();
//            $insert = SoldProduct::insert($soldProducts->toArray());
//
//            if (!$insert) {
//                throw new LogicException('Не удалось сохранить SoldProducts');
//            }
//        });
    }

    /**
     * @return SupportCollection
     * @throws Exception
     */
    private function getSoldProducts(): SupportCollection
    {
//        $dto = ClientsGeographyDto::create($data);
//
//        $city = $this->citiesImporter->import($dto);
//        $soldProducts->add($this->soldProductImporter->getSoldProduct($dto, $city));
//
//        fclose($stream);

//        return $soldProducts
//            ->groupBy('city_id')
//            ->map(function (SupportCollection $soldProducts) {
//                return $soldProducts->unique('title');
//            })
//            ->flatten(1);
    }

    private function getFileContent()
    {
        $response = $this->serviceDrive->files->export(
            config('services.google-api.drive.files.sold-products'),
            'text/csv',
            ['alt' => 'media']
        );

        $this->fileContent = $response->getBody()->getContents();
        $response->getBody()->close();
    }

    private function transformCsv()
    {
        $lines = explode("\n", $this->fileContent);
        $headers = str_getcsv(array_shift($lines));

        foreach ($lines as $line) {
            $row = array();

            foreach (str_getcsv($line) as $key => $field)
                $row[$headers[$key]] = $field;

            $row = array_filter($row);

            $this->soldProducts[] = $row;
        }

        $this->soldProducts = Arr::where($this->soldProducts, function ($value, $key) {
            return $this->validateSoldProduct($value) ? $value : null;
        });
        
        $this->soldProducts = Arr::only($this->soldProducts, [['Наименование']]);


//        foreach ($this->soldProducts as $soldProduct) {
//            dump($soldProduct);
//        }
        die();
    }

    private function validateSoldProduct(array $soldProduct)
    {
        $nameValidator = array_key_exists('Наименование', $soldProduct) && strlen($soldProduct['Наименование']) < 255;

        $districtValidator = array_key_exists('Федеральный округ', $soldProduct) && in_array($soldProduct['Федеральный округ'], Arr::pluck(District::getInstances(), 'description'));

        $cityValidator = array_key_exists('Город', $soldProduct)  && strlen($soldProduct['Город']) < 255;

        $productIdValidator = array_key_exists('id оборудования', $soldProduct) && Product::query()->where('id', $soldProduct['id оборудования'])->exists();

        return $nameValidator && $districtValidator && $cityValidator && $productIdValidator;
    }

    private function getGoogleServiceDrive()
    {
        $client = new Google_Client([
            'application_name' => 'Google Drive API PHP Quickstart',
            'scopes' => Google_Service_Drive::DRIVE,
            'access_type' => 'offline',
            'prompt' => 'select_account consent',
        ]);

        $client->setAuthConfig(storage_path('app/secret-data/google/credentials.json'));

        $this->serviceDrive = new Google_Service_Drive(
            $this->googleApiService->getAuthClient(
                $client,
                base_path('secret-data/google/token_drive.json')
            )
        );
    }
}
