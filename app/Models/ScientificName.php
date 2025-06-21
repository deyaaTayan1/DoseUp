<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScientificName extends Model
{
    protected $fillable = ['name', 'warnings'];

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
}
