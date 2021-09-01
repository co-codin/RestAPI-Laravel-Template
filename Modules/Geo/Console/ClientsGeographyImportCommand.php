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
    // TODO давай переименуем команду - нельзя в начале команды писать действие. нужно сначала сущность, пример: sold-products:import
    protected $signature = 'import:clients-geography';

    // TODO нужно обновить signature
    protected $description = 'Import clients geography from csv file';

    protected Google_Service_Drive $serviceDrive;

    protected string $fileContent;

    protected $soldProducts;

    public function __construct(
        protected GoogleApiService    $googleApiService,
    )
    {
        parent::__construct();
        // TODO не в первый раз я уже это пишу - нельзя в constructor логику писать, так как он будет постоянно запускаться при выполнении любой консольной команде
        $this->soldProducts = collect();
        $this->getGoogleServiceDrive();
        $this->getFileContent();
    }

    public function handle(): void
    {
        $this->transformCsv();

        // TODO это плохо, так как после каждого запуска будет auto increment у id и совсем скоро наберется куча всего
        SoldProduct::query()->truncate();

        foreach ($this->soldProducts as $soldProduct) {
            // TODO cyrillic в array key - плохой тон
            $cityName = $soldProduct['Город'];
            $city = City::query()
                ->where([
                    // TODO почему здесь like? нужно exact search
                    ['name', 'like', "%{$cityName}%"],
                ])
                // TODO можно заменить на firstOrCreate
                ->first();

            if (!$city) {
                // TODO вот тут будет проблема с region_id, который в cities не должен быть nullable
                $city = City::query()->create([
                    'name' => $cityName,
                ]);
            }

            SoldProduct::query()->create([
                // TODO title rename to name
                'title' => $soldProduct['Наименование'],
                'city_id' => $city->id,
                'product_id' => $soldProduct['id оборудования'],
            ]);
        }

    }

    // TODO проблемы с нейминг - методы с префиксом get должны возвращать что то, а у тебя он не возвращает
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

    // TODO у тебя метод transformCsv работает с csv, а потом запускает валидацию, потом mapping. нужно бы разбить на 2 метода
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
                // TODO не нужно использовать cyrillic как array key, это очень не надежно
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
        // TODO валидация сделана очень сложно, нужно сделать как дефолтно в laravel - https://ibb.co/4j4tkNR


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

        // TODO давай не будем central district by default делать. пускай строки с неправильным district будет skip
        return array_key_exists($districtName, $mapped) ? $mapped[$districtName] : District::Central;
    }

    // TODO давай вынесем в отдельный класс, который будет подключаться к google service, а в других классах мы уже будем его в constructor и будем уверены что он со всей авторизацией
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
                // TODO нужно путь закинуть в storage, у тебя он отличается - сначала storage, потом base
                base_path('secret-data/google/token_drive.json')
            )
        );
    }
}
