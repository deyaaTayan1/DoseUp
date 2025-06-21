<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('restrict'); // not allowed to delete medicine if it has batches 
            $table->foreignId('purchase_invoice_id')->constrained('purchase_invoices')->onDelete('restrict'); // not allowed to delete invoice if it has batch
            $table->string('batch_number');
            $table->integer('quantity');
            $table->double('purchase_price');
            $table->date('expiration_date');
            

            
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
