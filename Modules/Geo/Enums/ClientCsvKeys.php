<?php


namespace Modules\Geo\Enums;

use Modules\Product\Models\Product;


class ClientCsvKeys
{
    const MANAGER = 0;
    const CATEGORY = 1;
    const WEB_TITLE = 2;
    const BRAND = 3;
    const PRODUCT_TITLE = 4;
    const COUNT = 5;
    const SERIAL_NUMBER = 6;
    const TYPE = 7;
    const LEASING = 8;
    const CLIENT = 9;
    const CITY = 10;
    const DISTRICT = 11;
    const PRICE_RUB = 12;
    const PRICE_US = 13;
    const FIRST_PAY_DATE = 14;
    const CLOSE_DATE = 15;
    const IMPLEMENTATION_DATE = 16;
    const COMPANY = 17;
    const NUMBER_PROJECT = 18;
    const PRODUCT_ID = 19;

    /**
     * @param array $data
     * @throws \Exception
     */
    public static function checkRequiredFields(array $data): void
    {
        $requiredFields = [
            self::BRAND,
            self::CATEGORY,
            self::WEB_TITLE,
            self::CITY,
            self::PRODUCT_TITLE,
            self::TYPE,
            self::DISTRICT,
            self::PRODUCT_ID,
        ];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new \Exception('not found required fields');
            }
        }
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public static function checkProduct(array $data): void
    {
        $productId = $data[self::PRODUCT_ID] ?? null;
        $product = Product::find($productId);

        if (is_null($product)) {
            throw new \Exception('Not found product or missing product id');
        }
    }
}
