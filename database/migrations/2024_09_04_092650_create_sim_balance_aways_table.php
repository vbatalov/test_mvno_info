<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sim_balance_aways', function (Blueprint $table) {
            $table->id();
            $table->decimal("amount");
            $table->foreignId("iccid")->constrained("sims", "iccid")->nullOnDelete();
            $table->string("comment")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sim_balance_aways');
    }
};
