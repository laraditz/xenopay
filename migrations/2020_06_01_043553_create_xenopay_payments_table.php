<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXenopayPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xenopay_payments', function (Blueprint $table) {
            $table->id();
            $table->string('tx_id', 50);
            $table->string('ref_no', 50);
            $table->string('currency_code', 5);
            $table->decimal('amount', 30, 2);
            $table->string('description', 100);
            $table->smallInteger('payment_id')->nullable();
            $table->string('username', 100);
            $table->string('email', 150);
            $table->string('contact', 20);
            $table->string('remark', 100)->nullable();
            $table->smallInteger('status')->nullable();
            $table->string('status_description', 100)->nullable();
            $table->string('redirect_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xenopay_payments');
    }
}
