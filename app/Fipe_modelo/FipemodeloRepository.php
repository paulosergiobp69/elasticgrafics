<?php

namespace App\Fipe_modelo;

//use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection;

interface FipemodeloRepository
{
    public function search(string $query = ''): Collection;
//    public function search(string $query = '');
    public function search_modelo_grafico(string $modelo_cod_fipe, string $ano_modelo ): Collection;

}
