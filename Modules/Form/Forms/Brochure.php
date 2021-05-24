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
        $product = $this->getProduct();

        if (!is_null($product) && $product->booklet) {
            return $product->booklet;
        }

        return null;
    }

    protected function getBrochureFilename(): ?string
    {
        $product = $this->getProduct();

        if (!is_null($product) && $product->booklet) {
            return "Брошюра {$product->brand->title} {$product->title}." . pathinfo($product->booklet)['extension'];
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
        $categoryTitle = optional($category)->title;
        $categoryComment = $this->getComment("<br><b>Категория:</b>", $categoryTitle);

        $link = route('product-view', [
            'slug' => $product->slug,
            'id' => $product->id,
        ]);

        return "
                $default
                $categoryComment
                <br><b>Оборудование:</b> {$product->getFullTitle()}
                <br><b>Ссылка на оборудование:</b> $link
                ";
    }

    public function jsCallbackReturn(): bool
    {
        return true;
    }
}
