<?php


namespace Modules\Geo\Console;


use Google_Service_Drive;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Modules\Customer\Enums\District;
use Modules\Geo\Enums\SoldProductKeys;
use Modules\Geo\Models\City;
use Modules\Geo\Models\SoldProduct;

/**
 * Class ClientsGeographyImport
 * @package Modules\Client\Console\Imports
 */
class SoldProductsImportCommand extends Command
{
    protected $signature = 'sold-products:import';

    protected $description = 'Import sold products';

    protected string $fileContent;
    protected $soldProducts;

    public function handle(Google_Service_Drive $driveService): void
    {
        $this->fileContent = $driveService->files
            ->export(config('services.google-api.drive.files.sold-products'), 'text/csv', ['alt' => 'media'])
            ->getBody()
            ->getContents();

        $this->soldProducts = collect();

        $this->transformCsv();
        $this->validateSoldProducts();
        $this->mapSoldProducts();

        SoldProduct::query()->truncate();

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
        ;
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
    }

    private function validateSoldProducts(): Collection
    {
        $rules = [
            'data.*.' . SoldProductKeys::NAME => 'required|max:255',
            'data.*.' . SoldProductKeys::DISTRICT => 'required',
            'data.*.' . SoldProductKeys::CITY => 'required|max:255',
            'data.*.' . SoldProductKeys::PRODUCT_ID => 'required|exists:products,id',
        ];


        $validator = Validator::make(['data' => $this->soldProducts->toArray()], $rules);

        return collect($validator->valid());
    }

    private function mapSoldProducts()
    {
        $this->soldProducts = $this->soldProducts->map(function ($soldProduct) {
            $soldProduct[SoldProductKeys::DISTRICT] = $this->getDistrict($soldProduct[SoldProductKeys::DISTRICT]);
            return $soldProduct;
        })
        ->values();
    }


    private function getDistrict($districtName)
    {
        $mapped = collect(District::getInstances())->mapWithKeys(function ($value, $key) {
            return [$value->description => $value->value];
        })->toArray();

        return array_key_exists($districtName, $mapped) ? $mapped[$districtName] : null;
    }
}
