<?php


namespace App\Http\Resources;


use App\Facades\Elasticsearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Traits\Searchable;

class IndexCollection extends Collection
{
    public static int $entriesToSendToElasticSearchInOneGo = 500;

    public function addToIndex(string $indexName)
    {
        if ($this->isEmpty()) {
            return null;
        }

        $result = new \stdClass;

        $all = $this->all();
        $iteration = 0;
        do {
            $chunk = array_slice($all, (0 + ($iteration * static::$entriesToSendToElasticSearchInOneGo)),  static::$entriesToSendToElasticSearchInOneGo);

            $params = array();

            /** @var  Model[]|Searchable[] $chunk */
            foreach ($chunk as $item) {
                $params['body'][] = array(
                    'index' => array(
                        '_id' => $item->getKey(),
                        '_type' => $item->getSearchType(),
                        '_index' => $indexName,
                    ),
                );

                $params['body'][] = $item->toSearchArray();
            }

            $result = Elasticsearch::bulk($params);

            if ( (array_key_exists('errors', $result) && $result['errors'] != false ) || (array_key_exists('Message', $result) && stristr('Request size exceeded', $result['Message']) !== false)) {
                break;
            }

            unset($chunk, $params);

            ++$iteration;
        } while (count($all) > ($iteration * static::$entriesToSendToElasticSearchInOneGo) );

        return $result;
    }
}
