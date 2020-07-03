<?php

namespace App\Fipe_modelo;

use App\fipe_modelo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FipemodeloEloquent implements FipemodeloRepository
{
    
    public function search(string $query = ''): Collection
    {
            return fipe_modelo::query()
            ->join('fipe_cotacao', 'fipe_modelo.modelo_cod_fipe', '=', 'fipe_cotacao.modelo_cod_fipe')
            ->select('fipe_modelo.modelo_cod_fipe','fipe_modelo.modelo_desc','fipe_modelo.tipo_id', 'fipe_cotacao.ano_modelo')
            ->where('fipe_modelo.modelo_desc', 'like', "%{$query}%")
            ->groupBy('fipe_modelo.modelo_cod_fipe','fipe_modelo.modelo_desc','fipe_modelo.tipo_id', 'fipe_cotacao.ano_modelo')            
            ->get();

    }
}