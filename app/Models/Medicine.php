<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'scientific_name_id',
        'trade_name',
        'manufacturer_name',
        'barcode',
        'type',
        'dose'
    ];


    public function scientificName()
    {
        return $this->belongsTo(ScientificName::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
}
