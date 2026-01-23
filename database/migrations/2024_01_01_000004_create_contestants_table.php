<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contestants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->string('video_url')->nullable();
            $table->integer('total_votes')->default(0);
            $table->enum('status', ['active', 'evicted'])->default('active');
            $table->timestamps();
            
            $table->unique(['category_id', 'slug']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('contestants');
    }
};