<?php

namespace Modules\Form\Forms;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Modules\Client\Models\City;
use Modules\Form\Casts\BrandCast;
use Modules\Form\Casts\CastsInterface;
use Modules\Category\Models\Category;
use Modules\Brand\Models\Brand;
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
 */
abstract class Form
{
    public bool $sendToCrm = true;
    public bool $sendToBitrix = true;
    public bool $sendToMail = true;

    protected array $attributes = [];
    protected ?array $utm = null;
    protected ?string $page;
    private int|string|null $roistatVisit;

    abstract public function title(): string;
    abstract public function rules(): array;
    abstract public function attributeLabels(): array;

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

    public function messages(): array
    {
        return [];
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

    protected function addAdditionalAttributes(array &$attributes): void
    {
        $attributes = array_merge($attributes, $this->additionalAttributes());
    }

    protected function additionalAttributes(): array
    {
        return [];
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getAttribute(string $name, mixed $default = null): mixed
    {
        return Arr::get($this->attributes(), $name, $default);
    }

    /**
     * @param string $attributeName
     * @param CastsInterface|null $cast
     * @return mixed
     */
    private function getCastedAttribute(string $attributeName, ?CastsInterface $cast = null): mixed
    {
        $attribute = $this->getAttribute($attributeName);

        if (is_null($cast) || is_null($attribute)) {
            return null;
        }

        return $cast->get($attribute);
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

    public function emails(): ?array
    {
        $emails = config('services.mails.forms');

        return !is_null($emails)
            ? $emails
            : null;
    }

    public function getEmail(): ?string
    {
        return $this->getAttribute('email');
    }

    public function getPhone(): ?string
    {
        return $this->getAttribute('phone');
        $phone = $this->getAttribute('phone');

        return $phone !== "+7" ? $phone : null;
    }

    public function fill(array $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function setUtm(?array $utm = null): self
    {
        $this->utm = $utm;

        return $this;
    }

    /**
     * @param string|int|null $roistatVisit
     * @return $this
     */
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

    public function getPage(): string
    {
        return $this->page;
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

    public static function getName(): string
    {
        return class_basename(static::class);
    }

    public function jsCallbackMethod(): ?string
    {
        return static::getName();
    }

    public function jsCallbackReturn(): bool
    {
        return false;
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

    public function getComments(): string
    {
        $date = Carbon::parse(now())->format('d.m.Y H:i:s');
        $url = $this->getAttribute('url');

        $pos = strpos($url, '?utm');

        if ($pos) {
            $url = substr($url, 0, $pos);
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
                <br><b>Страница:</b> $url
                ";
    }

    protected function getComment(string $comment, ?string $attr = null): ?string
    {
        if (!is_null($attr)) {
            return $comment . ' ' . $attr;
        }

        return null;
    }

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        $cast = new ProductCast();

        return $this->getCastedAttribute('product', $cast);
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        $cast = new CategoryCast();

        return $this->getCastedAttribute('category', $cast);
    }

    /**
     * @return Brand|null
     */
    public function getBrand(): ?Brand
    {
        $cast = new BrandCast();

        return $this->getCastedAttribute('brand', $cast);
    }

    /**
     * @return City|null
     */
    public function getCity(): ?City
    {
        $cast = new CityCast();

        return $this->getCastedAttribute('city', $cast);
    }

    /**
     * @param array $attributes
     * @return Form
     */
    public function unsetAttributes(array $attributes): self
    {
        foreach ($attributes as $attribute) {
            unset($this->attributes[$attribute]);
        }

        return $this;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function withoutAttributes(array $attributes): self
    {
        $form = clone $this;

        return $form->unsetAttributes($attributes);
    }
}
