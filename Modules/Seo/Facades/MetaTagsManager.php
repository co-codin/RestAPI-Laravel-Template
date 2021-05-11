<?php


namespace Modules\Seo\Facades;


use Modules\Seo\Models\Seo;
use Modules\Seo\Models\SeoRule;

/**
 * Class MetaTagsManager
 * @package Modules\Seo\Facades
 * @property string $title
 * @property string $h1
 * @property string $description
 * @property array $meta_tags
 * @property string|null seoRuleText
 * @property Seo|null $seo
 */
class MetaTagsManager
{
    protected $title;
    protected $h1;
    protected $description;
    protected $seoRuleText;
    protected $seo;
    protected $meta_tags = [];
    protected $texts = [];

    public function setTitle(string $title = null): self
    {
        $this->title = $title;

        return $this;
    }

    public function addMetaTag(string $name = '', string $content = ''): self
    {
        $this->meta_tags[] = ['name' => $name, 'content' => $content];

        return $this;
    }

    public function setDescription(string $description = null): self
    {
        $this->description = $description;

        return $this;
    }

    public function setH1(string $h1 = null): self
    {
        $this->h1 = $h1;

        return $this;
    }

    public function setSeoRuleText(string $text = null): self
    {
        $this->seoRuleText = $text;

        return $this;
    }

    public function setSeo($seo = null): self
    {
        $filtersExist = stripos(request()->url(), 'filters');

        if (!is_null($seo)) {
            if ($seo->seoable_type !== SeoRule::class && $filtersExist == false) {
                $this->seo = $seo;
            } else if (is_null($this->seo)) {
                $this->seo = $seo;
            }
        }


        // TODO вот тут подумать как лучше сделать, сейчас не назначает seo если уже назначено seo по url
        // таким образом делаются приоритеты, то есть seo по url приоритетнее чем по модели
        /*if (!is_null($seo) && is_null($this->seo)) {
            $this->seo = $seo;
        }*/

        return $this;
    }

    public function getTitle(string $default = null): ?string
    {
        return $this->getProperty('title', $default);
    }

    public function getH1(string $default = null): ?string
    {
        return $this->getProperty('h1', $default);
    }

    public function getDescription(string $default = null): ?string
    {
        return $this->getProperty('description', $default);
    }

    public function getMetaTags(string $default = null)
    {
        return $this->getProperty('meta_tags', $default);
    }

    public function getSeoRuleText(string $default = null): ?string
    {
        return $this->getProperty('seoRuleText', $default);
    }

    public function getTexts(string $default = null): ?array
    {
        return $this->getProperty('texts', $default);
    }

    private function getProperty(string $property, string $default = null)
    {
        $seoProperty = $this->getSeo()->{$property};

        if (is_null($seoProperty) && is_null($this->{$property})) {
            return $default;
        }

        return str_replace("medeqstars.ru", "medeq.ru", $seoProperty ?? $this->{$property});
    }

    protected function getSeo(): Seo
    {
        return $this->seo ?? new Seo([
                'title' => $this->title,
                'h1' => $this->h1,
                'description' => $this->description,
                'meta_tags' => $this->meta_tags,
                'texts' => $this->texts,
            ]);
    }
}
