<?php

namespace App\Pipes\People;


class CivilityFilter
{
    public function handle($query, \Closure $next)
    {
        $query->when(request()->has('civi'), function ($query) {
            if (request('civi') != null) {
                $civility = explode(',', request('civi')); 
                $query->whereIn('civility_id', $civility);
            }
        });
        return $next($query);
    }
}