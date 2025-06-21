<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    protected $fillable = ['user_id', 'supplier_id', 'date', 'invoice_number', 'total_price'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

   
}
