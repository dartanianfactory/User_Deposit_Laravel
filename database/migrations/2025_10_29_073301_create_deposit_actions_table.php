<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deposit_actions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['deposit', 'transfer_out', 'transfer_in','withdraw']);
            $table->decimal('amount', 10, 2);
            $table->string('comment')->nullable();
            $table->foreignId('from_user_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreignId('to_user_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deposit_actions');
    }
};
