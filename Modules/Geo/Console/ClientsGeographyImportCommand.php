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
use Modules\Geo\Models\City;
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

    protected $soldProducts;

    public function __construct(
        protected GoogleApiService    $googleApiService,
        protected SoldProductImporter $soldProductImporter,
        protected CitiesImporter      $citiesImporter
    )
    {
        parent::__construct();
        $this->soldProducts = collect();
        $this->getGoogleServiceDrive();
        $this->getFileContent();
    }

    public function handle(): void
    {
        $this->transformCsv();

        dd(
            $this->soldProducts
        );

        SoldProduct::query()->truncate();

        foreach ($this->soldProducts as $soldProduct) {
            $cityName = $soldProduct['Город'];
            $city = City::query()
                ->where([
                    ['federal_district', '=', $soldProduct['Федеральный округ']],
                    ['name', 'like', "%{$cityName}%"],
                ])
                ->first();

            if (!$city) {
                City::query()->create([
                    'federal_district' => $soldProduct['Федеральный округ'],
                    'name' => $cityName,

                ]);
            }

            dump($city);
        }

//        $this->citiesImporter->import(array_column());
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


    private function getSoldProducts(): SupportCollection
    {
//        $dto = ClientsGeographyDto::create($this->soldProducts);
//
//        $city = $this->citiesImporter->import($dto);
//

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

            $this->soldProducts->add($row);
        }

        $this->soldProducts = $this->soldProducts
            ->filter(fn($soldProduct) => $this->validateSoldProduct($soldProduct))
            ->map(function ($soldProduct) {
                $soldProduct['Федеральный округ'] = $this->getDistrict($soldProduct['Федеральный округ']);
                return $soldProduct;
//                return collect($soldProduct)->only([
//                    'Наименование',
//                    'Федеральный округ',
//                    'Город',
//                    'id оборудования',
//                ])->all();
            })
            ->values();
    }

    private function validateSoldProduct($soldProduct)
    {
        $nameValidator = array_key_exists('Наименование', $soldProduct) && strlen($soldProduct['Наименование']) < 255;

        $districtValidator = array_key_exists('Федеральный округ', $soldProduct);

        $cityValidator = array_key_exists('Город', $soldProduct) && strlen($soldProduct['Город']) < 255;

        $productIdValidator = array_key_exists('id оборудования', $soldProduct) && Product::query()->where('id', $soldProduct['id оборудования'])->exists();

        return $nameValidator && $districtValidator && $cityValidator && $productIdValidator;
    }

    private function getDistrict($districtName)
    {
        $mapped = collect(District::getInstances())->mapWithKeys(function ($value, $key) {
            return [$value->description => $value->value];
        })->toArray();

        return array_key_exists($districtName, $mapped) ? $mapped[$districtName] : District::Central;
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
