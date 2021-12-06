<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            $table->integer('category_id')->nullable(false);
            $table->string('delay', 191)->nullable(false);
            $table->text('select_field')->nullable();
            $table->decimal('fixed_charge', 18, 8)->default(0);
            $table->decimal('percent_charge', 18, 8)->default(0);
            $table->text('description')->nullable();
            $table->text('user_data')->nullable(false);

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
        Schema::dropIfExists('services');
    }
}
