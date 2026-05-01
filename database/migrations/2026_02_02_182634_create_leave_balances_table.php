<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('leave_balances', function (Blueprint $table) {
        $table->id();
        $table->string('employee_id');
        $table->integer('casual_total')->default(10);
        $table->integer('casual_used')->default(0);
        $table->integer('sick_total')->default(10);
        $table->integer('sick_used')->default(0);
        $table->integer('annual_total')->default(20);
        $table->integer('annual_used')->default(0);
        $table->integer('total_leaves')->default(40);
        $table->integer('used_leaves')->default(0);
        $table->integer('remaining_leaves')->default(40);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};
