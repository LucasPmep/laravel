<?php

namespace App\Pipes;


class IncrementFilter
{
    public function handle($a, \Closure $next)
    {
        if ($a) {
            $a = 'bhusdfihsidlhf';
        } else {
            $a = 'b';
        }
        return $next($a);
    }
}