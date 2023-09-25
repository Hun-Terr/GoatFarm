<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id(); // Unique identifier for each report
            $table->string('title'); // Title of the report
            $table->text('content'); // Content of the report
            $table->date('report_date'); // Date when the report was created or updated
            $table->unsignedBigInteger('goat_id')->nullable(); // Foreign key referencing the GoatID (if applicable)
            $table->string('image')->nullable(); // Image field to store report images (nullable)
            $table->timestamps(); // Created at and updated at timestamps
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
