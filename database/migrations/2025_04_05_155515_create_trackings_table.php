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
        Schema::create('trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('requests')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('updated_by')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('request_status_id')->constrained('request_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->text('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trackings');
    }
};
