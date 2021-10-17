<?php


namespace Modules\Geo\Console;


use Google_Service_Drive;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
        SoldProduct::query()->truncate();

//        $this->fileContent = $driveService->files
//            ->export(config('services.google-api.drive.files.sold-products'), 'text/csv', ['alt' => 'media'])
//            ->getBody()
//            ->getContents();

        $this->fileContent = file_get_contents(storage_path('app/sold-products.csv'));

//        $this->fileContent = file_get_contents(storage_path('app/sold_products.csv'));

        $this->soldProducts = collect();

        $this->transformCsv();
        $this->validateSoldProducts();

        foreach ($this->soldProducts as $soldProduct) {
            $cityName = $soldProduct[SoldProductKeys::CITY];
            $city = City::query()->firstOrCreate([
                'name' => $cityName,
                'federal_district' => array_flip(District::asSelectArray())[$soldProduct[SoldProductKeys::FEDERAL_DISTRICT]]
            ]);

            SoldProduct::query()->create([
                'name' => $soldProduct[SoldProductKeys::NAME],
                'city_id' => $city->id,
                'product_id' => $soldProduct[SoldProductKeys::PRODUCT_ID] ?? null,
            ]);
        }
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

        $this->soldProducts = $this->soldProducts->map(function ($item) {
            return Arr::only($item, [SoldProductKeys::CITY, SoldProductKeys::NAME, SoldProductKeys::FEDERAL_DISTRICT, SoldProductKeys::PRODUCT_ID]);
        });
    }

    private function validateSoldProducts()
    {
        $validatedData = collect();

        $rules = [
            SoldProductKeys::NAME => 'required|string|max:255',
            SoldProductKeys::CITY => 'required|string|max:255',
            SoldProductKeys::PRODUCT_ID => 'required|integer|exists:products,id',
            SoldProductKeys::FEDERAL_DISTRICT => [
                'required',
                'string',
                Rule::in(District::asSelectArray()),
            ],
        ];

        foreach ($this->soldProducts->toArray() as $soldProduct) {
            $validator = Validator::make($soldProduct, $rules);

            if ($validator->fails()) {
                 continue;
            } else {
                $validatedData->add($validator->valid());
            }
        }

        $this->soldProducts = $validatedData;
    }

    protected function getCity()
    {

    }
}
