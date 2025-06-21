<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('sale_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_invoice_id')->constrained('sale_invoices')->onDelete('restrict');
            $table->foreignId('batch_id')->constrained('batches')->onDelete('restrict');
            $table->integer('quantity');
            $table->double('price');


            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('sale_invoice_items');
    }
};
