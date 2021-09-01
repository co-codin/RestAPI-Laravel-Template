<?php


namespace Modules\Geo\Console;


use App\Services\GoogleDriveService;
use Google_Client;
use Google_Service_Drive;
use Illuminate\Console\Command;
use Modules\Customer\Enums\District;
use Modules\Geo\Enums\SoldProductKeys;
use Modules\Geo\Models\City;
use Modules\Geo\Models\SoldProduct;
use Modules\Product\Models\Product;

/**
 * Class ClientsGeographyImport
 * @package Modules\Client\Console\Imports
 */
class ClientsGeographyImportCommand extends Command
{
    protected $signature = 'sold-products:import';

    protected $description = 'Import sold products';

    protected string $fileContent;
    protected $soldProducts;

    public function __construct(
        protected GoogleDriveService   $googleDriveService,
        protected Google_Service_Drive $serviceDrive,
    )
    {
        parent::__construct();
        $this->soldProducts = collect();
    }

    public function handle(): void
    {
        $this->serviceDrive = $this->googleDriveService->getDriveService();
        $this->fileContent = $this->getFileContent();
        $this->soldProducts = collect();
        $this->transformCsv();

        SoldProduct::query()->delete();

        foreach ($this->soldProducts as $soldProduct) {
            $cityName = $soldProduct[SoldProductKeys::CITY];
            $city = City::query()->firstOrCreate([
                'name' => $cityName,
            ]);

            SoldProduct::query()->create([
                'name' => $soldProduct[SoldProductKeys::NAME],
                'city_id' => $city->id,
                'product_id' => $soldProduct[SoldProductKeys::PRODUCT_ID],
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

        return $response->getBody()->getContents();
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
                $soldProduct[SoldProductKeys::DISTRICT] = $this->getDistrict($soldProduct[SoldProductKeys::DISTRICT]);
                return $soldProduct;
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

        return array_key_exists($districtName, $mapped) ? $mapped[$districtName] : null;
    }
}
