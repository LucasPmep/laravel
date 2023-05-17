<?php

namespace App\Pipes\People;


class QueryFilter
{
    public function handle($query, \Closure $next)
    {
        $query->when(request()->has('q'), function ($query) {
            if (request('q') != null) {
                $q = strval(request('q')); 
                $query->where('firstname', 'like', '%' . $q . '%');
                $query->orWhere('lastname', 'like', '%' . $q . '%');
            }
        });
        return $next($query);
    }
}