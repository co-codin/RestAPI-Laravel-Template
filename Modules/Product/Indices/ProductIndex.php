<?php

namespace Modules\Product\Indices;

use Modules\Product\Http\Resources\Index\ProductSearchResource;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\ProductRepository;
use Modules\Search\Services\BaseIndex;

class ProductIndex extends BaseIndex
{
    public function name(): string
    {
        return (new Product())->getSearchIndex();
    }

    public function repository(): string
    {
        return ProductRepository::class;
    }

    public function resource(): string
    {
        return ProductSearchResource::class;
    }

    public function settings(): array
    {
        return [
            'number_of_shards' => 2,
            'number_of_replicas' => 0,
            'index' => [
                'max_ngram_diff' => 10
            ],
            'analysis' => $this->analysis()
        ];
    }

    protected function analysis()
    {
        return [
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
                        "split",        //synonyms, custom_word_delimiter_graph, latin, phonetic
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
                        "split",        //synonyms, custom_word_delimiter_graph, latin, phonetic
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
                        "split",        //synonyms, custom_word_delimiter_graph, latin, phonetic
                        "russian_stop",
                        "russian_keywords",
                        "ru_RU",
                    ]
                ],
                "ru_RU_search" => [
                    "tokenizer" => "standard",
                    "filter" => [
                        "lowercase",
                        "split",        //synonyms, custom_word_delimiter_graph, latin, phonetic
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
                        "split",        //synonyms, custom_word_delimiter_graph, latin, phonetic
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
                        "split",        //synonyms, custom_word_delimiter_graph, latin, phonetic
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
                        "split",        //synonyms, custom_word_delimiter_graph, latin, phonetic
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
                        "split",        //synonyms, custom_word_delimiter_graph, latin, phonetic
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
                'phonetic' => [
                    "tokenizer" => "standard",
                    "filter" => [
                        "lowercase",
                        "stop",
                    ],
                ],
            ],
            'tokenizer' => [
                'edge_ngram' => [
                    'type' => 'edge_ngram',
                    'min_gram' => 2,
                    'max_gram' => 12,
                    'token_chars' => [
                        'letter',
                        'digit',
                        'punctuation',
                        'initial_quote_punctuation',
                        'dash_punctuation',
                        'math_symbol',
                    ],
                ]
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
                'myLatinTransform' => [
                    'type' => 'icu_transform',
                    'id' => 'Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC',
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
//                                'my_phonetic_english,my_phonetic_cyrillic,lowercase',
                        'myLatinTransform,lowercase',
                        'custom_word_delimiter_graph,lowercase',
                    ],
                ],
                'russian_stop' => [
                    'type' => 'stop',
                    'stopwords' => '_russian_',
                    'ignore_case' => true
                ],
                "russian_keywords" => [
                    "type" => "keyword_marker",
                    "keywords" => ["пример"]
                ],
                "english_stop" => [
                    "type" => "stop",
                    "stopwords" => "_english_",
                    'ignore_case' => true
                ],
                "english_keywords" => [
                    "type" => "keyword_marker",
                    "keywords" => ["example"]
                ],
                "english_possessive_stemmer" => [
                    "type" => "stemmer",
                    "language" => "possessive_english"
                ],
            ],
        ];
    }

    public function mappings(): array
    {
        return [
            'properties' => [
                'full_name' => [
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
                        'phonetic' => [
                            'type' => 'text',
                            'analyzer' => 'phonetic',
                        ],
                    ],
//                        'analyzer' => 'en_US_ru_RU_index',
//                        'search_analyzer' => 'en_US_ru_RU_search'
                ],
                'id' => [
                    'type' => 'integer',
                ],
                'article' => [
                    'type' => 'keyword',
                ],
                'name' => [
                    'type' => 'keyword',
                ],
                'slug' => [
                    'type' => 'keyword',
                ],
                'status' => [
                    'properties' => [
                        'id' => [
                            'type' => 'byte',
                        ],
                        'name' => [
                            'type' => 'keyword',
                        ],
                        'slug' => [
                            'type' => 'keyword',
                        ],
                    ],
                ],
                'warranty' => [
                    'type' => 'integer',
                ],
                'group' => [
                    'type' => 'float',
                ],
                'popular_score' => [
                    'type' => 'byte',
                ],
                'availability_sort_value' => [
                    'type' => 'byte',
                ],
                'brand' => [
                    'properties' => [
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
                                'phonetic' => [
                                    'type' => 'text',
                                    'analyzer' => 'phonetic',
                                ],
                            ],
                        ],
                        'id' => [
                            'type' => 'integer',
                        ],
                        'slug' => [
                            'type' => 'keyword',
                        ],
                        'country_id' => [
                            'type' => 'integer',
                        ],
                        'status' => [
                            'properties' => [
                                'id' => [
                                    'type' => 'byte',
                                ],
                                'name' => [
                                    'type' => 'keyword',
                                ],
                                'slug' => [
                                    'type' => 'keyword',
                                ],
                            ],
                        ],
                    ],
                ],
                'category' => [
                    'properties' => [
                        'id' => [
                            'type' => 'integer',
                        ],
                        'name' => [
                            'type' => 'keyword',
                        ],
                        'slug' => [
                            'type' => 'keyword',
                        ],
                        'status' => [
                            'properties' => [
                                'id' => [
                                    'type' => 'byte',
                                ],
                                'name' => [
                                    'type' => 'keyword',
                                ],
                                'slug' => [
                                    'type' => 'keyword',
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
                        'status' => [
                            'properties' => [
                                'id' => [
                                    'type' => 'byte',
                                ],
                                'name' => [
                                    'type' => 'keyword',
                                ],
                                'slug' => [
                                    'type' => 'keyword',
                                ],
                            ],
                        ],
                    ],
                ],
                'properties' => [
                    'type' => 'nested',
                    'properties' => [
                        'id' => [
                            'type' => 'integer',
                        ],
                        'name' => [
                            'type' => 'keyword',
                        ],
                        'value' => [
                            'type' => 'keyword',
                        ],
                        'value_numeric' => [
                            'type' => 'float',
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
                            'type' => 'long',
                        ],
                        'previous_price' => [
                            'type' => 'long',
                        ],
                        'is_enabled' => [
                            'type' => 'boolean',
                        ],
                        'availability' => [
                            'type' => 'byte',
                        ],
                        'price_in_rub' => [
                            'type' => 'long',
                        ],
                        'is_price_visible' => [
                            'type' => 'byte',
                        ],
                        'is_hot' => [
                            'type' => 'byte',
                        ],
                        'availability_sort_value' => [
                            'type' => 'byte',
                        ],
                        'facets' => [
                            'type' => 'nested',
                            'properties' => [
                                'name' => [
                                    'type' => 'keyword',
                                ],
                                'value' => [
                                    'type' => 'keyword',
                                ],
                                'aggregation' => [
                                    'type' => 'keyword',
                                ],
                            ],
                        ],
                        'numeric_facets' => [
                            'type' => 'nested',
                            'properties' => [
                                'name' => [
                                    'type' => 'keyword',
                                ],
                                'value' => [
                                    'type' => 'float',
                                ],
                            ],
                        ],
                    ],
                ],
                'facets' => [
                    'type' => 'nested',
                    'properties' => [
                        'name' => [
                            'type' => 'keyword',
                        ],
                        'aggregation' => [
                            'type' => 'keyword',
                        ],
                        'value' => [
                            'type' => 'keyword',
                        ],
                        'label' => [
                            'type' => 'keyword',
                        ],
                    ],
                ],
                'numeric_facets' => [
                    'type' => 'nested',
                    'properties' => [
                        'name' => [
                            'type' => 'keyword',
                        ],
                        'value' => [
                            'type' => 'float',
                        ],
                    ],
                ],
            ],
        ];
    }

}
