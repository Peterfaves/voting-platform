<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ticket_orders', function (Blueprint $table) {
            // Change qr_code from varchar(255) to text to store base64 data
            $table->text('qr_code')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('ticket_orders', function (Blueprint $table) {
            $table->string('qr_code')->nullable()->change();
        });
    }
};