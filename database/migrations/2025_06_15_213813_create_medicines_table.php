<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scientific_name_id')->constrained('scientific_names')->onDelete('restrict');
            $table->string('trade_name');
            $table->string('manufacturer_name');
            $table->string('barcode')->unique();
            $table->double('selling_price');
            $table->enum('type' , ['tablet' , 'syrup' , 'injection' , 'ointment' , 'cream' , 'drops']);
            $table->string('dose');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
