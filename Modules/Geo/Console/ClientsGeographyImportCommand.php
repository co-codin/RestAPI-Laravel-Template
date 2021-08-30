<?php


namespace Modules\Geo\Console;


use App\Services\GoogleApiService;
use Google_Client;
use Google_Service_Drive;
use Illuminate\Console\Command;
use Modules\Customer\Enums\District;
use Modules\Geo\Models\City;
use Modules\Geo\Models\SoldProduct;
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

        SoldProduct::query()->truncate();

        foreach ($this->soldProducts as $soldProduct) {
            $cityName = $soldProduct['Город'];
            $city = City::query()
                ->where([
                    ['name', 'like', "%{$cityName}%"],
                ])
                ->first();

            if (!$city) {
                $city = City::query()->create([
                    'name' => $cityName,
                ]);
            }

            SoldProduct::query()->create([
                'title' => $soldProduct['Наименование'],
                'city_id' => $city->id,
                'product_id' => $soldProduct['id оборудования'],
            ]);
        }

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
