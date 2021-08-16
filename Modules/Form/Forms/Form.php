<?php

namespace Modules\Form\Forms;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Modules\Brand\Models\Brand;
use Modules\Category\Models\Category;
use Modules\Form\Casts\BrandCast;
use Modules\Form\Casts\CastsInterface;
use Modules\Form\Casts\CategoryCast;
use Modules\Form\Casts\CityCast;
use Modules\Form\Casts\ProductCast;
use Modules\Product\Models\Product;

/**
 * Class Form
 * @package Modules\Form\Forms
 * @property bool $sendToCrm
 * @property bool $sendToBitrix
 * @property bool $sendToMail
 * @property bool $withAuth
 */
abstract class Form
{
    public bool $sendToCrm = true;
    public bool $sendToBitrix = true;
    public bool $sendToMail = true;
    public bool $withAuth = true;

    protected ?array $utm;
    protected ?string $page;
    protected int|string|null $roistatVisit;
    protected array $attributes = [];

    abstract public function title(): string;

    public function __construct()
    {
        $this->boot();
    }

    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Boot up the form, pushing casts
     */
    public function boot()
    {
        //
    }

    public function rules(): array
    {
        return [];
    }

    public function attributeLabels(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }

    public static function getName(): string
    {
        return class_basename(static::class);
    }

    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function addAttributes(array $attributes): self
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }

    public function unsetAttributes(array $attributes): self
    {
        foreach ($attributes as $attribute) {
            unset($this->attributes[$attribute]);
        }

        return $this;
    }

    public function withoutAttributes(array $attributes): self
    {
        $form = clone $this;

        return $form->unsetAttributes($attributes);
    }

    public function getAttribute(string $name, mixed $default = null): mixed
    {
        return Arr::get($this->attributes(), $name, $default);
    }

    public function attributes(): array
    {
        $attributes = $this->attributes;

        $this->addAdditionalAttributes($attributes);

        if ($utm = $this->getUtm()) {
            $attributes = array_merge($attributes, $utm);
        }

        return $attributes;
    }

    public function toArray(): array
    {
        return $this->attributes();
    }

    public function toString(): string
    {
        $summary = [];

        foreach ($this->attributes() as $key => $value) {
            $summary[] = "<b>" . Arr::get($this->attributeLabels(), $key, $key) . ":</b> " . $value;
        }

        return implode("<br>", $summary);
    }

    public function getProperties(): array
    {
        $properties = [];

        foreach ($this->attributes() as $key => $item) {
            $properties[] = [
                'property' => $key,
                'value' => $item
            ];
        }

        return $properties;
    }


    private function getCastedAttribute(string $attributeName, ?CastsInterface $cast = null): mixed
    {
        $attributeValue = $this->getAttribute($attributeName);

        if (is_null($cast) || is_null($attributeValue)) {
            return null;
        }

        return $cast->get($attributeValue);
    }

    public function getProduct(): ?Product
    {
        return $this->getCastedAttribute('product', new ProductCast());
    }

    public function getCategory(): ?Category
    {
        return $this->getCastedAttribute('category', new CategoryCast());
    }

    public function getBrand(): ?Brand
    {
        return $this->getCastedAttribute('brand', new BrandCast());
    }

    public function getCity(): ?City
    {
        return $this->getCastedAttribute('city', new CityCast());
    }


    public function emails(): ?array
    {
        return config('services.mails.forms');
    }

    public function getEmail(): ?string
    {
        return $this->getAttribute('email');
    }

    public function getPhone(): ?string
    {
        return $this->getAttribute('phone');
    }

    public function setUtm(?array $utm = null): self
    {
        $this->utm = $utm;

        return $this;
    }

    public function setRoistatVisit(string|int|null $roistatVisit = null): self
    {
        $this->roistatVisit = $roistatVisit;

        return $this;
    }

    public function setPage(string $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getUtm(): ?array
    {
        return $this->utm;
    }

    public function getConcreteUtm(string $key): ?string
    {
        return Arr::get($this->utm, $key);
    }

    public function getRoistatVisit(): ?string
    {
        return $this->roistatVisit;
    }

    public function getPage(): string
    {
        return $this->page;
    }

    public function ym(): ?string
    {
        return null;
    }

    public function ga(): ?string
    {
        return null;
    }

    public function emailSubject(): string
    {
        return 'Новая заявка с сайта medeq.ru';
    }

    public function popupTitle(): string
    {
        return 'Заявка успешно отправлена';
    }

    public function popupMessage(): string
    {
        return 'Наши менеджеры скоро с Вами свяжутся';
    }

    public function getComments(): string
    {
        $date = Carbon::parse(now())->format('d.m.Y H:i:s');
        $page = $this->getPage();

        if ($pos = strpos($page, '?utm')) {
            $page = substr($page, 0, $pos);
        }

        $nameComment = $this->getComment("<br><b>Имя:</b>", $this->getAttribute('name'));
        $phoneComment = $this->getComment("<br><b>Телефон:</b>", $this->getPhone());
        $emailComment = $this->getComment("<br><b>Email:</b>", $this->getEmail());

        return "
                <b>Получена заявка:</b> $date
                <br><b>Форма:</b> {$this->title()}
                $nameComment
                $phoneComment
                $emailComment
                <br><b>Страница:</b> $page
                ";
    }

    protected function getComment(string $comment, ?string $attr = null): ?string
    {
        if (!is_null($attr)) {
            return $comment . ' ' . $attr;
        }

        return null;
    }

    public function jsCallbackMethod(): ?string
    {
        return static::getName();
    }

    public function jsCallbackReturn(): bool
    {
        return false;
    }


    public function response(): array
    {
        return [
            'popupTitle' => $this->popupTitle(),
            'popupMessage' => $this->popupMessage(),
            'jsCallback' => $this->jsCallbackMethod(),
            'jsCallbackReturn' => $this->jsCallbackReturn(),
            'ym' => $this->ym(),
            'ym_id' => config('services.yandex-metrika.id'),
            'ga' => $this->ga(),
            'isTestRequest' => $this->isTestRequest(),
        ];
    }

    public function isTestRequest(): bool
    {
        $email = $this->getEmail();
        $phone = $this->getPhone();
        $ip = request()->ip();

        $testPatterns = config('form.test_patterns');

        $testDataCollection = [
            $phone => $testPatterns['phones'],
            $email => $testPatterns['emails'],
            $ip => $testPatterns['ips'],
        ];

        foreach ($testDataCollection as $verifiableData => $testData) {
            if (\Str::exist_arr($verifiableData, $testData)) {
                return true;
            }
        }

        return false;
    }

    protected function additionalAttributes(): array
    {
        return [];
    }

    protected function addAdditionalAttributes(array &$attributes): void
    {
        $attributes = array_merge($attributes, $this->additionalAttributes());
    }
}
