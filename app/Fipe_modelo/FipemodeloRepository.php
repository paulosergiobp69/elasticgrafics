<?php

namespace App\Fipe_modelo;

use Illuminate\Database\Eloquent\Collection;

interface FipemodeloRepository
{
    public function search(string $query = ''): Collection;

}
