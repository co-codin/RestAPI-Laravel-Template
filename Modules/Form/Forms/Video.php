<?php

namespace Modules\Form\Forms;

use Modules\Category\Models\Category;
use Modules\Form\Casts\CategoryCast;

/**
 * Class Video
 * @package Modules\Form\Forms
 */
class Video extends Form
{
    public function title(): string
    {
        return 'Просмотр видеообзора';
    }

    public function rules(): array
    {
        return [
            'product' => 'required|integer|exists:products,id',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'product' => 'Продукция',
        ];
    }

    public function jsCallbackReturn(): bool
    {
        return true;
    }

    public function response(): array
    {
        return array_merge(parent::response(), [
            'video' => $this->getVideo(),
            'video_id' => $this->getVideoId(),
        ]);
    }

    public function ym(): ?string
    {
        return 'get-video';
    }

    public function ga(): ?string
    {
        return 'video_rush';
    }

    public function getCategory(): ?Category
    {
        return (new CategoryCast())->getCategoryByProduct(
            $this->getProduct()
        );
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $product = $this->getProduct();

        $categoryComment = $this->getComment(
            "<br><b>Категория:</b>",
            optional($this->getCategory())->name
        );

        $link = route('product-view', [
            'slug' => $product->slug,
            'id' => $product->id,
        ]);

        $productFullTitle = $product->brand->name . ' ' . $product->name;

        return "
                $default
                $categoryComment
                <br><b>Оборудование:</b> $productFullTitle
                <br><b>Ссылка на оборудование:</b> $link
                ";
    }

    private function getVideo(): ?string
    {
        $product = $this->getProduct();

        if (!is_null($product) && $product->video) {
            return $product->video;
        }

        return null;
    }

    private function getVideoId(): ?string
    {
        $product = $this->getProduct();

        if (!is_null($product) && $product->video) {
            preg_match(
                '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
                $product->video,
                $match
            );

            return $match[1];
        }

        return null;
    }
}
