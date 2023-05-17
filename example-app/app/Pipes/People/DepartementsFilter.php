<?php

namespace App\Pipes\People;


class DepartementsFilter
{
    public function handle($query, \Closure $next)
    {
        // here we want to filter on each departements that are selected

        $query->when(request()->has('dep'), function ($query) {
            if (request('dep') != null) {
                $departements = explode(',', request('dep'));
                $query->join('departement_person', function ($join) {
                    $join->on('people.id', '=', 'departement_person.person_id');
                })->whereIn('departement_person.departement_id', $departements)->distinct(['people.id']);
                
            }
        });

        
        return $next($query);
    }
}