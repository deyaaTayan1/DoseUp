<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'medicine_id',
        'purchase_invoice_id',
        'batch_number',
        'quantity',
        'purchase_price',
        'expiration_date'
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function purchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class);
    }

    public function saleInvoiceItems()
    {
        return $this->hasMany(SaleInvoiceItem::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
