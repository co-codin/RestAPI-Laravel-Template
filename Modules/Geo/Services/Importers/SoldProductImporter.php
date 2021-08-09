<?php


namespace Modules\Geo\Services\Importers;


use App\Enums\Status;
use Modules\Category\Models\Category;
use Modules\Geo\Dto\ClientsGeographyDto;
use Modules\Geo\Models\City;
use Modules\Geo\Models\SoldProduct;
use Modules\Geo\Enums\ClientGeographyType;

class SoldProductImporter
{
    /**
     * @param ClientsGeographyDto $dto
     * @param City $city
     * @return SoldProduct
     */
    public function getSoldProduct(ClientsGeographyDto $dto, City $city): SoldProduct
    {
        $soldProductTitle = (!is_null($dto->web_title) ? $dto->web_title . ' ' : '')
            . $dto->brand
            . ' '
            . $dto->product_title;

        $categoryId = $this->getCategoryId($dto->category);

        $type = $this->getType($dto->type);

        return new SoldProduct([
            'title' => $soldProductTitle,
            'product_id' => $dto->product_id,
            'category_id' => $categoryId,
            'city_id' => $city->id,
            'type' => $type->value,
            'status' => Status::Active,
        ]);
    }

    /**
     * @param string $categoryTitle
     * @return int|null
     */
    private function getCategoryId(string $categoryTitle): ?int
    {
        $category = Category::query()
            ->select('id')
            ->where('title', 'like', "%$categoryTitle%")
            ->first();

        return !empty($category) ? $category->id : null;
    }

    /**
     * @param string|null $type
     * @return ClientGeographyType
     */
    private function getType(?string $type = null): ClientGeographyType
    {
        $clientType = ClientGeographyType::fromValue(ClientGeographyType::State);
        $clientTypes = ClientGeographyType::getInstances();

        foreach ($clientTypes as $item) {
            if ($item->description == $type) {
                $clientType = $item;
                continue;
            }
        }

        return $clientType;
    }
}
