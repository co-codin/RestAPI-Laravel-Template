<?php


namespace App\Providers;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Str;

class MacrosServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Collection::macro('present', function ($class) {
            return $this->map(function ($model) use ($class) {
                return new $class($model);
            });
        });

        Collection::macro('trim', function (string $charList = " \t\n\r\0\x0B") {
            return $this->map(function ($item) use ($charList) {
                return trim($item, $charList);
            });
        });

        Str::macro('exist_arr', function (string $haystack, array $needle) {
            foreach ($needle as $what) {
                if (($pos = strpos($haystack, (string)$what)) !== false || $pos === 0) {
                    return true;
                }
            }

            return false;
        });

        Arr::macro('mergeRecursive', function ($a, $b) {
            $args = func_get_args();
            $res = array_shift($args);
            while (!empty($args)) {
                foreach (array_shift($args) as $k => $v) {
                    if (is_int($k)) {
                        if (array_key_exists($k, $res)) {
                            $res[] = $v;
                        } else {
                            $res[$k] = $v;
                        }
                    } elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
                        $res[$k] = static::mergeRecursive($res[$k], $v);
                    } else {
                        $res[$k] = $v;
                    }
                }
            }
            return $res;
        });
    }
}
