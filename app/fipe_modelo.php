<?php

namespace App;

use App\Search\Searchable;
use Illuminate\Database\Eloquent\Model;

class fipe_modelo extends Model
{
    use Searchable;
    protected $table = 'fipe_modelo';
    //
}
