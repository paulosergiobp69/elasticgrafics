<?php

namespace App\Fipe_modelo;

use App\fipe_modelo;
use Elasticsearch\Client;
use Illuminate\Support\Arr;
//use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection;

class ElasticsearchRepository implements FipemodeloRepository
{
    /** @var \Elasticsearch\Client */
    private $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(string $query = ''):Collection
    {
        
        $items = $this->searchOnElasticsearch($query);
        return $this->buildCollection($items);
    }

    public function search_modelo_grafico(string $modelo_cod_fipe, String $ano_modelo): Collection
    {
      
        $items = $this->searchOnElasticsearch($modelo_cod_fipe, $ano_modelo );

        return $this->buildCollection($items);
    }

    private function searchOnElasticsearch(string $query = ''): array
    {
        //$model = new fipe_modelo;
        $query = 'FlexPower 004384-2 2018';
        $items = $this->elasticsearch->search([
            'index' => "modelo_fipe",  //$model->getSearchIndex(),
            'type' => "_doc", //$model->getSearchType(),
            'body' => [
                'query' => [
                    'bool' =>[
                        'must' =>[
                            [
                               'match'=> [
                                   'searchable_field'=> '2018'
                               ]
                            ],
                            [
                                'match'=>[
                                   'searchable_field'=> 'COBALT'
                                ], 
                            ],
                        ],
                    ],
                ],
            ],
        ]);


//dd($items);

/*---> funcionando:
        $items = $this->elasticsearch->search([
            'index' => "modelo_fipe",  //$model->getSearchIndex(),
            'type' => "_doc", //$model->getSearchType(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['searchable_field'],
                        'query' => $query,
                    ],
                ],
            ],
        ]);
    */    

        
/*
---> funcionando
         $cmd = 'curl --location --request POST "http://localhost:9200/modelo_fipe/_search" \
                    --header "Content-Type: application/json" \
                    --data-raw "{
                    "query": {
                    "multi_match" : {
                        "query":    "FlexPower 004384-2 2018",
                        "fields": [ "searchable_field" ] 
                    }
                }
            }';

            exec($cmd,$items);

            //dd($items);
           // die();
*/
        return $items;
    }



    private function buildCollection(array $items): Collection
    {
/*
        return $items = collect($items)->map(function ($item) {
               // dd($item);
                return (object) $item;
            });
            */


        $ids = Arr::pluck($items['hits']['hits'], '_id');
        return $items = collect($items['hits']['hits'])->map(function ($item) {
               // dd($item);
                return (object) $item;
            });

               
       //return $items;

    }
}
