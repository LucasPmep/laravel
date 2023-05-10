<?php

namespace App\Pipes\People;


class PaginateFilter
{
    public function handle($query, \Closure $next)
    {
        $query->paginate(5);
        
        
        return $next($query);
    }
}