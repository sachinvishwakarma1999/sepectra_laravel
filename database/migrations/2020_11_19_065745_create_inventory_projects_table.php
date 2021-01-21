<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_projects', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->integer('type')->default(0);
            $table->integer('color_id')->default(0);
            $table->integer('service_id')->default(0);
            $table->integer('inventory_id')->default(0);
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
        Schema::dropIfExists('inventory_projects');
    }
}
