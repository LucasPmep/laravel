<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activitysector extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function Companies()
    {
        return $this->belongsToMany(Company::class);
    }
}