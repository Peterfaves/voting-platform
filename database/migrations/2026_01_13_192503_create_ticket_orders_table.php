<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ticket_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('order_number')->unique();
            $table->string('buyer_name');
            $table->string('buyer_email');
            $table->string('buyer_phone')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_reference')->unique();
            $table->string('payment_method')->nullable();
            $table->enum('payment_status', ['pending', 'success', 'failed'])->default('pending');
            $table->enum('status', ['active', 'used', 'cancelled', 'refunded'])->default('active');
            $table->string('qr_code')->nullable(); // Path to QR code image
            $table->timestamp('used_at')->nullable();
            $table->string('used_by')->nullable(); // Who scanned/validated the ticket
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_orders');
    }
};