<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ticket_orders', function (Blueprint $table) {
            // Remove ticket_code if it exists
            if (Schema::hasColumn('ticket_orders', 'ticket_code')) {
                $table->dropColumn('ticket_code');
            }
            
            // Ensure all required columns exist
            if (!Schema::hasColumn('ticket_orders', 'order_number')) {
                $table->string('order_number')->unique()->after('id');
            }
            
            if (!Schema::hasColumn('ticket_orders', 'buyer_name')) {
                $table->string('buyer_name')->after('user_id');
            }
            
            if (!Schema::hasColumn('ticket_orders', 'buyer_email')) {
                $table->string('buyer_email')->after('buyer_name');
            }
            
            if (!Schema::hasColumn('ticket_orders', 'buyer_phone')) {
                $table->string('buyer_phone')->nullable()->after('buyer_email');
            }
            
            if (!Schema::hasColumn('ticket_orders', 'unit_price')) {
                $table->decimal('unit_price', 10, 2)->after('quantity');
            }
            
            if (!Schema::hasColumn('ticket_orders', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->after('unit_price');
            }
            
            if (!Schema::hasColumn('ticket_orders', 'payment_reference')) {
                $table->string('payment_reference')->unique()->after('total_amount');
            }
            
            if (!Schema::hasColumn('ticket_orders', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('payment_reference');
            }
            
            if (!Schema::hasColumn('ticket_orders', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'success', 'failed'])->default('pending')->after('payment_method');
            }
            
            if (!Schema::hasColumn('ticket_orders', 'status')) {
                $table->enum('status', ['active', 'used', 'cancelled', 'refunded'])->default('active')->after('payment_status');
            }
            
            if (!Schema::hasColumn('ticket_orders', 'qr_code')) {
                $table->string('qr_code')->nullable()->after('status');
            }
            
            if (!Schema::hasColumn('ticket_orders', 'used_at')) {
                $table->timestamp('used_at')->nullable()->after('qr_code');
            }
            
            if (!Schema::hasColumn('ticket_orders', 'used_by')) {
                $table->string('used_by')->nullable()->after('used_at');
            }
        });
    }

    public function down()
    {
        // Optional: Add rollback logic if needed
    }
};