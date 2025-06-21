<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['batch_id', 'type', 'description'];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
