<?php


namespace Modules\Export\Services\Generator\Market;


use Vitalybaev\GoogleMerchant\Feed;

class GoogleMarketGenerator implements GeneratorInterface
{
    public function __construct(
        protected GoogleMarketGenerator $googleMarketGenerator
    ) {}

    public function generate(array $parameters)
    {
        $feed = new Feed(
            config('services.google-market.company_name'),
            config('services.google-market.link'),
            config('services.google-market.description'),
        );
    }

    public function transform($data)
    {

    }
}
