<?php


namespace Modules\Geo\Services\Importers;


use hanneskod\classtools\Exception\LogicException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Modules\Geo\Dto\ClientsGeographyDto;
use Modules\Geo\Models\City;
use Modules\Customer\Enums\District;

class CitiesImporter
{
    /**
     * @param ClientsGeographyDto $dto
     * @return City
     */
    public function import(ClientsGeographyDto $dto): City
    {
        $district = $this->getDistrict($dto->district);
        $city = $this->getCity($dto->city, $district);

        if (empty($city)) {
            $city = new City([
                'title' => $dto->city,
                'district' => $district->value,
            ]);

            if (!$city->save()) {
                throw new LogicException('Не удалось сохранить Город');
            }
        }

        return $city;
    }

    /**
     * @param string $districtDescription
     * @return District
     */
    private function getDistrict(string $districtDescription): District
    {
        $district = District::fromValue(District::Central);
        $districts = District::getInstances();

        foreach ($districts as $item) {
            if ($item->description == $districtDescription) {
                $district = $item;
                continue;
            }
        }

        return $district;
    }

    /**
     * @param string $cityTitle
     * @param District $district
     * @return Builder|Model|QueryBuilder|City|object|null
     */
    private function getCity(string $cityTitle, District $district): ?City
    {
        if ($cityTitle)
        return City::query()
            ->select('id')
            ->where('district', $district->value)
            ->where('title', 'like', "%$cityTitle%")
            ->first();
    }
}
