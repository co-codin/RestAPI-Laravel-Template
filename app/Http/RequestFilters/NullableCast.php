<?php


namespace App\Http\RequestFilters;

use Illuminate\Support\Collection;
use BinaryCats\Sanitizer\Contracts\Filter;

class NullableCast implements Filter
{
    /**
     * @throws \JsonException
     */
    public function apply($value, $options = [])
    {
        if (is_null($value)) {
            return null;
        }

        $type = $options[0] ?? null;

        switch ($type) {
            case 'int':
            case 'integer':
                return (int)$value;
            case 'real':
            case 'float':
            case 'double':
                return (float)$value;
            case 'string':
                return (string)$value;
            case 'bool':
            case 'boolean':
                return (bool)$value;
            case 'object':
                return is_array($value) ? (object)$value : json_decode($value, false, 512, JSON_THROW_ON_ERROR);
            case 'array':
                return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
            case 'collection':
                $array = is_array($value) ? $value : json_decode($value, true, 512, JSON_THROW_ON_ERROR);
                return new Collection($array);
            default:
                throw new \InvalidArgumentException("Wrong Sanitizer casting format: {$type}.");
        }
    }
}
