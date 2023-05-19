<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaultEarnings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vault_earnings', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->integer('amount');//品数
            $table->integer('taxinclude_price');//1品の税込み価格
            $table->integer('taxinclude_price_amount');//複数合計の税込み価格
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
        Schema::dropIfExists('vault_earnings');
    }
}
