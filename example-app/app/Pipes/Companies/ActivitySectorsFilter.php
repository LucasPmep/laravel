<?php

namespace App\Pipes\Companies;


class ActivitySectorsFilter
{
    public function handle($query, \Closure $next)
    {
        $query->when(request()->has('act'), function ($query) {
            if (request('act') != null) {
                $activities = explode(',', request('act'));
                $query->join('activitysector_company', function ($join) {
                    $join->on('companies.id', '=', 'activitysector_company.company_id');
                })->whereIn('activitysector_company.activitysector_id', $activities)->distinct(['companies.id']);
                
            }
        });
        return $next($query);
    }
}