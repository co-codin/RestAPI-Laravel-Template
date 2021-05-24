<?php

return [
    'enabled' => env('ELASTICSEARCH_ENABLED', true),
    'hosts' => explode(',', env('ELASTICSEARCH_HOSTS')),
    'index_prefix' => env('ELASTICSEARCH_INDEX_PREFIX'),
    'indices' => [
        \Modules\Product\Models\Product::class => [
            'repository' => \Modules\Product\Repositories\ProductRepository::class,
            'settings' => [
                'number_of_shards' => 2,
                'number_of_replicas' => 0,
                'index' => [
                    'max_ngram_diff' => 10
                ],
                "analysis" => [
                    'char_filter' => [
                        'ru_en_key' => [
                            'type' => 'mapping',
                            'mappings' => [
                                "Ё => Е",
                                "ё => е",
                                "a => ф",
                                "b => и",
                                "c => с",
                                "d => в",
                                "e => у",
                                "f => а",
                                "g => п",
                                "h => р",
                                "i => ш",
                                "j => о",
                                "k => л",
                                "l => д",
                                "m => ь",
                                "n => т",
                                "o => щ",
                                "p => з",
                                "q => й",
                                "r => к",
                                "s => ы",
                                "t => е",
                                "u => г",
                                "v => м",
                                "w => ц",
                                "x => ч",
                                "y => н",
                                "z => я",
                                "A => Ф",
                                "B => И",
                                "C => С",
                                "D => В",
                                "E => У",
                                "F => А",
                                "G => П",
                                "H => Р",
                                "I => Ш",
                                "J => О",
                                "K => Л",
                                "L => Д",
                                "M => Ь",
                                "N => Т",
                                "O => Щ",
                                "P => З",
                                "Q => Й",
                                "R => К",
                                "S => Ы",
                                "T => Е",
                                "U => Г",
                                "V => М",
                                "W => Ц",
                                "X => Ч",
                                "Y => Н",
                                "Z => Я",
                                "[ => х",
                                "{ => Х",
                                "] => ъ",
                                "} => Ъ",
                                "; => ж",
                                ": => Ж",
                                ", => б",
                                "< => Б",
                                ". => Ю",
                                "> => ю"
                            ],
                        ]
                    ],
                    "analyzer" => [
                        "ru_RU_index_char" => [
                            "char_filter" => [
                                "ru_en_key"
                            ],
                            'type' => 'custom',
                            "tokenizer" => "edge_ngram",
                            "filter" => [
                                "lowercase",
                                "russian_stop",
                                "russian_keywords",
                                "ru_RU",
                            ]
                        ],
                        "ru_RU_index" => [
                            'type' => 'custom',
                            "tokenizer" => "edge_ngram",
                            "filter" => [
                                "lowercase",
                                "russian_stop",
                                "russian_keywords",
                                "ru_RU",
                            ]
                        ],
                        "ru_RU_search_char" => [
                            "char_filter" => [
                                "ru_en_key"
                            ],
                            "tokenizer" => "standard",
                            "filter" => [
                                "lowercase",
                                "russian_stop",
                                "russian_keywords",
                                "ru_RU",
                            ]
                        ],
                        "ru_RU_search" => [
                            "tokenizer" => "standard",
                            "filter" => [
                                "lowercase",
                                "russian_stop",
                                "russian_keywords",
                                "ru_RU",
                            ]
                        ],
                        "en_US_ru_RU_index_char" => [
                            "char_filter" => [
                                "ru_en_key"
                            ],
                            'type' => 'custom',
                            "tokenizer" => "edge_ngram",
                            "filter" => [
                                "english_possessive_stemmer",
                                "lowercase",
                                "english_stop",
                                "russian_stop",
                                "stop",
                                "english_keywords",
                                "russian_keywords",
                                "en_US",
                                "ru_RU",
                            ]
                        ],
                        "en_US_ru_RU_index" => [
                            'type' => 'custom',
                            "tokenizer" => "edge_ngram",
                            "filter" => [
                                "english_possessive_stemmer",
                                "lowercase",
                                "english_stop",
                                "russian_stop",
                                "stop",
                                "english_keywords",
                                "russian_keywords",
                                "en_US",
                                "ru_RU",
                            ]
                        ],
                        "en_US_ru_RU_search_char" => [
                            "char_filter" => [
                                "ru_en_key"
                            ],
                            "tokenizer" => "standard",
                            "filter" => [
                                "english_possessive_stemmer",
                                "lowercase",
                                "english_stop",
                                "russian_stop",
                                "stop",
                                "english_keywords",
                                "russian_keywords",
                                "en_US",
                                "ru_RU",
                            ]
                        ],
                        "en_US_ru_RU_search" => [
                            "tokenizer" => "standard",
                            "filter" => [
                                "english_possessive_stemmer",
                                "lowercase",
                                "english_stop",
                                "russian_stop",
                                "stop",
                                "english_keywords",
                                "russian_keywords",
                                "en_US",
                                "ru_RU",
                            ]
                        ],
                        'shingle' => [
                            'type' => 'custom',
                            "tokenizer" => "standard",
                            "filter" => [
                                "shingle",
                                "lowercase",
                                "stop",
                            ],
                        ],
                    ],
                    "filter" => [
                        'shingle' => [
                            'type' => 'shingle',
                            'min_gram_size' => 2,
                            'max_gram_size' => 4,
                        ],
                        'gram' => [
                            'type' => 'nGram',
                            'min_gram' => 3,
                            'max_gram' => 10,
                        ],
                        'edge_gram' => [
                            'type' => 'edge_ngram',
                            'min_gram' => 2,
                            'max_gram' => 10,
                        ],
                        'ru_RU' => [
                            'type' => 'hunspell',
                            'language' => 'ru_RU',
                        ],
                        'en_US' => [
                            'type' => 'hunspell',
                            'language' => 'en_US',
                        ],
                        'custom_word_delimiter_graph' => [
                            'type' => 'word_delimiter_graph',
                            'generate_word_parts' => true,
                            'generate_number_parts' => true,
                            'catenate_words' => true,
                            'catenate_numbers' => false,
                            'catenate_all' => true,
                            'split_on_case_change' => true,
                            'preserve_original' => true,
                            'split_on_numerics' => true,
                            'adjust_offsets' => false,  //
                        ],
                        'split' => [
                            'type' => 'multiplexer',
                            'filters' => [
                                'custom_word_delimiter_graph,lowercase',
                            ],
                        ],
                        'russian_stop' => [
                            'type' => 'stop',
                            'stopwords' => '_russian_',
                            'ignore_case' => true
                        ],
                        "russian_keywords" => [
                            "type" =>       "keyword_marker",
                            "keywords" =>   ["пример"]
                        ],
                        "english_stop" => [
                            "type" =>       "stop",
                            "stopwords" =>  "_english_",
                            'ignore_case' => true
                        ],
                        "english_keywords" => [
                            "type" =>       "keyword_marker",
                            "keywords" =>   ["example"]
                        ],
                        "english_possessive_stemmer" => [
                            "type" =>       "stemmer",
                            "language" =>   "possessive_english"
                        ],
                    ],
                ],
            ],
            'mappings' => [
                'properties' => [
                    'full_title' => [
                        'type' => 'text',
                        'fields' => [
                            'without_ru_en' => [
                                'type' => 'text',
                                'analyzer' => 'en_US_ru_RU_index',
                                'search_analyzer' => 'en_US_ru_RU_search'
                            ],
                            'with_ru_en' => [
                                'type' => 'text',
                                'analyzer' => 'en_US_ru_RU_index_char',
                                'search_analyzer' => 'en_US_ru_RU_search_char'
                            ],
                            'shingle' => [
                                'type' => 'text',
                                'analyzer' => 'shingle',
                            ],
                        ],
//                        'analyzer' => 'en_US_ru_RU_index',
//                        'search_analyzer' => 'en_US_ru_RU_search'
                    ],
                    'slug' => [
                        'type' => 'keyword',
                    ],
                    'status' => [
                        'properties' => [
                            'key' => [
                                'type' => 'integer',
                            ],
                            'slug' => [
                                'type' => 'keyword',
                            ],
                            'title' => [
                                'type' => 'keyword',
                            ],
                        ],
                    ],
                    'brand' => [
                        'properties' => [
                            'slug' => [
                                'type' => 'keyword',
                            ],
                            'country' => [
                                'type' => 'keyword',
                            ],
                            'name' => [
                                'type' => 'keyword',
                                'fields' => [
                                    'without_ru_en' => [
                                        'type' => 'text',
                                        'analyzer' => 'en_US_ru_RU_index',
                                        'search_analyzer' => 'en_US_ru_RU_search'
                                    ],
                                    'with_ru_en' => [
                                        'type' => 'text',
                                        'analyzer' => 'en_US_ru_RU_index_char',
                                        'search_analyzer' => 'en_US_ru_RU_search_char'
                                    ],
                                    'shingle' => [
                                        'type' => 'text',
                                        'analyzer' => 'shingle',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'categories' => [
                        'type' => 'nested',
                        'properties' => [
                            'id' => [
                                'type' => 'integer',
                            ],
                            'slug' => [
                                'type' => 'keyword',
                            ],
                            'name' => [
                                'type' => 'keyword',
                            ],
                        ],
                    ],
                    'variations' => [
                        'type' => 'nested',
                        'properties' => [
                            'id' => [
                                'type' => 'integer',
                            ],
                            'price' => [
                                'type' => 'integer',
                            ],
                            'previous_price' => [
                                'type' => 'integer',
                            ],
                            'price_in_rub' => [
                                'type' => 'long',
                            ],
                            'is_show_price' => [
                                'type' => 'integer',
                            ],
                            'in_stock' => [
                                'type' => 'integer',
                            ],
                            'is_hot' => [
                                'type' => 'integer',
                            ],
                            'stock_type' => [
                                'type' => 'keyword',
                            ],
                            'type' => [
                                'properties' => [
                                    'slug' => [
                                        'type' => 'keyword',
                                    ],
                                    'title' => [
                                        'type' => 'keyword',
                                    ],
                                ]
                            ],
                            'status' => [
                                'properties' => [
                                    'key' => [
                                        'type' => 'integer',
                                    ],
                                    'slug' => [
                                        'type' => 'keyword',
                                    ],
                                    'title' => [
                                        'type' => 'keyword',
                                    ],
                                ],
                            ],
                            'popular_score' => [
                                'type' => 'integer',
                            ],
                        ]
                    ],
                    'properties' => [
                        'type' => 'nested',
                        'properties' => [
                            'key' => [
                                'type' => 'integer',
                            ],
                            'name' => [
                                'type' => 'keyword',
                            ],
                            'slug' => [
                                'type' => 'keyword',
                            ],
                            'slug_number' => [
                                'type' => 'integer',
                            ],
                            'value' => [
                                'type' => 'keyword',
                            ],
                            'aggregation' => [
                                'type' => 'keyword',
                            ],
                        ],
                    ],
                ],
            ]
        ]
    ]
];
