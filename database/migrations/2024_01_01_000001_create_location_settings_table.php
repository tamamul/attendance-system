<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['in', 'out']);
            $table->timestamp('attendance_time');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->enum('location_status', ['valid', 'invalid']);
            $table->decimal('distance', 8, 2)->nullable()->comment('Distance in meters');
            $table->timestamps();
            
            $table->index(['user_id', 'attendance_time']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};