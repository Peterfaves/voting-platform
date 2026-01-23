<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contestant_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('voter_name');
            $table->string('voter_email');
            $table->string('voter_phone')->nullable();
            $table->integer('vote_count')->default(1);
            $table->decimal('amount_paid', 10, 2);
            $table->string('payment_reference')->unique();
            $table->enum('payment_status', ['pending', 'success', 'failed'])->default('pending');
            $table->timestamps();
            
            $table->index(['contestant_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('votes');
    }
};