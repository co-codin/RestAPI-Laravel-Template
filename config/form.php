<?php

return [
    'send_test_request' => env('SEND_TEST_REQUEST', false),
    "test_patterns" => [
        "emails" => ["@medeqstars.ru", "@medeq.ru", "@lenarx.ru"],
        "phones" => ['+79995107817', '+79196370497', '+79196449942'],        //с кодом страны, также как при регистрации на сайте
        "ips" => [],
    ],
];
