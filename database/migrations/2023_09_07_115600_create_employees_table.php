<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // Unique identifier for each employee
            $table->boolean('is_active')->default(true); // Boolean indicating whether the employee is currently active
            $table->string('name'); // Name of the employee
            $table->string('contact_information')->nullable(); // Contact information of the employee (phone, email, etc.)
            $table->string('role'); // Role or position of the employee
            $table->decimal('salary', 10, 2); // Salary of the employee (use appropriate precision and scale)
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
        Schema::dropIfExists('employees');
    }
}
