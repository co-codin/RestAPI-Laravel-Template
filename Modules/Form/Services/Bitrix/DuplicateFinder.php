<?php


namespace Modules\Form\Services\Bitrix;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Bitrix24;

/**
 * Class DuplicateFinder
 * @package Modules\Form\Services\Bitrix
 * @property Collection $ids
 */
class DuplicateFinder
{
    // инициализируем пустой массив для складывания дубликатов в лидах, контактах
    public $ids = [
        'lead' => [],
        'contact' => []
    ];

    public function __construct()
    {
        $this->ids = collect($this->ids);
    }

    /**
     * @param string|null $phone
     * @return $this
     */
    public function findByPhone(?string $phone = null): self              // ищем дубликаты по всем вариантам написания телефона и складываем ids массив
    {
        if (!is_null($phone)) {
            $this->ids = $this->ids->mergeRecursive(
                $this->findDuplicates($this->findAllPhoneVariants($phone), 'phone')
            );
        }

        return $this;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function findByEmail(?string $email = null): self              // ищем дубликаты по email и складываем в ids массив
    {
        if (!is_null($email)) {
            $this->ids = $this->ids->mergeRecursive(
                $this->findDuplicates($email, 'email')
            );
        }

        return $this;
    }

    public function getLeadIds(): array
    {
        return Arr::get($this->ids, 'lead', []);
    }

    public function getContactIds(): array
    {
        return Arr::get($this->ids, 'contact', []);
    }

    /**
     * @param string|array $values
     * @param string $type
     * @return array
     */
    private function findDuplicates($values, string $type): array
    {
        if (is_string($values)) {
            $values = [$values];
        }

        return Bitrix24::call('crm.duplicate.findbycomm', [
            'type' => $type,
            'values' => $values
        ])['result'];
    }

    /**
     * @param string|null $phone
     * @return array
     */
    private function findAllPhoneVariants(?string $phone = null): array
    {
        if (is_null($phone)) return [];

        return [$phone, "+7{$phone}", "7{$phone}", "8{$phone}"];
    }
}
