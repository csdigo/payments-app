<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("governmentId");
            $table->string("email");
            $table->decimal("debtAmount", 18, 2);
            $table->timestamp("debtDueDate");
            $table->integer("debtId");
            $table->boolean("paid")->default(false);
            $table->timestamp("paidAt")->nullable();
            $table->decimal("paidAmount", 18, 2)->nullable();
            $table->string("paidBy")->nullable();
            $table->string("barCode", 44)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};