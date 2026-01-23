<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., "VIP", "Regular", "Early Bird"
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity'); // Total available
            $table->integer('sold')->default(0); // Number sold
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('sale_start')->nullable();
            $table->timestamp('sale_end')->nullable();
            $table->json('benefits')->nullable(); // Array of ticket benefits
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};