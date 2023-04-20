<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Civility;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
    use HasFactory;

    protected $casts = [];

    protected $fillable = ['lastname', 'firstname', 'email', 'phone'];

    public function civility()
    {
        return $this->belongsTo(Civility::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function departements()
    {
        return $this->belongsToMany(Departement::class);
    }
}