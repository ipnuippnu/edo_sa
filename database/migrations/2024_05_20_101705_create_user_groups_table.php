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
        Schema::create('user_groups', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pimpinan_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('code');
            $table->string('name');

            $table->timestamp('confirmed_at')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->unique(['pimpinan_id', 'code', 'name']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_groups');
    }
};
