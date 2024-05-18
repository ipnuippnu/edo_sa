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
        Schema::create('pimpinans', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->index();

            $table->string('address_code')->nullable();
            
            $table->string('name')->unique();
            $table->string('display_name')->fulltext()->nullable();
            $table->string('description')->nullable();

            $table->enum('level', ['PC', 'PAC', 'PR', 'PK']);
            $table->enum('banom', ['IPNU', 'IPPNU']);
            $table->string('picture')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pimpinans');
    }
};
