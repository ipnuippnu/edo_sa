<?php

use App\Models\Wilayah;
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
        Schema::create('personal_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            $table->enum('gender', ['L', 'P']);

            $table->string('phone');
            $table->timestamp('phone_verified_at')->nullable();

            $table->string('picture')->nullable();
            $table->string('born_place')->nullable();
            $table->date('born_date')->nullable();

            $table->year('joined_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            // $table->foreignIdFor(Wilayah::class, 'wilayah_kode')->nullable()->constrained();
            $table->string('wilayah_kode')->nullable();
            $table->foreign('wilayah_kode')->references('kode')->on('wilayah');

            $table->string('rt', 3)->nullable();
            $table->string('rw', 3)->nullable();
            $table->string('dusun')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_information');
    }
};
