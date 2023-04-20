<?php

namespace App\Models;

use App\Models\Person;
use App\Models\Activitysector;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'postalcode', 'city', 'CA'];

    public function people()
    {
        return $this->hasMany(Person::class);
    }

    public function Activitysectors()
    {
        return $this->belongsToMany(Activitysector::class);
    }
}