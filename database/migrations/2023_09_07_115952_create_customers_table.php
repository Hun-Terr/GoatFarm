<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); // Unique identifier for each customer
            $table->string('name'); // Name of the customer
            $table->string('contact_information')->nullable(); // Contact information of the customer (phone, email, etc.)
            $table->string('address')->nullable(); // Address of the customer
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
        Schema::dropIfExists('customers');
    }
}
