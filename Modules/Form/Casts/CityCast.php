<?php


namespace Modules\Form\Casts;



use Modules\Geo\Models\City;

/**
 * Class CityCast
 * @package Modules\Form\Casts
 */
class CityCast implements CastsInterface
{
    private ?City $city = null;

    /**
     * @param int $id
     * @return City|null
     */
    public function get($id): ?City
    {
        if (!is_null($this->city)) {
            return $this->city;
        }

        return $this->city = City::find($id);
    }
}
