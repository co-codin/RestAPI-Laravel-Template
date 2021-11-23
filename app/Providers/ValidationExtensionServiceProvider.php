<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Validator as ValidationValidator;

class ValidationExtensionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('integer_keys', function ($attribute, $value, $parameters, $validator) {
            return is_array($value) && count(array_filter(array_keys($value), 'is_string')) === 0;
        });

        Validator::extend('external_links', function ($attribute, $value, $parameters, $validator) {
            $regular = '~(?!http:\/\/medeqstars\.ru|https:\/\/medeqstars\.ru|http:\/\/medeq\.ru|https:\/\/medeq\.ru)(([-\w]+\.)'
                . '+(com|net|org|info|biz|com.ru|org.ru|net.ru|ru|su|us|bz|kz|'
                . 'ws|рф|pro|li|cc|me|mi|in|is|to|ly|gd|click|lt|download|diet|'
                . 'work|tokyo|racing|science|party|faith|москва|рус|xyz|bar|shop)+(\s|$))(?<!medeqstars\.ru\s|medeq\.ru\s)~ui';

            preg_match_all($regular, $value, $externalLinks, PREG_SET_ORDER);

            $re = '/'
                . '(?!http:\/\/medeqstars\.ru|https:\/\/medeqstars\.ru|http:\/\/medeq\.ru|https:\/\/medeq\.ru)'
                . '(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?'
                . '(?:'
                . '(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})'
                . '(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})'
                . '(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}'
                . '(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))'
                . '|'
                . '(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)'
                . '(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,}))'
                . ')'
                . '(?::\d{2,5})?(?:\/[^\s]*)?(?<!medeqstars\.ru|medeq\.ru)'
                . '/iu';

            preg_match_all($re, $value, $externalLinksDiegoperini, PREG_SET_ORDER);

            return !($externalLinks || $externalLinksDiegoperini);
        });

        Validator::extend('is_youtube_link', function ($attribute, string $value, $parameters, $validator) {
            $re = '^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$';

            preg_match($re, $value, $matches);

            if (!empty($matches)) {
                return true;
            }

            return false;
        });

        Validator::extend('distinct_concrete_keys', function (
            string $attribute,
            $value,
            array $parameters,
            ValidationValidator $validator
        ) {
            $attributeName = substr(strrchr($attribute, '.'), 1 );

            foreach ($parameters as $param) {
                $duplicateValues = collect($validator->getData())
                    ->filter(function (array $variation) use ($param, $attributeName) {
                        return $variation[$attributeName] == $param;
                    })
                    ->count();

                if ($duplicateValues > 1) {
                    return false;
                }
            }

            return true;
        });

        Validator::extend('phone_default_countries', function ($attribute, string $value, $parameters, ValidationValidator $validator) {
            $newValidator = Validator::make(
                ['phone' => $value],
                ['phone' => 'phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ'],
            );

            if ($newValidator->errors()->isEmpty()) {
                return true;
            }

            return false;
        });
    }
}
