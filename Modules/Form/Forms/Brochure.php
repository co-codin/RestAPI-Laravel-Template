<?php

namespace Modules\Form\Forms;

use Modules\Category\Models\Category;
use Modules\Form\Casts\CategoryCast;

/**
 * Class Brochure
 * @package Modules\Form\Forms
 */
class Brochure extends Form
{
    public function title(): string
    {
        return 'Скачивание брошюры';
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string|phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ|max:255',
            'product' => 'required|integer|exists:products,id',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => 'Телефон',
            'product' => 'Продукция',
        ];
    }

    protected function getBrochureUrl(): ?string
    {
        return $this->getProduct()->documents['booklet'] ?? null;
    }

    protected function getBrochureFilename(): ?string
    {
        $product = $this->getProduct();
        $booklet = $product->documents['booklet'] ?? null;

        if (!is_null($booklet)) {
            return "Брошюра {$product->brand->name} {$product->name}." . pathinfo($booklet)['extension'];
        }

        return null;
    }

    protected function successMessage(): string
    {
        return 'Скачивание брошюры начнется через 2-3 секунды';
    }

    public function response(): array
    {
        return array_merge(parent::response(), [
            'url' => $this->getBrochureUrl(),
            'brochure' => $this->getBrochureFilename(),
        ]);
    }

    public function ym(): ?string
    {
        return 'get-brochure';
    }

    public function ga(): ?string
    {
        return 'pamphlet_rush';
    }

    public function getCategory(): ?Category
    {
        $product = $this->getProduct();

        return (new CategoryCast())->getCategoryByProduct($product);
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $product = $this->getProduct();

        $category = $this->getCategory();
        $categoryTitle = optional($category)->name;
        $categoryComment = $this->getComment("<br><b>Категория:</b>", $categoryTitle);

        $link = route('product-view', [
            'slug' => $product->slug,
            'id' => $product->id,
        ]);

        $productFullTitle = optional($product->brand)->name . ' ' . $product->name;

        return "
                $default
                $categoryComment
                <br><b>Оборудование:</b> $productFullTitle
                <br><b>Ссылка на оборудование:</b> $link
                ";
    }

    public function jsCallbackReturn(): bool
    {
        return true;
    }
}
