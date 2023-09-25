<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_records', function (Blueprint $table) {
            $table->id(); // Unique identifier for each health record
            $table->unsignedBigInteger('goat_id'); // Foreign key referencing the GoatID of the associated goat
            $table->date('date'); // Date when the vaccine was administered
            $table->text('notes')->nullable(); // Additional notes or observations (nullable)
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('health_records');
    }
}
