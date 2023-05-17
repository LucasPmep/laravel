<?php

namespace App\Pipes\Companies;


class QueryFilter
{
    public function handle($query, \Closure $next)
    {
        $query->when(request()->has('q'), function ($query) {
            if (request('q') != null) {
                $q = strval(request('q')); 
                $query->where('name', 'like', '%' . $q . '%');
            }
        });
        return $next($query);
    }
}