<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users') ;
            $table->string('invoice_number')->unique();
            $table->dateTime('date');
            $table->double('total_price');



            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('sale_invoices');
    }
};
