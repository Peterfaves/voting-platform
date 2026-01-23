<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('votes', function (Blueprint $table) {
            // Add number_of_votes if it doesn't exist
            if (!Schema::hasColumn('votes', 'number_of_votes')) {
                $table->integer('number_of_votes')->nullable()->after('voter_phone');
            }
            
            // Add payment_method if it doesn't exist
            if (!Schema::hasColumn('votes', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('payment_status');
            }
        });

        // Copy data from vote_count to number_of_votes for existing records
        DB::statement('UPDATE votes SET number_of_votes = vote_count WHERE number_of_votes IS NULL');
    }

    public function down()
    {
        Schema::table('votes', function (Blueprint $table) {
            if (Schema::hasColumn('votes', 'number_of_votes')) {
                $table->dropColumn('number_of_votes');
            }
            if (Schema::hasColumn('votes', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
        });
    }
};