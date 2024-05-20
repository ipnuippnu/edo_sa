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
        Schema::create('user_jabatans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained();
            $table->foreignId('jabatan_id')->constrained();
            $table->foreignId('pimpinan_id')->constrained();
            
            $table->date('from')->nullable();
            $table->date('until')->nullable();
            $table->timestamp('confirmed_at')->nullable();

            $table->string('status');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_jabatans');
    }
};
