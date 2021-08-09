<?php


namespace Modules\Geo\Dto;


use App\Dto\BaseDto;
use Modules\Geo\Enums\ClientCsvKeys;

class ClientsGeographyDto extends BaseDto
{
    /**
     * @var string|null
     */
    public $manager;

    /**
     * @var string
     */
    public $category;

    /**
     * @var string
     */
    public $web_title;

    /**
     * @var string
     */
    public $brand;

    /**
     * @var string
     */
    public $product_title;

    /**
     * @var string|null
     */
    public $serial_number;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string|null
     */
    public $leasing;

    /**
     * @var string|null
     */
    public $client;

    /**
     * @var string
     */
    public $city;

    /**
     * @var string
     */
    public $district;

    /**
     * @var string|null
     */
    public $price_rub;

    /**
     * @var string|null
     */
    public $price_us;

    /**
     * @var string|null
     */
    public $first_pay_date;

    /**
     * @var string|null
     */
    public $close_date;

    /**
     * @var string|null
     */
    public $implementation_date;

    /**
     * @var string|null
     */
    public $company;

    /**
     * @var string|null
     */
    public $number_project;

    /**
     * @var int
     */
    public $product_id;

    /**
     * @param array $items
     * @return self
     */
    public static function create(array $items): self
    {
        return new self([
            'manager' => !empty($items[ClientCsvKeys::MANAGER]) ? trim($items[ClientCsvKeys::MANAGER]) : null,
            'category' => trim($items[ClientCsvKeys::CATEGORY]),
            'web_title' => !empty($items[ClientCsvKeys::WEB_TITLE]) ? trim($items[ClientCsvKeys::WEB_TITLE]) : null,
            'brand' => trim($items[ClientCsvKeys::BRAND]),
            'product_title' => trim($items[ClientCsvKeys::PRODUCT_TITLE]),
            'serial_number' => !empty($items[ClientCsvKeys::SERIAL_NUMBER]) ? trim($items[ClientCsvKeys::SERIAL_NUMBER]) : null,
            'type' => trim($items[ClientCsvKeys::TYPE]),
            'leasing' => !empty($items[ClientCsvKeys::LEASING]) ? trim($items[ClientCsvKeys::LEASING]) : null,
            'client' => !empty($items[ClientCsvKeys::CLIENT]) ? trim($items[ClientCsvKeys::CLIENT]) : null,
            'city' => str_replace('и?', 'й', trim($items[ClientCsvKeys::CITY])),
            'district' => trim($items[ClientCsvKeys::DISTRICT]),
            'price_rub' => !empty($items[ClientCsvKeys::PRICE_RUB]) ? trim($items[ClientCsvKeys::PRICE_RUB]) : null,
            'price_us' => !empty($items[ClientCsvKeys::PRICE_US]) ? trim($items[ClientCsvKeys::PRICE_US]) : null,
            'first_pay_date' => !empty($items[ClientCsvKeys::FIRST_PAY_DATE]) ? trim($items[ClientCsvKeys::FIRST_PAY_DATE]) : null,
            'close_date' => !empty($items[ClientCsvKeys::CLOSE_DATE]) ? trim($items[ClientCsvKeys::CLOSE_DATE]) : null,
            'implementation_date' => !empty($items[ClientCsvKeys::IMPLEMENTATION_DATE]) ? trim($items[ClientCsvKeys::IMPLEMENTATION_DATE]) : null,
            'company' => !empty($items[ClientCsvKeys::COMPANY]) ? trim($items[ClientCsvKeys::COMPANY]) : null,
            'number_project' => !empty($items[ClientCsvKeys::NUMBER_PROJECT]) ? trim($items[ClientCsvKeys::NUMBER_PROJECT]) : null,
            'product_id' => (int)trim($items[ClientCsvKeys::PRODUCT_ID]),
        ]);
    }
}
