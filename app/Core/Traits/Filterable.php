<?php

namespace App\Core\Traits;


trait Filterable{

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

}
