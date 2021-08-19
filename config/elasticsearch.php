<?php

return [
    'hosts' => explode(',', env('ELASTICSEARCH_HOSTS')),
    'index_name_prefix' => env('ELASTICSEARCH_INDEX_PREFIX'),
];
