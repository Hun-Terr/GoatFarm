<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Unique identifier for each transaction
            $table->unsignedBigInteger('goat_id')->nullable(); // Foreign key referencing the GoatID of the associated goat
            $table->date('transaction_date'); // Date of the transaction
            $table->string('type'); // Type of transaction (e.g., Purchase, Sale, Health Check, etc.)
            $table->text('description'); // Description of the transaction
            $table->decimal('amount', 10, 2); // Amount of the transaction (use appropriate precision and scale)
            $table->unsignedBigInteger('customer_id')->nullable(); // Foreign key referencing the CustomerID (if applicable)
            $table->unsignedBigInteger('report_id')->nullable(); // Foreign key referencing the ReportID (if applicable)
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
        Schema::dropIfExists('transactions');
    }
}
