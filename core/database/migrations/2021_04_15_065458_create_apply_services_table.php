<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplyServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apply_services', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable(false);
            $table->integer('service_id')->nullable(false);
            $table->decimal('amount', 18, 8)->default(0);
            $table->decimal('total_charge', 18, 8)->default(0);
            $table->decimal('after_charge', 18, 8)->default(0);
            $table->decimal('post_balance', 18, 8)->default(0);
            $table->text('select_field')->nullable();
            $table->longText('user_data')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=>Applied, 1=>Pending, 2=>Approved, 3=>Cancaled');
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
        Schema::dropIfExists('apply_services');
    }
}
