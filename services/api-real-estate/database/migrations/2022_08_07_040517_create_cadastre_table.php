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
        Schema::create('cadastre', function (Blueprint $table) {
            $table->id();
            $table->integer('fid')->nullable();
            $table->longText('geo_shape')->nullable();
            $table->string('address', 150);
            $table->integer('zip_code')->index('cadastre_zip_code');
            $table->string('suburb', 150)->nullable();
            $table->decimal('ground_surface', 20, 2);
            $table->decimal('construction_surface', 20, 2);
            $table->foreignId('contruction_type_id')->constrained('construction_types');
            $table->string('level_range_key', 10)->nullable();
            $table->integer('construction_year')->nullable();
            $table->boolean('special_facilities')->nullable();
            $table->decimal('land_unit_value', 20, 2);
            $table->decimal('land_value', 20, 2);
            $table->string('land_unit_value_key', 20);
            $table->string('compliance_index_colony', 150)->nullable();
            $table->string('mayors_compliance_index', 150)->nullable();
            $table->decimal('grant_amount', 20, 2);
            $table->decimal('unit_price', 20, 2)->default(0);
            $table->decimal('construction_unit_price', 20, 2)->default(0);
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
        Schema::dropIfExists('cadastre');
    }
};
