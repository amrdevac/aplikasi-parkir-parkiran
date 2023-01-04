<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_payments', function (Blueprint $table) {
            $table->id();
            $table->string("uuid_parkir")->index();
            $table->string("total_pembayaran");
            $table->string("total_waktu");
            $table->string("metode_pembayaran");
            $table->integer("id_user");
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
        Schema::dropIfExists('parking_payments');
    }
}
