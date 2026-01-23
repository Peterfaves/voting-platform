<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->string('gateway_transaction_id')->nullable()->after('payment_reference');
            $table->string('gateway_reference')->nullable()->after('gateway_transaction_id');
            $table->json('gateway_metadata')->nullable()->after('gateway_reference');
            $table->timestamp('verified_at')->nullable()->after('payment_status');
            $table->index('gateway_transaction_id');
        });
    }

    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropColumn(['gateway_transaction_id', 'gateway_reference', 'gateway_metadata', 'verified_at']);
        });
    }
};