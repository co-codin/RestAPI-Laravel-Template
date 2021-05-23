<?php


namespace App\Http\Resources;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Search\Concerns\Searchable;
use Modules\Search\Facades\ElasticSearch;

class IndexCollection extends Collection
{
    public static int $entriesToSendToElasticSearchInOneGo = 500;

    public function addToIndex(string $indexName)
    {
        if ($this->isEmpty()) {
            return null;
        }

        // Use an stdClass to store result of elasticsearch operation
        $result = new \stdClass;

        // Iterate according to the amount configured, and put that iteration's worth of records into elastic search
        // This is done so that we do not exceed the maximum request size
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

            $result = ElasticSearch::bulk($params);

            // Check for errors
            if ( (array_key_exists('errors', $result) && $result['errors'] != false ) || (array_key_exists('Message', $result) && stristr('Request size exceeded', $result['Message']) !== false)) {
                break;
            }

            unset($chunk, $params);

            ++$iteration;
        } while (count($all) > ($iteration * static::$entriesToSendToElasticSearchInOneGo) );

        return $result;
    }
}
