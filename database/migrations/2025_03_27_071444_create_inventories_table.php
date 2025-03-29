<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->date('date_request')->nullable();
            $table->string('item_code')->unique(); // ✅ Ensure item codes are unique
            $table->string('item_description')->nullable();
            $table->integer('beg_inv')->default(0);
            $table->integer('delivery')->default(0);
            $table->integer('stock_out')->default(0);
            $table->integer('end_inv')->default(0);
            $table->json('summary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
};
