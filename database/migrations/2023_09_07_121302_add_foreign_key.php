<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Add foreign key for the 'goat_id' column
            $table->foreign('goat_id')
                ->references('id')
                ->on('goats');

            // Add foreign key for the 'report_id' column
            $table->foreign('report_id')
                ->references('id')
                ->on('reports');

            // Add foreign key for the 'customer_id' column
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers');
        });

        Schema::table('health_records', function (Blueprint $table) {
            // Add foreign key for the 'goat_id' column
            $table->foreign('goat_id')
                ->references('id')
                ->on('goats');
        });

        Schema::table('reports', function (Blueprint $table) {
            // Add foreign key for the 'goat_id' column
            $table->foreign('goat_id')
                ->references('id')
                ->on('goats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Remove the foreign key constraints
            $table->dropForeign(['goat_id']);
            $table->dropForeign(['report_id']);
            $table->dropForeign(['customer_id']);
        });

        Schema::table('health_records', function (Blueprint $table) {
            // Remove the foreign key constraint
            $table->dropForeign(['goat_id']);
        });

        Schema::table('reports', function (Blueprint $table) {
            // Remove the foreign key constraint
            $table->dropForeign(['goat_id']);
        });
    }
}
