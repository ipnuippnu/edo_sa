<?php

use App\Models\FormalTrainingLevel;
use App\Models\User;
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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            
            $table->boolean('is_formal')->default(true);
            
            $table->string('name');
            $table->string('pelaksana');
            $table->string('year', 4);
            $table->foreignIdFor(User::class, 'creator_id')->nullable()->constrained('users');

            $table->fullText(['name', 'pelaksana', 'year']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
