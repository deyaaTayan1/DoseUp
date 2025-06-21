<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceItem extends Model
{
    protected $fillable = ['sale_invoice_id', 'batch_id', 'quantity', 'price'];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    
    public function saleInvoice()
    {
        return $this->belongsTo(SaleInvoice::class);
    }
}
