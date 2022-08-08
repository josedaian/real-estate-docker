<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('construction_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('zip_code')->index('construction_prices_zip_code');
            $table->integer('construction_type_id')->index('construction_prices_contruction_type_id');
            $table->string('price_type')->index('construction_prices_price_type');
            $table->decimal('unit_price', 20, 2);
            $table->decimal('construction_unit_price', 20, 2);
            $table->integer('elements');
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
        Schema::dropIfExists('construction_prices');
    }
};
