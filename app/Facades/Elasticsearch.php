<?php


namespace App\Facades;

use Elasticsearch\Client;
use Illuminate\Support\Facades\Facade;

class Elasticsearch extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Client::class;
    }
}
