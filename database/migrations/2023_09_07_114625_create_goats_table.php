<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goats', function (Blueprint $table) {
            $table->id(); // Unique identifier for each goat
            $table->boolean('is_active')->default(true); // Boolean indicating whether the goat is currently active
            $table->string('name'); // Name of the goat
            $table->string('breed'); // Breed of the goat
            $table->date('date_of_birth'); // Date of birth of the goat
            $table->enum('gender', ['male', 'female']); // Gender of the goat
            $table->unsignedBigInteger('mother_id')->nullable(); // Foreign key for mother goat (if applicable)
            $table->unsignedBigInteger('father_id')->nullable(); // Foreign key for father goat (if applicable)
            $table->string('image')->nullable(); // Image field to store goat images
            $table->date('purchase_date')->nullable(); // Date when the goat was purchased
            $table->date('sale_date')->nullable(); // Date when the goat was sold
            $table->boolean('is_castrated')->default(false); // Boolean indicating whether the goat is castrated
            $table->date('date_of_death')->nullable(); // Date of death of the goat
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
        Schema::dropIfExists('goats');
    }
}
