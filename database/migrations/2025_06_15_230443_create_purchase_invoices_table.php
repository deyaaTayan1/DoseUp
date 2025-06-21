<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
            $table->dateTime('date');
            $table->string('invoice_number')->unique();
            $table->double('total_price');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('purchase_invoices');
    }
};
