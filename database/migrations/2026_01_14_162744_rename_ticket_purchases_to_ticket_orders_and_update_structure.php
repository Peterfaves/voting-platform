<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Rename ticket_purchases to ticket_orders
        Schema::rename('ticket_purchases', 'ticket_orders');
        
        // Update tickets table - add missing columns
        Schema::table('tickets', function (Blueprint $table) {
            if (!Schema::hasColumn('tickets', 'benefits')) {
                $table->json('benefits')->nullable();
            }
            if (!Schema::hasColumn('tickets', 'sold')) {
                $table->integer('sold')->default(0);
            }
            if (!Schema::hasColumn('tickets', 'sale_start')) {
                $table->timestamp('sale_start')->nullable();
            }
            if (!Schema::hasColumn('tickets', 'sale_end')) {
                $table->timestamp('sale_end')->nullable();
            }
            if (!Schema::hasColumn('tickets', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active');
            }
        });
        
        // Update ticket_orders table - add missing columns
        Schema::table('ticket_orders', function (Blueprint $table) {
            // Check and add order_number if it doesn't exist
            if (!Schema::hasColumn('ticket_orders', 'order_number')) {
                $table->string('order_number')->unique()->nullable();
            }
            
            // Check and add buyer details
            if (!Schema::hasColumn('ticket_orders', 'buyer_name')) {
                $table->string('buyer_name')->nullable();
            }
            if (!Schema::hasColumn('ticket_orders', 'buyer_email')) {
                $table->string('buyer_email')->nullable();
            }
            if (!Schema::hasColumn('ticket_orders', 'buyer_phone')) {
                $table->string('buyer_phone')->nullable();
            }
            
            // Check and add pricing columns
            if (!Schema::hasColumn('ticket_orders', 'unit_price')) {
                $table->decimal('unit_price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('ticket_orders', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->nullable();
            }
            
            // Check and add payment columns
            if (!Schema::hasColumn('ticket_orders', 'payment_reference')) {
                $table->string('payment_reference')->unique()->nullable();
            }
            if (!Schema::hasColumn('ticket_orders', 'payment_method')) {
                $table->string('payment_method')->nullable();
            }
            if (!Schema::hasColumn('ticket_orders', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'success', 'failed'])->default('pending');
            }
            
            // Check and add status
            if (!Schema::hasColumn('ticket_orders', 'status')) {
                $table->enum('status', ['active', 'used', 'cancelled', 'refunded'])->default('active');
            }
            
            // Check and add QR code
            if (!Schema::hasColumn('ticket_orders', 'qr_code')) {
                $table->string('qr_code')->nullable();
            }
            
            // Check and add usage tracking
            if (!Schema::hasColumn('ticket_orders', 'used_at')) {
                $table->timestamp('used_at')->nullable();
            }
            if (!Schema::hasColumn('ticket_orders', 'used_by')) {
                $table->string('used_by')->nullable();
            }
        });
        
        // Generate order numbers for existing records that don't have them
        DB::statement("
            UPDATE ticket_orders 
            SET order_number = CONCAT('TKT-', UPPER(LEFT(MD5(CONCAT(id, UNIX_TIMESTAMP())), 10)))
            WHERE order_number IS NULL OR order_number = ''
        ");
        
        // Generate payment references for existing records
        DB::statement("
            UPDATE ticket_orders 
            SET payment_reference = CONCAT('PAY-', UPPER(LEFT(MD5(CONCAT(id, 'payment', UNIX_TIMESTAMP())), 12)))
            WHERE payment_reference IS NULL OR payment_reference = ''
        ");
    }

    public function down()
    {
        Schema::rename('ticket_orders', 'ticket_purchases');
    }
};