<?php

namespace Modules\Category\Indices;

use Modules\Category\Http\Resources\Index\CategorySearchResource;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Search\Services\BaseIndex;

class CategoryIndex extends BaseIndex
{
    public function name(): string
    {
        return "categories";
    }

    public function repository(): string
    {
        return CategoryRepository::class;
    }

    public function resource(): string
    {
        return CategorySearchResource::class;
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
                        "stop",
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
                        "stop",
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
                        "stop",
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
                        "stop",
                        "russian_keywords",
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
                        "my_phonetic_russian",
                        "my_phonetic_cyrillic",
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
                    'min_gram_size' => 1,
                    'max_gram_size' => 4,
                ],
                'ru_RU' => [
                    'type' => 'hunspell',
                    'language' => 'ru_RU',
                ],
                'synonyms' => [
                    'type' => 'synonym',
                    'synonyms_path' => 'analysis/synonyms.txt',
                ],
                'my_phonetic_cyrillic' => [
                    'type' => 'phonetic',
                    'encoder' => 'beider_morse',
                    'rule_type' => 'approx',
                    'name_type' => 'generic',
                    'languageset' => ["cyrillic"],
                ],
                'my_phonetic_russian' => [
                    'type' => 'phonetic',
                    'encoder' => 'beider_morse',
                    'rule_type' => 'approx',
                    'name_type' => 'generic',
                    'languageset' => ["russian"],
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
                    'split_on_numerics' => false,
                    'adjust_offsets' => false,  //
                ],
                'split' => [
                    'type' => 'multiplexer',
                    'filters' => [
                        'custom_word_delimiter_graph,lowercase',
                        'lowercase,synonyms',
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
            ],
        ];
    }

    public function mappings(): array
    {
        return [
            'properties' => [
                'name' => [
                    'type' => 'text',
                    'fields' => [
                        'with_ru_en' => [
                            'type' => 'text',
                            'analyzer' => 'ru_RU_index_char',
                            'search_analyzer' => 'ru_RU_search_char'
                        ],
                        'without_ru_en' => [
                            'type' => 'text',
                            'analyzer' => 'ru_RU_index',
                            'search_analyzer' => 'ru_RU_search'
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
                'slug' => [
                    'type' => 'keyword',
                ],
            ],
        ];
    }

}
