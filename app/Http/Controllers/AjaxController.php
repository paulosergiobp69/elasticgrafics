<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fipe_modelo\FipemodeloRepository;
use App\Fipe_modelo\ElasticsearchRepository;
error_reporting(E_ALL ^ E_NOTICE);


class AjaxController extends Controller
{
    public function post(Request $request, FipemodeloRepository $repository){

        $modeloFipe = $request->input('modelo_cod_fipe');
        $anoFipe = $request->input('ano_modelo');  

       // dd($modeloFipe.'-'.$anoFipe);

//        $fipe_modelos = $repository->search((string) request('q'));
        $fipe_modelos = array();

        $elastics = env('ELASTICSEARCH_ENABLED');
       // dd($elastics.'-'.$modeloFipe.'-'.$anoFipe);
        if(!$elastics){
            $fipe_modelos =  $repository->search((string) request('q'));
        }else{
            $fipe_modelos = $repository->search_modelo_grafico($modeloFipe, $anoFipe);
        }
        $modelos = array();
        $modelos[0] =  '.Meses';
        $ano = 0;
        $linha = 1;
        $i = 0;
       dd($fipe_modelos->_source['cotacao']);

        foreach ($fipe_modelos->_source['cotacao'] as $fipe_modelo) {
            
            $ano = date('Y', strtotime($fipe_modelo->_source['cotacao'][$i]['data-referencia']));
            
            if (!in_array($ano, $modelos)) { 
                $modelos[$linha] = $ano;
                $linha++;
            }
            echo $ano.'-';
            print_r($modelos);

            $i++;
        }
        

        sort($modelos);
        $ano = $modelos;

        //dd($ano);
        $inicio = 0;
        $i = 0;
        $status = 'Usado';

        //dd($modelos);

        foreach ($ano as $key => $val) {
            foreach ($fipe_modelos as $fipe_modelo) {
                dd($fipe_modelo);
                //dd($fipe_modelo->_source['cotacao'][$i]['status']);
                $fipe_modelo_status = $fipe_modelo->_source['cotacao'][$i]['status'];
                //dd($fipe_modelo->_source['cotacao'][$i]['status']);
                //echo $status.'-'.$fipe_modelo_status.'-'.$fipe_modelo->_source['cotacao'][$i]['ref-id'];
                //dd($fipe_modelo);
                if($status === $fipe_modelo_status){
                    $mes_cotacao = date('m', strtotime($fipe_modelo->_source['cotacao'][$i]['data-referencia']));
                    if(($inicio == 0) && ($mes_cotacao == 1)){
                        //$modelos[$linha] = $fipe_modelo->cotacao_valor.'   -    '.$fipe_modelo->ref_date;
                        $modelos[$linha] = floatval($fipe_modelo->_source['cotacao'][$i]['valor']) == 0 ? NULL : floatval($fipe_modelo->_source['cotacao'][$i]['valor']);
                        $inicio = 1;
                    }else{
                        if($inicio == 0){
                            for ($i = 1; $i < $mes_cotacao; $i++) {
                                $modelos[$linha] = NULL; //.'   -    '.$fipe_modelo->ref_date;
                                $linha++;
                            } 
                            $modelos[$linha] = floatval($fipe_modelo->_source['cotacao'][$i]['valor']) == 0 ? NULL : floatval($fipe_modelo->_source['cotacao'][$i]['valor']) ;//.'   -    '.$fipe_modelo->ref_date;
                            $inicio = 1;
                        }else{
                            $modelos[$linha] = floatval($fipe_modelo->_source['cotacao'][$i]['valor']) == 0 ? NULL : floatval($fipe_modelo->_source['cotacao'][$i]['valor']);//.'   -    '.$fipe_modelo->ref_date;
                        }
                    }
                    $linha++;
    
                }
                $i++;
            }    
        }

        dd($modelos);

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


