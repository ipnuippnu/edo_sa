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

            $table->string('parent_address_code');
            $table->string('child_address_code')->nullable();
            $table->string('name');
            $table->enum('level', ['PC', 'PAC', 'PR', 'PK']);
            $table->enum('type', ['IPNU', 'IPPNU']);
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
