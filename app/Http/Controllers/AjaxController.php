<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fipe_modelo\FipemodeloRepository;
use App\Fipe_modelo\ElasticsearchRepository;


class AjaxController extends Controller
{
    public function post(Request $request, FipemodeloRepository $repository){

        $modeloFipe = $request->input('modelo_cod_fipe');
        $anoFipe = $request->input('ano_modelo');  

        $fipe_modelos = array();
        $modelos = array();
        $modelos[0] =  '.Meses';
        $ano = 0;
        $linha = 1;

        $elastics = env('ELASTICSEARCH_ENABLED');
        if($elastics){
            $fipe_modelos =  $repository->search((string) request('q'));

            //foreach ($fipe_modelos->_sourcecotacao as $arr) {
            foreach ($fipe_modelos as $key => $value) {
                foreach ($value as $i => $valor) {
                       $fipes = json_decode(json_encode($valor),TRUE);
                }
            }

            foreach($fipes['cotacao'] as $cotacao) 
            {
                $ano = date('Y', strtotime($cotacao['data-referencia']));
                if (!in_array($ano, $modelos)) { 
                    $modelos[$linha] = $ano;
                    $linha++;
                }
                if($linha > 3){
                    break;
                }
            }
           
            sort($modelos);
            $ano = $modelos;
            $inicio = 0;
            $status = 'Usado';
    
            foreach ($ano as $key => $val) {
                foreach($fipes['cotacao'] as $fipe_modelo){
                    if($status == $fipe_modelo['status']){
                        $mes_cotacao = date('m', strtotime($fipe_modelo['data-referencia']));
                        $valor_veiculo = 0;
                        $valor_veiculo = floatval(str_replace(',','.',str_replace('.','',substr(trim($fipe_modelo['valor']),2))));
                        if(($inicio == 0) && ($mes_cotacao == 1)){
                            //$modelos[$linha] = $fipe_modelo->cotacao_valor.'   -    '.$fipe_modelo->ref_date;
                            $modelos[$linha] = $valor_veiculo == 0 ? NULL : $valor_veiculo;
                            $inicio = 1;
                        }else{
                            if($inicio == 0){
                                for ($i = 1; $i < $mes_cotacao; $i++) {
                                    $modelos[$linha] = NULL; //.'   -    '.$fipe_modelo->ref_date;
                                    $linha++;
                                } 
                                $modelos[$linha] = $valor_veiculo == 0 ? NULL : $valor_veiculo ;//.'   -    '.$fipe_modelo->ref_date;
                                $inicio = 1;
                            }else{
                                $modelos[$linha] = $valor_veiculo == 0 ? NULL : $valor_veiculo;//.'   -    '.$fipe_modelo->ref_date;
                            }
                        }
                        $linha++;
        
                    }
                }    
            }
    
        }else{
            // bd
            $fipe_modelos = $repository->search_modelo_grafico($modeloFipe, $anoFipe);

            foreach ($fipe_modelos as $fipe_modelo) {
                $ano = date('Y', strtotime($fipe_modelo->ref_date));
                if (!in_array($ano, $modelos)) { 
                   // print_r('data:'.$fipe_modelo->ref_date.' ano:'.$ano);
                    $modelos[$linha] = $ano;
                    $linha++;
                }
                if($linha > 3){
                    break;
                }
            }
           
            if(count($modelos) < 4){
                for($i = count($modelos)+1; $i <= 4;$i++){
                    $modelos[$linha] = '';
                    $linha++;
                }
            }

            sort($modelos);
            $ano = $modelos;
            $inicio = 0;
            $status = 'Usado';


            foreach ($ano as $key => $val) {
                foreach ($fipe_modelos as $fipe_modelo) {
                    if($status == $fipe_modelo->status){
                        $mes_cotacao = date('m', strtotime($fipe_modelo->ref_date));
                        if(($inicio == 0) && ($mes_cotacao == 1)){
                            //$modelos[$linha] = $fipe_modelo->cotacao_valor.'   -    '.$fipe_modelo->ref_date;
                            $modelos[$linha] = floatval($fipe_modelo->cotacao_valor) == 0 ? NULL : floatval($fipe_modelo->cotacao_valor);
                            $inicio = 1;
                        }else{
                            if($inicio == 0){
                                for ($i = 1; $i < $mes_cotacao; $i++) {
                                    $modelos[$linha] = NULL; //.'   -    '.$fipe_modelo->ref_date;
                                    $linha++;
                                } 
                                $modelos[$linha] = floatval($fipe_modelo->cotacao_valor) == 0 ? NULL : floatval($fipe_modelo->cotacao_valor) ;//.'   -    '.$fipe_modelo->ref_date;
                                $inicio = 1;
                            }else{
                                $modelos[$linha] = floatval($fipe_modelo->cotacao_valor) == 0 ? NULL : floatval($fipe_modelo->cotacao_valor);//.'   -    '.$fipe_modelo->ref_date;
                            }
                        }
                        $linha++;
        
                    }
                }    
            }
    
        }


        $modelos[0] = 'Meses';

        if(count($modelos) < 12){
            $ano_anterior  = (int) $anoFipe-1;
            $ano_posterior = (int) $anoFipe+1;

            $data = array('Meses',$ano_anterior, $anoFipe, $ano_posterior);
            array_push($data, array(NULL, NULL, NULL));
            array_push($data, array(NULL, NULL, NULL));
            array_push($data, array(NULL, NULL, NULL));
            array_push($data, array(NULL, NULL, NULL));
            array_push($data, array(NULL, NULL, NULL));
            array_push($data, array(NULL, NULL, NULL));
            array_push($data, array(NULL, NULL, NULL));
            array_push($data, array(NULL, NULL, NULL));
            array_push($data, array(NULL, NULL, NULL));
            array_push($data, array(NULL, NULL, NULL));
            array_push($data, array(NULL, NULL, NULL));
            array_push($data, array(NULL, NULL, NULL));

        }else{
            $data = array($modelos[0],$modelos[1],$modelos[2],$modelos[3]);
            array_push($data, array($modelos[4], $modelos[16], $modelos[28]));
            array_push($data, array($modelos[5], $modelos[17], $modelos[29]));
            array_push($data, array($modelos[6], $modelos[18], $modelos[30]));
            array_push($data, array($modelos[7], $modelos[19], $modelos[31]));
            array_push($data, array($modelos[8], $modelos[20], $modelos[32]));
            array_push($data, array($modelos[9], $modelos[21], $modelos[33]));
            array_push($data, array($modelos[10], $modelos[22], $modelos[34]));
            array_push($data, array($modelos[11], $modelos[23], $modelos[35]));
            array_push($data, array($modelos[12], $modelos[24], $modelos[36]));
            array_push($data, array($modelos[13], $modelos[25], $modelos[37]));
            array_push($data, array($modelos[14], $modelos[26], $modelos[38]));
            array_push($data, array($modelos[15], $modelos[27], $modelos[39]));
    
        }

/*
        dd($modelos);

        $data = array('Meses','1969','1970','1971');
        array_push($data, array(33, 25, 41));
        array_push($data, array(10, 15, 20));
        array_push($data, array(10, 15, 20));
        array_push($data, array(10, 15, 20));
        array_push($data, array(10, 15, 20));
        array_push($data, array(10, 15, 20));
        array_push($data, array(10, 15, 20));
        array_push($data, array(10, 15, 20));
        array_push($data, array(10, 15, 20));
        array_push($data, array(10, 15, 20));
        array_push($data, array(10, 15, 20));
        array_push($data, array(10, 15, 20));
*/

        return $data;     
    }
    

}


