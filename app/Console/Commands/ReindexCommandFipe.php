<?php

namespace App\Console\Commands;

use App\fipe_modelo;
use Elasticsearch\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReindexCommandFipe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all Fipe_modelo to Elasticsearch';

    /** @var \Elasticsearch\Client */
    private $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        parent::__construct();

        $this->elasticsearch = $elasticsearch;
    }

    public function handle()
    {
        $this->info('Indexing all Fipe_modelo. This might take a while...');

        $result = DB::select("select  case 
        when ((fc.ano_modelo_desc ilike '%Zero%') or (trim(fc.ano_modelo_desc) = '32000 Gasolina')) then 'Novo'
        else  'Usado'
    end as status,
    fmr.ref_date,
    fc.ano_modelo AnoModelo, 
    ''  Autenticacao,
    fm.modelo_cod_fipe,
    INITCAP(fcomb.combustivel_desc) Combustivel,
    timeofday() DataConsulta,
    fmarca.marca_desc Marca,
    fmr.ref_desc as MesReferencia,
    fm.modelo_desc Modelo,
    case  
          when fc.combustivel_id = 1 then 'G' 
          when fc.combustivel_id = 2 then 'A'
          when fc.combustivel_id = 3 then 'D'
      else 'N/I'
      end as SiglaCombustivel	,
    fm.tipo_id as TipoVeiculo,
    fc.cotacao_valor,
    fmr.ref_id ,
    fc.id as cotacao_id,
    'FC' as ref_cotacao_id
  from fipe_modelo fm 
  inner join fipe_cotacao fc on fc.modelo_cod_fipe = fm.modelo_cod_fipe 
  inner join fipe_combustivel fcomb on fcomb.combustivel_id = fc.combustivel_id 
  inner join fipe_mes_referencia fmr on fmr.ref_id = fc.ref_id 
  inner join fipe_marca fmarca on fmarca.marca_id  = fm.marca_id 
  where true 
  and   ((fm.modelo_cod_fipe ='004384-2' and   fc.ano_modelo = '2015') or   
  (fm.modelo_cod_fipe ='004384-2' and   
-                        fc.ano_modelo = '32000'        and 
  EXTRACT(year from fmr.ref_date) between '2014' and '2015'))
  and   fc.combustivel_id = 1
  and   fm.tipo_id = 1
  group by status,fmr.ref_date,fc.ano_modelo, fm.modelo_cod_fipe, 
    fcomb.combustivel_desc, fmarca.marca_desc,
    fmr.ref_desc, fmr.ref_date, fm.modelo_desc, fc.combustivel_id, fm.tipo_id, 
    fc.cotacao_valor, fmr.ref_id, fmr.ref_id, fc.id, ref_cotacao_id
  union 
  select case when fmav.ano_modelo = 32000 then 'Novo'
  else 'Usado'
  end as status,
  fmr.ref_date,
  fmav.ano_modelo AnoModelo, 
  ''  Autenticacao, 
  fmav.modelo_cod_fipe,
  INITCAP(fc.combustivel_desc) Combustivel, 
  timeofday() DataConsulta, 
  fm.marca_desc Marca,
  fmr.ref_desc as MesReferencia,
  fbm.modelo_desc Modelo,
  case  
      when fc.combustivel_id = 1 then 'G' 
      when fc.combustivel_id = 2 then 'A'
      when fc.combustivel_id = 3 then 'D'
      else 'N/I'
  end as SiglaCombustivel,
  fmav.tipo_id as TipoVeiculo,
  fmav.valor as cotacao_valor,
  fmr.ref_id,
  fmav.id as cotacao_id,
  'FMAV' as ref_cotacao_id
  from  fipe_modelo_basico fbm
  inner join fipe_modelo_ano fma on fma.modelo_basico_id = fbm.id
  inner join fipe_modelo_ano_valor fmav on  fmav.modelo_basico_id = fbm.id
  inner join fipe_combustivel fc on fc.combustivel_id = fmav.combustivel_id 
  inner join fipe_marca fm on fm.marca_id  = fmav.marca_id 
  inner join fipe_mes_referencia fmr on fmr.ref_id = fmav.referencia_id 
  where true
  and   ((fmav.modelo_cod_fipe ='004384-2' and   fmav.ano_modelo = '2015') or   
  (fmav.modelo_cod_fipe ='004384-2' and   
    fmav.ano_modelo = 32000        and 
    EXTRACT(year from fmr.ref_date) between '2014' and '2015'))	  
  and   fmav.combustivel_id = 1
  and   fmav.tipo_id = 1
  group by status, fmr.ref_date,fmav.ano_modelo, fmav.modelo_cod_fipe,  
    fc.combustivel_desc, fm.marca_desc,fmr.ref_desc,fmr.ref_id,
    fmr.ref_date,
    fbm.modelo_desc, fc.combustivel_id,  fmav.tipo_id,  fmav.valor, fmr.ref_id,
    cotacao_id, ref_cotacao_id 
  order by 2, 3, 1 ");

/*
        $result = DB::select("select  case 
        when ((fc.ano_modelo_desc ilike '%Zero%') or (trim(fc.ano_modelo_desc) = '32000 Gasolina')) then 'Novo'
        else  'Usado'
    end as status,
    fmr.ref_date,
    fc.ano_modelo AnoModelo, 
    ''  Autenticacao,
    fm.modelo_cod_fipe,
    INITCAP(fcomb.combustivel_desc) Combustivel,
    timeofday() DataConsulta,
    fmarca.marca_desc Marca,
    fmr.ref_desc as MesReferencia,
    fm.modelo_desc Modelo,
    case  
          when fc.combustivel_id = 1 then 'G' 
          when fc.combustivel_id = 2 then 'A'
          when fc.combustivel_id = 3 then 'D'
      else 'N/I'
      end as SiglaCombustivel	,
    fm.tipo_id as TipoVeiculo,
    fc.cotacao_valor,
    fmr.ref_id ,
    fc.id as cotacao_id,
    'FC' as ref_cotacao_id
  from fipe_modelo fm 
  inner join fipe_cotacao fc on fc.modelo_cod_fipe = fm.modelo_cod_fipe 
  inner join fipe_combustivel fcomb on fcomb.combustivel_id = fc.combustivel_id 
  inner join fipe_mes_referencia fmr on fmr.ref_id = fc.ref_id 
  inner join fipe_marca fmarca on fmarca.marca_id  = fm.marca_id 
  where true 
  and   ((fm.modelo_cod_fipe ='004384-2' and   fc.ano_modelo = '2015') or   
  (fm.modelo_cod_fipe ='004384-2' and   
-                        fc.ano_modelo = '32000'        and 
  EXTRACT(year from fmr.ref_date) between '2014' and '2015'))
  and   fc.combustivel_id = 1
  and   fm.tipo_id = 1
  group by status,fmr.ref_date,fc.ano_modelo, fm.modelo_cod_fipe, 
    fcomb.combustivel_desc, fmarca.marca_desc,
    fmr.ref_desc, fmr.ref_date, fm.modelo_desc, fc.combustivel_id, fm.tipo_id, 
    fc.cotacao_valor, fmr.ref_id, fmr.ref_id, fc.id, ref_cotacao_id
  union 
  select case when fmav.ano_modelo = 32000 then 'Novo'
  else 'Usado'
  end as status,
  fmr.ref_date,
  fmav.ano_modelo AnoModelo, 
  ''  Autenticacao, 
  fmav.modelo_cod_fipe,
  INITCAP(fc.combustivel_desc) Combustivel, 
  timeofday() DataConsulta, 
  fm.marca_desc Marca,
  fmr.ref_desc as MesReferencia,
  fbm.modelo_desc Modelo,
  case  
      when fc.combustivel_id = 1 then 'G' 
      when fc.combustivel_id = 2 then 'A'
      when fc.combustivel_id = 3 then 'D'
      else 'N/I'
  end as SiglaCombustivel,
  fmav.tipo_id as TipoVeiculo,
  fmav.valor as cotacao_valor,
  fmr.ref_id,
  fmav.id as cotacao_id,
  'FMAV' as ref_cotacao_id
  from  fipe_modelo_basico fbm
  inner join fipe_modelo_ano fma on fma.modelo_basico_id = fbm.id
  inner join fipe_modelo_ano_valor fmav on  fmav.modelo_basico_id = fbm.id
  inner join fipe_combustivel fc on fc.combustivel_id = fmav.combustivel_id 
  inner join fipe_marca fm on fm.marca_id  = fmav.marca_id 
  inner join fipe_mes_referencia fmr on fmr.ref_id = fmav.referencia_id 
  where true
  and   ((fmav.modelo_cod_fipe ='004384-2' and   fmav.ano_modelo = '2015') or   
  (fmav.modelo_cod_fipe ='004384-2' and   
    fmav.ano_modelo = 32000        and 
    EXTRACT(year from fmr.ref_date) between '2014' and '2015'))	  
  and   fmav.combustivel_id = 1
  and   fmav.tipo_id = 1
  group by status, fmr.ref_date,fmav.ano_modelo, fmav.modelo_cod_fipe,  
    fc.combustivel_desc, fm.marca_desc,fmr.ref_desc,fmr.ref_id,
    fmr.ref_date,
    fbm.modelo_desc, fc.combustivel_id,  fmav.tipo_id,  fmav.valor, fmr.ref_id,
    cotacao_id, ref_cotacao_id 
  order by 2, 3, 1 ");
*/
        //$fipe_modelos = json_decode($result);
        $fipe_modelos = json_decode(json_encode($result), true);
        //$fipe_modelos = get_object_vars($result);

        foreach ($fipe_modelos as $fipe_modelo)
        {
            $this->elasticsearch->index([
                'index' => 'modelo_fipe99',
                'id' => $fipe_modelo['modelo_cod_fipe'],
                'body' => $fipe_modelo,
            ]);

/*
            $this->elasticsearch->index([
                'index' => $fipe_modelo->getSearchIndex(),
                'type' => $fipe_modelo->getSearchType(),
                'id' => $fipe_modelo->getKey(),
                'body' => $fipe_modelo->toSearchArray(),
            ]);*/

            // PHPUnit-style feedback
            $this->output->write('.');
        }

        $this->info("\nDone!");
    }
}
