<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = ['username', 'password', 'role', 'salary'];

    protected $hidden = ['password', 'token'];

    public function purchaseInvoices()
    {
        return $this->hasMany(PurchaseInvoice::class);
    }
    public function saleInvoices()
    {
        return $this->hasMany(SaleInvoice::class);
    }
}
