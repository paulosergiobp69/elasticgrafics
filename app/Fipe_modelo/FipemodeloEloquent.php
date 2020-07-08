<?php

namespace App\Fipe_modelo;

use App\fipe_modelo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;



class FipemodeloEloquent implements FipemodeloRepository
{   
    /** @var \Elasticsearch\Client */
    private $elasticsearch;
    
    public function search(string $query = ''): Collection
    {
            if($query == ''){
                $query = '004384-2';     
            }
            return fipe_modelo::query()
            ->join('fipe_cotacao', 'fipe_modelo.modelo_cod_fipe', '=', 'fipe_cotacao.modelo_cod_fipe')
            ->select('fipe_modelo.modelo_cod_fipe','fipe_modelo.modelo_desc','fipe_modelo.tipo_id', 'fipe_cotacao.ano_modelo')
            ->where('fipe_modelo.modelo_desc', 'like', "%{$query}%")
//            ->orWhere('fipe_modelo.modelo_cod_fipe', 'like', "%{$query}%")
            ->groupBy('fipe_modelo.modelo_cod_fipe','fipe_modelo.modelo_desc','fipe_modelo.tipo_id', 'fipe_cotacao.ano_modelo')            
            ->get();
    }


    public function search_modelo_grafico(string $modelo_cod_fipe, String $ano_modelo): Collection
    {
       // $modelo_cod_fipe = '004384-2';
        //$ano_modelo = '2015';
        $ano_anterior  =  (int) $ano_modelo -1;
        $ano_posterior =  (int) $ano_modelo +1;

        return fipe_modelo::query()
        ->join('fipe_cotacao', 'fipe_modelo.modelo_cod_fipe', '=', 'fipe_cotacao.modelo_cod_fipe')
        ->join('fipe_combustivel', 'fipe_combustivel.combustivel_id', '=', 'fipe_cotacao.combustivel_id')
        ->join('fipe_mes_referencia', 'fipe_mes_referencia.ref_id', '=', 'fipe_cotacao.ref_id')
        ->join('fipe_marca', 'fipe_marca.marca_id', '=', 'fipe_modelo.marca_id')
        ->select(DB::raw(" case  when ((fipe_cotacao.ano_modelo_desc ilike '%Zero%') or (trim(fipe_cotacao.ano_modelo_desc) = '32000 Gasolina')) then 'Novo' else  'Usado' end as status"),
                 'fipe_mes_referencia.ref_date',
                 'fipe_cotacao.ano_modelo',
                 'fipe_modelo.modelo_cod_fipe',
                 'fipe_combustivel.combustivel_desc',       
                 'fipe_modelo.modelo_desc','fipe_modelo.tipo_id',
                 'fipe_marca.marca_desc', 'fipe_mes_referencia.ref_desc',
                 DB::raw("case when fipe_combustivel.combustivel_id = 1 then 'G' when fipe_combustivel.combustivel_id = 2 then 'A' when fipe_combustivel.combustivel_id = 3 then 'D' else 'N/I' end as SiglaCombustivel"),
                 'fipe_modelo.tipo_id',
                 'fipe_cotacao.cotacao_valor',
                 'fipe_mes_referencia.ref_id',
                 'fipe_cotacao.id')
        ->where('fipe_modelo.modelo_cod_fipe', '=', "{$modelo_cod_fipe}")
        ->Where('fipe_cotacao.ano_modelo', '=', "{$ano_modelo}")
        ->whereYear('fipe_mes_referencia.ref_date', '>=',"{$ano_anterior}")
        ->whereYear('fipe_mes_referencia.ref_date', '<=',"{$ano_posterior}")
        ->groupBy('status','fipe_mes_referencia.ref_date', 'fipe_cotacao.ano_modelo', 
                  'fipe_modelo.modelo_cod_fipe','fipe_combustivel.combustivel_desc',
                  'fipe_modelo.modelo_desc','fipe_modelo.tipo_id','fipe_marca.marca_desc',
                  'fipe_mes_referencia.ref_desc', 'fipe_marca.marca_desc',
                  'fipe_combustivel.combustivel_id',
                  'fipe_modelo.tipo_id', 'fipe_cotacao.cotacao_valor',
                  'fipe_mes_referencia.ref_id','fipe_cotacao.id')
        ->orderBy('fipe_mes_referencia.ref_date', 'ASC')
        ->get() ;

    }

    /*
    public function search_modelo_grafico_elastics(string $modelo_cod_fipe, String $ano_modelo): Collection
    {
       // $modelo_cod_fipe = '004384-2';
        //$ano_modelo = '2015';
        $ano_anterior  =  (int) $ano_modelo -1;
        $ano_posterior =  (int) $ano_modelo +1;

        curl --location --request POST 'http://localhost:9200/modelo_fipe/_search' \
        --header 'Content-Type: application/json' \
        --data-raw '{
          "query": {
            "multi_match" : {
              "query":    "FlexPower 004384-2 2018",
              "fields": [ "searchable_field" ] 
            }
          }
        }

            $items = $this->elasticsearch->search([
                'index' =>  "modelo_fipe", 
                'type' => "_doc",
                'body' => [
                    'query' => [
                        'multi_match' => [
                            'fields' => ['CodigoFipe','modelo_desc', 'AnoModelo'],
                            'query' => $query,
                        ],
                    ],
                ],
            ]);
    
            dd($items);
            return $items;
    

    }
*/


}