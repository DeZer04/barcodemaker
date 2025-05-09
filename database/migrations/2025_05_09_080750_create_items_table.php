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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name_item')->nullable();
            $table->foreignId('grade_id')->constrained('grades')->onDelete('cascade');
            $table->foreignId('finishing_id')->constrained('finishings')->onDelete('cascade');
            $table->foreignId('jenisanyam_id')->constrained('jenisanyams')->onDelete('cascade');
            $table->foreignId('warnaanyam_id')->constrained('warnaanyams')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
